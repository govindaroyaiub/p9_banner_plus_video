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
        if($request->project_type == 1){
            //this is banner upload method
            if($request->hasfile('bannerupload')){
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
    
                $banner_size = $request->banner_size_id;
                $upload = $request->upload;
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
}
