<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Helper\Helper;
use App\User;
use App\newPreview;
use App\newPreviewType;
use App\newFeedback;
use App\newVersion;
use App\newBanner;
use App\Sizes;
use App\Logo;
use App\BannerSizes;

class PreviewController extends Controller
{
    function viewPreviews(){

        $data = newPreview::orderBy('created_at', 'ASC')->get();
        return view('newpreview.previews', compact('data'));
    }

    function addPreviewsView(){
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('newpreview.addpreviews', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    function addPreviewsPost(Request $request){
        $project_type = $request->project_type;
        $logo_details = Logo::where('id', $request->logo_id)->first();

        $pro_name = $request->project_name;
        $project_name = str_replace(" ", "_", $request->project_name);

        $goTo = Helper::getWebsiteOfLogo($request->logo_id);

        $main_project = new newPreview;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $logo_details['default_color'];
        $main_project->is_logo = 1;
        $main_project->is_footer = $request->is_footer;
        $main_project->is_version = 0;
        $main_project->uploaded_by_user_id = Auth::user()->id;
        $main_project->uploaded_by_company_id = Auth::user()->company_id;
        $main_project->save();

        $projectType = new newPreviewType;
        $projectType->project_id = $main_project->id;
        $projectType->project_type = $project_type;
        $projectType->save();

        $feedback = new newFeedback;
        $feedback->project_id = $main_project->id;
        $feedback->name = $request->feedback_name;
        $feedback->type_id = $project_type;
        $feedback->description = $request->feedback_description;
        $feedback->is_active = 1;
        $feedback->save();

        $version = new newVersion;
        $version->name = $request->version_name;
        $version->feedback_id = $feedback->id;
        $version->is_active = 1;
        $version->save();

        if($project_type == 1){
            //this is banner upload method
            if($request->hasfile('bannerupload')){
                $banner_size = $request->banner_size_id;
                $bannerupload = $request->bannerupload;

                foreach($banner_size as $index => $size){
                    $removeX = explode("x", $size);
                    $request_width = $removeX[0];
                    $request_height = $removeX[1];
                    $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                    $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . rand() . '.' . $bannerupload[$index]->extension();
                    $bannerupload[$index]->move(public_path('new_showcase_collection/'), $file_name);
                    $file_bytes = filesize(public_path('new_showcase_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $banner = new newBanner;
                    $banner->name = $sub_project_name;
                    $banner->size = $file_size;
                    $newFileName = str_replace(".zip", "", $file_name);
                    $banner->file_path = $newFileName;
                    $banner->size_id = $size_info['id'];
                    $banner->version_id = $version->id;
                    $banner->save();
    
                    $zip = new ZipArchive();
                    $file_path = str_replace(".zip", "", $file_name);
                    $directory = 'new_showcase_collection/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('new_showcase_collection/' . $file_name) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                        unlink('new_showcase_collection/' . $file_name);
                    }
                }
            }
        }
        else if($request->project_type == 2){
            //this is video upload method
            dd('this is video');
        }
        else if($request->project_type == 3){
            //this is gif upload method
            dd('this is gif');
        }
        else if($request->project_type == 4){
            //this is social upload method
            dd('this is social');
        }
        else{
            return back()->with('danger', 'Pleae select correct project type');
        }
    }

    function editPreviewView($project_id){
        $project_name = newPreview::where('id', $project_id)->first();
        $naming_convention = str_replace(" ", "_", $project_name['name']);
        $logo_list = Logo::get();
        $project_info = newPreview::where('id', $project_id)->first();
        return view('newpreview.editpreviews', compact('logo_list', 'project_info', 'project_id', 'naming_convention'));
    }

    function editPreviewPost(Request $request, $project_id){
        $pro_name = $request->project_name;
        $old_project_details = newPreview::where('id', $project_id)->first();
        $project_name = str_replace(" ", "_", $request->project_name);
        // $old_project_name = str_replace(" ", "_", $old_project_details['name']);

        $main_project_details = [
            'name' => $pro_name,
            'client_name' => $request->client_name,
            'logo_id' => $request->logo_id,
            'color' => $request->color,
            'is_logo' => $request->is_logo,
            'is_footer' => $request->is_footer
        ];

        newPreview::where('id', $project_id)->update($main_project_details);
        return redirect('/view-previews')->with('success', $project_name . ' has been updated!');
    }
}
