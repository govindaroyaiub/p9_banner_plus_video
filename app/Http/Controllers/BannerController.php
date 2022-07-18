<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Session;
use App\User;
use App\MainProject;
use App\Comments;
use App\Logo;
use App\BannerSizes;
use App\BannerProject;
use App\Version;
use App\Helper\Helper;

class BannerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'] || url('/') == 'http://p9_banner_plus_video.test')
        {
            $banner_list = MainProject::where('project_type', 0)
                                        ->where('uploaded_by_company_id', Auth::user()->company_id)
                                        ->orderBy('created_at', 'DESC')
                                        ->get();
            return view('view_banner.banner', compact('banner_list'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function banner_add()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'] || url('/') == 'http://p9_banner_plus_video.test')
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('view_banner.banner_add', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function banner_add_post(Request $request)
    {
        $validator = $request->validate([
            'upload' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip'
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
            $main_project->project_type = 0;
            $main_project->is_version = 0;
            $main_project->uploaded_by_user_id = Auth::user()->id;
            $main_project->uploaded_by_company_id = Auth::user()->company_id;
            $main_project->save();

            $version = new Version;
            $version->project_id = $main_project->id;
            $version->title = $request->version_title;
            $version->color = '#878787';
            $version->is_open = 1;
            $version->save();

            $banner_size_id = $request->banner_size_id;

            $bannerIndex = 0;

            foreach($request->file('upload') as $upload){
                if(!empty($banner_size_id[$bannerIndex])){
                    $size_info = BannerSizes::where('id', $banner_size_id[$bannerIndex])->first();
                    $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . '.' . $upload->extension();
                    $upload->move(public_path('banner_collection'), $file_name);
                    $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $sub_project = new BannerProject;
                    $sub_project->name = $sub_project_name;
                    $sub_project->project_id = $main_project->id;
                    $sub_project->size_id = $banner_size_id[$bannerIndex];
                    $sub_project->size = $file_size;
                    $sub_project->version_id = $version->id;
                    $sub_project->file_path = $file_name;
                    $sub_project->save();

                    $zip = new ZipArchive();
                    $file_path = str_replace(".zip", "", $sub_project->file_path);
                    $directory = 'banner_collection/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('banner_collection/' . $sub_project->file_path) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                    }
                    $bannerIndex++;
                }
            }
            
            return redirect('/project/banner/view/' . $main_project->id);
        }
    }

    public function sizes()
    {
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner_sizes', compact('size_list'));
    }

    public function size_add()
    {
        return view('view_banner.banner_add_size');
    }

    public function size_add_post(Request $request)
    {
        $size = new BannerSizes;
        $size->width = $request->width;
        $size->height = $request->height;
        $size->save();

        return redirect('/banner_sizes')->with('success', $request->width . 'x' . $request->height . ' Added Successfully!');
    }

    public function project_addon($id)
    {
        $main_project_id = $id;
        $project_info = MainProject::where('id', $main_project_id)->first();
        $version_status = $project_info['is_version'];
        $versionCount = Version::where('project_id', $main_project_id)->count();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner_addon', compact('size_list', 'main_project_id', 'versionCount', 'version_status'));
    }

    public function project_addon_post(Request $request, $id)
    {
        $validator = $request->validate([
            'upload' => 'required',
            'version_request' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip'
        ]);

        $version_request = $request->version_request;

        if($version_request!= 0){

            $main_project_id = $id;
            $project_info = MainProject::where('id', $main_project_id)->first();
            $version_info = Version::where('project_id', $main_project_id)->first();

            if($version_info == NULL){
                $version = new Version;
                $version->project_id = $main_project_id;
                $version->title = 'Version 1';
                $version->color = '#878787';
                $version->save();

                $version_id = $version->id;
            }
            else{
                $version_id = $version_info['id'];
            }
            $banner_size_id = $request->banner_size_id;
            $bannerIndex = 0;

            if($version_request == 1){ //upload to existing project
                if($request->hasfile('upload')){
                    foreach($request->file('upload') as $upload){
                        if(isset($banner_size_id[$bannerIndex])){
                            $size_info = BannerSizes::where('id', $banner_size_id[$bannerIndex])->first();
                            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
                    
                            $file_name = $sub_project_name . '_' . time() . '.' . $upload->extension();
                            $upload->move(public_path('banner_collection'), $file_name);
                            $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
                    
                            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                            $file_size = round($file_bytes, 2) . " " . $label[$i];
                    
                            $sub_project = new BannerProject;
                            $sub_project->name = $sub_project_name;
                            $sub_project->project_id = $main_project_id;
                            $sub_project->size_id = $banner_size_id[$bannerIndex];
                            $sub_project->size = $file_size;
                            $sub_project->version_id = $version_id;
                            $sub_project->file_path = $file_name;
                            $sub_project->save();
                    
                            $zip = new ZipArchive();
                            $file_path = str_replace(".zip", "", $sub_project->file_path);
                            $directory = 'banner_collection/' . $file_path;
                            if (!is_dir($directory)) {
                                if ($zip->open('banner_collection/' . $sub_project->file_path) === TRUE) {
                                    // Unzip Path
                                    $zip->extractTo($directory);
                                    $zip->close();
                                }
                            }
                            $bannerIndex++;
                        }
                    }
            
                    return redirect('/project/banner/view/' . $main_project_id);
                }
            }
            else{ 
                $previousVersionInfo = Version::where('project_id', $main_project_id)->first();
                $previousVersionColor  = $previousVersionInfo['color'];

                //if add as a new version to the preview
                $version = new Version;
                $version->title = $request->version_title;
                $version->color = $previousVersionColor;
                $version->project_id = $main_project_id;
                $version->save();

                MainProject::where('id', $main_project_id)->update(['is_version' => 1]);

                if($request->hasfile('upload')){
                    foreach($request->file('upload') as $upload){
                        if(isset($banner_size_id[$bannerIndex])){
                            $size_info = BannerSizes::where('id', $banner_size_id[$bannerIndex])->first();
                            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
                    
                            $file_name = $sub_project_name . '_' . time() . '.' . $upload->extension();
                            $upload->move(public_path('banner_collection'), $file_name);
                            $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
                    
                            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                            $file_size = round($file_bytes, 2) . " " . $label[$i];
                    
                            $sub_project = new BannerProject;
                            $sub_project->name = $sub_project_name;
                            $sub_project->project_id = $main_project_id;
                            $sub_project->size_id = $banner_size_id[$bannerIndex];
                            $sub_project->size = $file_size;
                            $sub_project->version_id = $version->id;
                            $sub_project->file_path = $file_name;
                            $sub_project->save();
                    
                            $zip = new ZipArchive();
                            $file_path = str_replace(".zip", "", $sub_project->file_path);
                            $directory = 'banner_collection/' . $file_path;
                            if (!is_dir($directory)) {
                                if ($zip->open('banner_collection/' . $sub_project->file_path) === TRUE) {
                                    // Unzip Path
                                    $zip->extractTo($directory);
                                    $zip->close();
                                }
                            }
                            $bannerIndex++;
                        }
                    }
            
                    return redirect('/project/banner/view/' . $main_project_id);
                }
            }
        }
        else{
            return back();
        }
    }

    public function deleteVersion($project_id, $version_id)
    {
        $sub_project_info = BannerProject::where('project_id', $project_id)->where('version_id', $version_id)->get();
        if (($sub_project_info->count() != 0)) {
            foreach ($sub_project_info as $sub_project) {
                $file_path = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);
                if(file_exists($file_path)){
                    unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
    
                }
                BannerProject::where('id', $sub_project->id)->delete();
            }
        }

        Version::where('id', $version_id)->delete();

        $versionCount = Version::where('project_id', $project_id)->count();

        if($versionCount <= 1){
            MainProject::where('id', $project_id)->update(['is_version' => 0]);
        }

        return back();
    }

    public function addBannerVersion($project_id, $id)
    {
        $main_project_id = $project_id;
        $version_id = $id;
        $version_info = Version::where('id', $id)->first();
        $project_info = MainProject::where('id', $project_id)->first();
        $project_name = $project_info['name'];
        $version_name = $version_info['title'];
        return view('view_banner.version_banner.banner-add', compact('main_project_id', 'version_id', 'version_name', 'project_name'));
    }

    public function addBannerVersionPost(Request $request, $project_id, $id)
    {
        $validator = $request->validate([
            'upload' => 'required',
            'upload.*' => 'mimes:doc,pdf,docx,zip'
        ]);

        $main_project_id = $project_id;
        $version_id = $id;

        $project_info = MainProject::where('id', $main_project_id)->first();
        $banner_size_id = $request->banner_size_id;
        $bannerIndex = 0;

        if($request->hasfile('upload')){
            foreach($request->file('upload') as $upload){
                if(isset($banner_size_id[$bannerIndex])){
                    $size_info = BannerSizes::where('id', $banner_size_id[$bannerIndex])->first();
                    $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . '.' . $upload->extension();
                    $upload->move(public_path('banner_collection'), $file_name);
                    $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $sub_project = new BannerProject;
                    $sub_project->name = $sub_project_name;
                    $sub_project->project_id = $main_project_id;
                    $sub_project->size_id = $banner_size_id[$bannerIndex];
                    $sub_project->size = $file_size;
                    $sub_project->version_id = $version_id;
                    $sub_project->file_path = $file_name;
                    $sub_project->save();
            
                    $zip = new ZipArchive();
                    $file_path = str_replace(".zip", "", $sub_project->file_path);
                    $directory = 'banner_collection/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('banner_collection/' . $sub_project->file_path) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                    }
                    $bannerIndex++;
                }
            }
    
            return redirect('/project/banner/view/' . $main_project_id);
        }
    }

    public function editBannerVersion($project_id, $id)
    {
        $main_project_id = $project_id;
        $version_id = $id;
        $version_info = Version::where('id', $id)->first();
        $project_info = MainProject::where('id', $project_id)->first();
        $project_name = $project_info['name'];
        $version_name = $version_info['title'];
        return view('view_banner.version_banner.banner-edit', compact('main_project_id', 'version_id', 'version_name', 'project_name'));
    }

    public function editBannerVersionPost(Request $request, $project_id, $id)
    {
        Version::where('id', $id)->update(['title' => $request->version_title]);
        $project_info = MainProject::where('id', $project_id)->first();
        
        //if request has uploads then firstd elete the current banners then add the new ones
        if($request->has('upload')){
            $sub_project_info = BannerProject::where('project_id', $project_id)->where('version_id', $id)->get();

            if (($sub_project_info->count() != 0)) {
                foreach ($sub_project_info as $sub_project) {
                    $file_path = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);
                    if(file_exists($file_path)){
                        unlink('banner_collection/' . $sub_project['file_path']);
                        $files = File::deleteDirectory($file_path);
                    }
                    BannerProject::where('id', $sub_project->id)->delete();
                }
            }
            $banner_size_id = $request->banner_size_id;
            $bannerIndex = 0;

            foreach($request->file('upload') as $upload){
                if(isset($banner_size_id[$bannerIndex])){
                    $size_info = BannerSizes::where('id', $banner_size_id[$bannerIndex])->first();
                    $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . '.' . $upload->extension();
                    $upload->move(public_path('banner_collection'), $file_name);
                    $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $sub_project = new BannerProject;
                    $sub_project->name = $sub_project_name;
                    $sub_project->project_id = $project_id;
                    $sub_project->size_id = $banner_size_id[$bannerIndex];
                    $sub_project->size = $file_size;
                    $sub_project->version_id = $id;
                    $sub_project->file_path = $file_name;
                    $sub_project->save();
            
                    $zip = new ZipArchive();
                    $file_path = str_replace(".zip", "", $sub_project->file_path);
                    $directory = 'banner_collection/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('banner_collection/' . $sub_project->file_path) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                    }
                    $bannerIndex++;
                }
            }
        }

        return redirect('/project/banner/view/' . $project_id);
    }

    public function deleteAllBanners($id){
        $main_project_info = MainProject::where('id', $id)->first();

        $sub_project_info = BannerProject::where('project_id', $id)->get();
        if (($sub_project_info->count() != 0)) {
            foreach ($sub_project_info as $sub_project) {
                $file_path = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);
                if(file_exists($file_path)){
                    unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
                }
                BannerProject::where('id', $sub_project->id)->delete();
            }
        }

        Version::where('project_id', $id)->delete();
        MainProject::where('id', $id)->update(['is_version' => 0]);
        return redirect('/project/banner/addon/'.$id)->with('danger', 'Assets been deleted! Please Re-upload.');
    }

    public function banner_delete_all($id)
    {
        $main_project_info = MainProject::where('id', $id)->first();

        $sub_project_info = BannerProject::where('project_id', $id)->get();
        if (($sub_project_info->count() != 0)) {
            foreach ($sub_project_info as $sub_project) {
                $file_path = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);
                if(file_exists($file_path)){
                    unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
                }
                BannerProject::where('id', $sub_project->id)->delete();
            }
        }
        Version::where('project_id', $id)->delete();
        MainProject::where('id', $id)->delete();
        return redirect('/banner')->with('danger', $main_project_info['name'] . ' been deleted along with assets!');
    }

    public function banner_delete($id)
    {
        $sub_project = BannerProject::where('id', $id)->first();
        $version_id = $sub_project['version_id'];
        $project_id = $sub_project['project_id'];
        $file_path = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);
        if(file_exists($file_path)){
            unlink('banner_collection/' . $sub_project['file_path']);
            $files = File::deleteDirectory($file_path);    
        }
        if($version_id != NULL){
            Version::where('id', $version_id)->delete();
        }
        MainProject::where('id', $project_id)->update(['is_version' => 0]);
        BannerProject::where('id', $id)->delete();

        return back();
    }

    public function banner_edit($id)
    {
        $sub_project_id = $id;
        $sub_project_info = BannerProject::where('id', $id)->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner-edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    public function banner_edit_post(Request $request, $id)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:zip'
        ]);

        if($request->banner_size_id != 0)
        {
            $banner_id = $id;
            $banner_info = BannerProject::where('id', $banner_id)->first();
            $old_file_directory = public_path() . '/banner_collection/' . str_replace(".zip", "", $banner_info['file_path']);
            
            if(file_exists($old_file_directory)){
                unlink('banner_collection/' . $banner_info['file_path']);
                $files = File::deleteDirectory($old_file_directory);
            }
    
            $project_info = MainProject::where('id', $banner_info['project_id'])->where('project_type', 0)->first();
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . '.' . $request->upload->extension();
            $request->upload->move(public_path('banner_collection'), $file_name);
            $file_bytes = filesize(public_path('/banner_collection/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];
    
            $sub_project_details = [
                'name' => $sub_project_name,
                'size_id' => $request->banner_size_id,
                'size' => $file_size,
                'file_path' => $file_name
            ];
    
            BannerProject::where('id', $banner_id)->update($sub_project_details);
    
            $zip = new ZipArchive();
            $file_path = str_replace(".zip", "", $file_name);
            $directory = 'banner_collection/' . $file_path;
            if (!is_dir($directory)) {
                if ($zip->open('banner_collection/' . $file_name) === TRUE) {
                    // Unzip Path
                    $zip->extractTo($directory);
                    $zip->close();
                }
            }
            return redirect('/project/banner/view/' . $project_info['id']);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
    }

    public function project_edit($id)
    {
        $project_name = MainProject::where('id', $id)->first();
        $naming_convention = str_replace(" ", "_", $project_name['name']);
        $logo_list = Logo::get();
        $size_list = BannerSizes::orderBy('width', 'DESC')->get();
        $project_info = MainProject::where('id', $id)->first();
        $version_info = Version::where('project_id', $id)->get();
        
        return view('view_banner.edit_project', compact('logo_list', 'size_list', 'project_info', 'id', 'naming_convention', 'version_info'));
    }

    public function project_edit_post(Request $request, $id)
    {
        $main_project_id = $id;
        $pro_name = $request->project_name;
        $old_project_details = MainProject::where('id', $id)->where('project_type', 0)->first();
        $project_name = str_replace(" ", "_", $request->project_name);
        $old_project_name = str_replace(" ", "_", $old_project_details['name']);

        $sub_projects = BannerProject::where('project_id', $main_project_id)->get();

        $main_project_details = [
            'name' => $pro_name,
            'client_name' => $request->client_name,
            'logo_id' => $request->logo_id,
            'color' => $request->color,
            'is_logo' => $request->is_logo,
            'is_footer' => $request->is_footer
        ];

        if($request->default_color == 1){
            Version::where('project_id', $id)->update(['color' => '#878787']);
        }

        MainProject::where('id', $main_project_id)->update($main_project_details);

        if($old_project_name != $project_name)
        {
            foreach ($sub_projects as $sub_project) 
            {
                $size_info = BannerSizes::where('id', $sub_project['size_id'])->first();
    
                $old_sub_project_name = $sub_project->name;
                $old_file_path = $sub_project->file_path;
    
                $new_sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
                if ($old_file_path != NULL)
                {
                    //str_replace($search,$replace,$subject)
                    $new_file_path = str_replace($old_sub_project_name,$new_sub_project_name,$old_file_path);
                } 
                else 
                {
                    $new_file_path = NULL;
                }
                $old_directory = public_path() . '/banner_collection/' . str_replace(".zip", "", $sub_project['file_path']);

                if(file_exists($old_directory)){
                    $old_files = File::deleteDirectory($old_directory);
                    rename('banner_collection/' . $old_file_path, 'banner_collection/' . $new_file_path);
                }
    
                $new_sub_details = [
                    'name' => $new_sub_project_name,
                    'file_path' => $new_file_path,
                ];
    
                $zip = new ZipArchive();
                $file_path = str_replace(".zip", "", $new_file_path);
                $directory = 'banner_collection/' . $file_path;
                if (!is_dir($directory)) {
                    if ($zip->open('banner_collection/' . $new_file_path) === TRUE) {
                        // Unzip Path
                        $zip->extractTo($directory);
                        $zip->close();
                    }
                }
    
                BannerProject::where('id', $sub_project->id)->update($new_sub_details);
            }
        }
        return redirect('/banner')->with('success', $project_name . ' has been updated!');
    }
}
