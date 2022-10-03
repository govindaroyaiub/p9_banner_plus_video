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
        if(Auth::user()->company_id == 1){
            $data = MainProject::where('project_type', 4)->orderBy('created_at', 'DESC')->get();
        }
        else{
            $data = MainProject::where('project_type', 4)->where('logo_id', Auth::user()->company_id)->orderBy('created_at', 'DESC')->get();
        }
        return view('view_bannershowcase.showcase-list', compact('data'));
    }

    public function banner_project_add_view(){
        //show the banner project add page
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
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
            $logo_details = Logo::where('id', $request->logo_id)->first();

            $pro_name = $request->project_name;
            $project_name = str_replace(" ", "_", $request->project_name);

            $main_project = new MainProject;
            $main_project->name = $pro_name;
            $main_project->client_name = $request->client_name;
            $main_project->logo_id = $request->logo_id;
            $main_project->color = $logo_details['default_color'];
            $main_project->is_logo = 1;
            $main_project->is_footer = $request->is_footer;
            $main_project->project_type = 4;
            $main_project->is_version = 0;
            $main_project->uploaded_by_user_id = Auth::user()->id;
            $main_project->uploaded_by_company_id = Auth::user()->company_id;
            $main_project->save();

            $feedback = new Feedback;
            $feedback->project_id = $main_project->id;
            $feedback->name = $request->feedback_name;
            $feedback->description = $request->feedback_description;
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

    public function banner_project_edit_view($project_id){
        //show the banner project edit page
        $project_name = MainProject::where('id', $project_id)->first();
        $naming_convention = str_replace(" ", "_", $project_name['name']);
        $logo_list = Logo::get();
        $project_info = MainProject::where('id', $project_id)->first();
        return view('view_bannershowcase.showcase-edit', compact('logo_list', 'project_info', 'project_id', 'naming_convention'));
    }

    public function banner_project_edit_post(Request $request, $project_id){
        //post function to update the project
        $pro_name = $request->project_name;
        $old_project_details = MainProject::where('id', $project_id)->where('project_type', 4)->first();
        $project_name = str_replace(" ", "_", $request->project_name);
        $old_project_name = str_replace(" ", "_", $old_project_details['name']);

        $sub_projects = Banner::where('project_id', $project_id)->get();

        $main_project_details = [
            'name' => $pro_name,
            'client_name' => $request->client_name,
            'logo_id' => $request->logo_id,
            'color' => $request->color,
            'is_logo' => $request->is_logo,
            'is_footer' => $request->is_footer
        ];

        MainProject::where('id', $project_id)->update($main_project_details);
        return redirect('/banner-showcase')->with('success', $project_name . ' has been updated!');
    }

    public function banner_project_delete($id){
        //delete function to remove the entire project
        $main_project_info = MainProject::where('id', $id)->first();
        $project_name = $main_project_info['name'];

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
        return redirect('/banner-showcase')->with('danger', $project_name. ' been deleted along with assets!');
    }

    public function banner_add_feedback_view($id){
        //show the banner add on page. where the banner can be uploaded to the existing preview or create a new feeback round
        $main_project_id = $id;
        $project_info = MainProject::where('id', $id)->first();
        $version_status = $project_info['is_version'];
        $feedbackCount = Feedback::where('project_id', $main_project_id)->count();
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('view_bannershowcase.showcase_addon', compact('size_list', 'main_project_id', 'feedbackCount', 'version_status'));
    }

    public function banner_add_feedback_post(Request $request, $id){
        //post function to insert the add on banners. here the main logic will reside into the database
        $validator = $request->validate([
            'upload' => 'required',
            'feedback_request' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip'
        ]);

        $feedback_request = $request->feedback_request;

        if($feedback_request!= 0){
            $main_project_id = $id;
            $project_info = MainProject::where('id', $main_project_id)->first();

            if($feedback_request == 1){
                //check version exists or not
                //if null then create one
                $feedback_info = Feedback::where('project_id', $project_info['id'])->first();

                if($feedback_info == NULL){
                    $feedback = new Feedback;
                    $feedback->project_id = $main_project_id;
                    $feedback->description = 'Master Development Started';
                    $feedback->name = 'Feedback Round 1';
                    $feedback->is_open = 1;
                    $feedback->save();
                    $feedback_id = $feedback->id;

                    $category = new BannerCategories;
                    $category->name ='Default';
                    $category->project_id = $main_project_id;
                    $category->feedback_id = $feedback->id;
                    $category->save();
                    $category_id = $category->id;
                }
                else{
                    $feedback_id = $feedback_info['id'];
                    $category_info = BannerCategories::where('feedback_id', $feedback_id)->first();
                    $category_id = $category_info['id'];
                }
            }
            else{
                $feedback = new Feedback;
                $feedback->name = $request->feedback_name;
                $feedback->description = $request->feedback_description;
                $feedback->project_id = $main_project_id;
                $feedback->is_open = 1;
                $feedback->save();
                $feedback_id = $feedback->id;

                $category = new BannerCategories;
                $category->name ='Default';
                $category->project_id = $main_project_id;
                $category->feedback_id = $feedback->id;
                $category->save();
                $category_id = $category->id;

                MainProject::where('id', $main_project_id)->update(['is_version' => 1]);
            }

            if($request->hasfile('upload')){
                $banner_size = $request->banner_size_id;
                $upload = $request->upload;
                $array = [];
                foreach($banner_size as $index => $size){
                    $removeX = explode("x", $size);
                    $request_width = $removeX[0];
                    $request_height = $removeX[1];
                    $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                    $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . rand() . '.' . $upload[$index]->extension();
                    $upload[$index]->move(public_path('showcase_collection'), $file_name);
                    $file_bytes = filesize(public_path('/showcase_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $banner = new Banner;
                    $banner->name = $sub_project_name;
                    $banner->project_id = $main_project_id;
                    $banner->size_id = $size_info['id'];
                    $banner->size = $file_size;
                    $banner->category_id = $category_id;
                    $banner->feedback_id = $feedback_id;
                    $newFileName = str_replace(".zip", "", $file_name);
                    $banner->file_path = $newFileName;
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
        
                return redirect('/project/banner-showcase/view/' . $main_project_id);
            }
        }
        else{
            return back();
        }
    }

    public function banner_edit_feedback_view($project_id, $feedback_id){
        //banner feedback edit page
        $feedback_info = Feedback::where('id', $feedback_id)->first();
        $project_info = MainProject::where('id', $project_id)->first();
        $project_name = $project_info['name'];
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('view_bannershowcase.feedback-edit', compact('project_id', 'feedback_id', 'project_name', 'size_list', 'feedback_info'));
    }

    public function banner_edit_feedback_post(Request $request, $project_id, $feedback_id){
        //post function to update the banner feedback id
        Feedback::where('id', $feedback_id)->update(
            [
                'name' => $request->feedback_name,
                'description' => $request->feedback_description
            ]
        );
        $project_info = MainProject::where('id', $project_id)->first();
        
        //if request has uploads then firstd elete the current banners then add the new ones
        if($request->has('upload')){
            $banners = Banner::where('project_id', $project_id)->where('feedback_id', $feedback_id)->get();

            if (($banners->count() != 0)) {
                foreach ($banners as $banner) {
                    $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
                    if(file_exists($file_path)){
                        // unlink('banner_collection/' . $sub_project['file_path']);
                        $files = File::deleteDirectory($file_path);
                    }
                }
                Banner::where('feedback_id', $feedback_id)->delete();
                BannerCategories::where('feedback_id', $feedback_id)->delete();
            }

            $category = new BannerCategories;
            $category->name ='Default';
            $category->project_id = $project_id;
            $category->feedback_id = $feedback_id;
            $category->save();
            $category_id = $category->id;
            
            $banner_size = $request->banner_size_id;
            $upload = $request->upload;
            $array = [];

            foreach($banner_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $upload[$index]->extension();
                $upload[$index]->move(public_path('showcase_collection'), $file_name);
                $file_bytes = filesize(public_path('/showcase_collection/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $banner = new Banner;
                $banner->name = $sub_project_name;
                $banner->project_id = $project_id;
                $banner->size_id = $size_info['id'];
                $banner->size = $file_size;
                $banner->feedback_id = $feedback_id;
                $banner->category_id = $category_id;
                $newFileName = str_replace(".zip", "", $file_name);
                $banner->file_path = $newFileName;
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
        }
        return redirect('/project/banner-showcase/view/' . $project_id);
    }

    public function banner_delete_feedback($project_id, $feedback_id){
        //delete the banner feedback id and as well as directories
        $project_info = MainProject::where('id', $project_id)->first();
        $banners = Banner::where('project_id', $project_id)->where('feedback_id', $feedback_id)->get();
        if (($banners->count() != 0)) {
            foreach ($banners as $banner) {
                $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
                if(file_exists($file_path)){
                    // unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
                }
                Banner::where('id', $banner->id)->delete();
            }
        }

        Feedback::where('id', $feedback_id)->delete();
        BannerCategories::where('feedback_id', $feedback_id)->delete();

        $feedbackCount = Feedback::where('project_id', $project_id)->count();

        if($feedbackCount == 1){
            MainProject::where('id', $project_id)->update(['is_version' => 0]);
        }
        return back();
    }

    public function banner_index_view_delete($project_id){
        //this is the Delete All Button click action where the banners will be deleted but the project itself will stay
        $banners = Banner::where('project_id', $project_id)->get();
        if (($banners->count() != 0)) {
            foreach ($banners as $banner) {
                $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
                if(file_exists($file_path)){
                    // unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
                }
                Banner::where('id', $banner->id)->delete();
            }
        }

        Feedback::where('project_id', $project_id)->delete();
        BannerCategories::where('project_id', $project_id)->delete();
        MainProject::where('id', $project_id)->update(['is_version' => 0]);
        $feedbackCount = Feedback::where('project_id', $project_id)->count();

        return redirect('/project/banner-showcase/addon/'.$project_id)->with('danger', 'Assets been deleted! Please Re-upload.'); 
    }

    public function banner_add_category_view($project_id, $feedback_id){
        //banner add category page from the preview page
        $feedback_info = Feedback::where('id', $feedback_id)->first();
        $project_info = MainProject::where('id', $project_id)->first();
        $project_name = $project_info['name'];
        $feedback_name = $project_info['name'];
        $category_count = BannerCategories::where('feedback_id', $feedback_id)->count();
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('view_bannershowcase.feedback-addon', compact('project_id', 'feedback_id', 'feedback_name', 'project_name', 'size_list', 'category_count'));
    }

    public function banner_add_category_post(Request $request, $project_id, $feedback_id){
        //post function to add a category inside the feedback
        $validator = $request->validate([
            'upload' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        $main_project_id = $project_id;
        $project_info = MainProject::where('id', $main_project_id)->first();
        $feedback_info = Feedback::where('id', $feedback_id)->first();
        $banner_size = $request->banner_size_id;
        $upload = $request->upload;
        $array = [];

        if($request->feedback_request != 0){
            if($request->feedback_request == 1){
                //upoad to existing feedback as add on
                $category_info = BannerCategories::where('feedback_id', $feedback_id)->first();
                $category_id = $category_info['id'];
            }
            else{
                //upload to feedback as different category
                $category = new BannerCategories;
                $category->name = $request->category_name;
                $category->project_id = $main_project_id;
                $category->feedback_id = $feedback_id;
                $category->save();
                $category_id = $category->id;
            }

            if($request->hasfile('upload')){
                foreach($banner_size as $index => $size){
                    $removeX = explode("x", $size);
                    $request_width = $removeX[0];
                    $request_height = $removeX[1];
                    $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                    $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . rand() . '.' . $upload[$index]->extension();
                    $upload[$index]->move(public_path('showcase_collection'), $file_name);
                    $file_bytes = filesize(public_path('/showcase_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $sub_project = new Banner;
                    $sub_project->name = $sub_project_name;
                    $sub_project->project_id = $main_project_id;
                    $sub_project->size_id = $size_info['id'];
                    $sub_project->size = $file_size;
                    $sub_project->feedback_id = $feedback_id;
                    $sub_project->category_id = $category_id;
                    $newFileName = str_replace(".zip", "", $file_name);
                    $sub_project->file_path = $newFileName;
                    $sub_project->save();
    
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
        
                return redirect('/project/banner-showcase/view/' . $main_project_id);
            }
        }
        else{
            dd('error');
        }
    }

    public function banner_edit_category_view($feedback_id, $category_id){
        //category edit function view
        $feedback_info = Feedback::where('id', $feedback_id)->first();
        $feedback_name = $feedback_info['name'];
        $project_info = MainProject::where('id', $feedback_info['project_id'])->first();
        $project_name = $project_info['name'];
        $category_info = BannerCategories::where('id', $category_id)->first();
        $category_name = $category_info['name'];
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('view_bannershowcase.category-edit', compact('category_name', 'feedback_id', 'category_id', 'project_name', 'feedback_name', 'size_list'));
    }

    public function banner_edit_category_post(Request $request, $feedback_id, $category_id){
        //post function to update the category
        $category_info = BannerCategories::where('id', $category_id)->first();
        BannerCategories::where('id', $category_id)->update(['name' => $request->category_name]);
        $project_info = MainProject::where('id', $category_info['project_id'])->first();
        
        //if request has uploads then firstd elete the current banners then add the new ones
        if($request->has('upload')){
            $banners = Banner::where('category_id', $category_id)->get();

            if (($banners->count() != 0)) {
                foreach ($banners as $banner) {
                    $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
                    if(file_exists($file_path)){
                        // unlink('banner_collection/' . $sub_project['file_path']);
                        $files = File::deleteDirectory($file_path);
                    }
                    Banner::where('id', $banner->id)->delete();
                }
            }
            $banner_size = $request->banner_size_id;
            $upload = $request->upload;
            $array = [];

            foreach($banner_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $upload[$index]->extension();
                $upload[$index]->move(public_path('showcase_collection'), $file_name);
                $file_bytes = filesize(public_path('/showcase_collection/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $banner = new Banner;
                $banner->name = $sub_project_name;
                $banner->project_id = $category_info['project_id'];
                $banner->size_id = $size_info['id'];
                $banner->size = $file_size;
                $banner->feedback_id = $feedback_id;
                $banner->category_id = $category_id;
                $newFileName = str_replace(".zip", "", $file_name);
                $banner->file_path = $newFileName;
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
        }

        return redirect('/project/banner-showcase/view/' . $category_info['project_id']);
    }

    public function banner_delete_category($feedback_id, $category_id){
        //delete the category
        $banner = Banner::where('category_id', $category_id)->first();
        $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
        if(file_exists($file_path)){
            // unlink('banner_collection/' . $sub_project['file_path']);
            $files = File::deleteDirectory($file_path);    
        }
        BannerCategories::where('id', $category_id)->delete();
        return back();
    }

    public function showcase_banner_edit($id)
    {
        $sub_project_id = $id;
        $sub_project_info = Banner::where('id', $id)->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_bannershowcase.banner-edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    public function showcase_banner_edit_post(Request $request, $id)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:zip'
        ]);

        if($request->banner_size_id != 0)
        {
            $banner_id = $id;
            $banner_info = Banner::where('id', $banner_id)->first();
            $old_file_directory = public_path() . '/showcase_collection/' . $banner_info['file_path'];
            
            if(file_exists($old_file_directory)){
                // unlink('banner_collection/' . $banner_info['file_path']);
                $files = File::deleteDirectory($old_file_directory);
            }
    
            $project_info = MainProject::where('id', $banner_info['project_id'])->where('project_type', 4)->first();
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . rand() . '.' . $request->upload->extension();
            $request->upload->move(public_path('showcase_collection'), $file_name);
            $file_bytes = filesize(public_path('/showcase_collection/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];

            $newFileName = str_replace(".zip", "", $file_name);
    
            $sub_project_details = [
                'name' => $sub_project_name,
                'size_id' => $request->banner_size_id,
                'size' => $file_size,
                'file_path' => $newFileName
            ];
    
            Banner::where('id', $banner_id)->update($sub_project_details);
    
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
            return redirect('/project/banner-showcase/view/' . $project_info['id']);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
    }

    public function banner_delete($id)
    {
        $banner = Banner::where('id', $id)->first();
        $project_id = $banner['project_id'];
        $file_path = public_path() . '/showcase_collection/' . $banner['file_path'];
        if(file_exists($file_path)){
            // unlink('banner_collection/' . $sub_project['file_path']);
            $files = File::deleteDirectory($file_path);    
        }
        Banner::where('id', $id)->delete();
        $banners_check = Banner::where('project_id', $project_id)->get();
        if($banners_check->count() == 0){
            Feedback::where('project_id', $project_id)->delete();
            BannerCategories::where('project_id', $project_id)->delete();
            MainProject::where('id', $project_id)->update(['is_version' => 0]);
            return redirect('/project/banner-showcase/addon/'.$project_id)->with('danger', 'Assets been deleted! Please Re-upload.'); 
        }
        else{
            return back();
        }
    }

    public function banner_download($id){
        $banner = Banner::where('id', $id)->first();
        $file_name = $banner['file_path'].'.zip';
        $source = public_path('showcase_collection/'.$banner['file_path']);
        $destination = $source;
        $zipcreation = $this->zip_creation($source, $destination);
        return response()->download(public_path('showcase_collection/'.$file_name))->deleteFileAfterSend(true);
    }

    public function zip_creation($source, $destination){
        $dir = opendir($source);
        $result = ($dir === false ? false : true);
    
        if ($result !== false) {
            $rootPath = realpath($source);
             
            // Initialize archive object
            $zip = new ZipArchive();
            $zipfilename = $destination.".zip";
            $zip->open($zipfilename, ZipArchive::CREATE | ZipArchive::OVERWRITE );
             
            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($rootPath), \RecursiveIteratorIterator::LEAVES_ONLY);
             
            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);
             
                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
             
            // Zip archive will be created only after closing object
            $zip->close();
            
            return TRUE;
        } else {
            return FALSE;
        }
    
    
    }
}
