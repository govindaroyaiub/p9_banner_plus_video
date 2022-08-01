<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\User;
use App\MainProject;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use App\BannerCategories;
use App\Feedback;
use App\Banner;
use App\Helper\Helper;

class bannerShowcaseController extends Controller
{
    public function bannerShowcaseList(){
        $data = MainProject::where('project_type', 4)->get();
        return view('view_bannershowcase.showcase-list', compact('data'));
    }

    public function banner_project_add_view(){
        //show the banner project add page
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('view_bannershowcase.showcase-add', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function banner_project_add_post(Request $request){
        //post function to insert the banner(s)
        $validator = $request->validate([
            'upload' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip',
        ]);

        if($request->hasfile('upload')){
            $pro_name = $request->project_name;
            $project_name = str_replace(" ", "_", $request->project_name);

            $main_project = new MainProject;
            $main_project->name = $pro_name;
            $main_project->client_name = $request->client_name;
            $main_project->logo_id = $request->logo_id;
            $main_project->color = $request->color;
            $main_project->is_logo = 1;
            $main_project->is_footer = 1;
            $main_project->project_type = 4;
            $main_project->is_version = 0;
            $main_project->uploaded_by_user_id = Auth::user()->id;
            $main_project->uploaded_by_company_id = Auth::user()->company_id;
            $main_project->save();

            $feedback = new Feedback;
            $feedback->project_id = $main_project->id;
            $feedback->name = $request->feedback_name;
            $feedback->is_open = 1;
            $feedback->save();

            $category = new BannerCategories;
            $category->name = $request->category_name;
            $category->project_id = $main_project->id;
            $category->feedback_id = $feedback->id;
            $category->save();

            $banner_size = $request->banner_size_id;
            $upload = $request->upload;

            foreach($banner_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $upload[$index]->extension();
                $upload[$index]->move(public_path('showcase_collection/'), $file_name);
                $file_bytes = filesize(public_path('showcase_collection/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $banner = new Banner;
                $banner->name = $sub_project_name;
                $banner->size = $file_size;
                $newFileName = str_replace(".zip", "", $file_name);
                $banner->file_path = $newFileName;
                $banner->size_id = $size_info['id'];
                $banner->project_id = $main_project->id;
                $banner->feedback_id = $feedback->id;
                $banner->category_id = $category->id;
                $banner->save();

                $zip = new ZipArchive();
                $file_path = str_replace(".zip", "", $file_name);
                $directory = 'showcase_collection/' . $file_path;
                if (!is_dir($directory)) {
                    if ($zip->open('showcase_collection/' . $file_name) === TRUE) {
                        // Unzip Path
                        $zip->extractTo($directory);
                        $zip->close();
                    }
                    unlink('showcase_collection/' . $file_name);
                }
            }

            return redirect('/project/banner-showcase/view/' . $main_project->id);
        }
    }

    public function banner_project_edit_view(){
        //show the banner project edit page
    }

    public function banner_project_edit_post(){
        //post function to update the project
    }

    public function banner_project_delete($id){
        //delete function to remove the entire project
        $main_project_info = MainProject::where('id', $id)->first();

        $banner_info = Banner::where('project_id', $id)->get();
        if (($banner_info->count() != 0)) {
            foreach ($banner_info as $banner) {
                $file_path = public_path() . '/showcase_collection/' . str_replace(".zip", "", $banner['file_path']);
                if(file_exists($file_path)){
                    $files = File::deleteDirectory($file_path);
                }
                Banner::where('id', $banner->id)->delete();
            }
        }
        Feedback::where('project_id', $id)->delete();
        BannerCategories::where('project_id', $id)->delete();
        MainProject::where('id', $id)->delete();
        return redirect('/banner-showcase')->with('danger', $main_project_info['name'] . ' been deleted along with assets!');
    }

    public function banner_add_feedback_view(){
        //show the banner add on page. where the banner can be uploaded to the existing preview or create a new feeback round
    }

    public function banner_add_feedback_post(){
        //post function to insert the add on banners. here the main logic will reside into the database
    }

    public function banner_edit_feedback_view(){
        //banner feedback edit page
    }

    public function banner_edit_feedback_post(){
        //post function to update the banner feedback id
    }

    public function banner_delete_feedback(){
        //delete the banner feedback id and as well as directories
    }

    public function banner_index_view_delete(){
        //this is the Delete All Button click action where the banners will be deleted but the project itself will stay
    }

    public function banner_add_category_view(){
        //banner add category page from the preview page
    }

    public function banner_add_category_post(){
        //post function to add a category inside the feedback
    }

    public function banner_edit_category_view(){
        //category edit function view
    }

    public function banner_edit_category_post(){
        //post function to update the category
    }

    public function banner_delete_category(){
        //delete the category
    }
}
