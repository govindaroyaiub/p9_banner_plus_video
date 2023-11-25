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
use App\newVideo;
use App\newGif;
use App\newSocial;
use App\Sizes;
use App\Logo;
use App\BannerSizes;

class PreviewController extends Controller
{
    function viewPreviews(){
        $data = newPreview::orderBy('created_at', 'ASC')->get();
        return view('material_ui.preview.previews', compact('data'));
    }

    function addPreviewsView(){
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
            $video_sizes = Sizes::orderBy('width', 'DESC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('newpreview.addpreviews', compact('logo_list', 'size_list', 'color', 'video_sizes'));
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

        if($request->logo_id == 1){ // if logo_id == 1 as in Planet Nine then show no logo
            $is_logo = 2;
        }
        else{
            $is_logo = 1;
        }

        $main_project = new newPreview;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $logo_details['default_color'];
        $main_project->is_logo = $is_logo;
        $main_project->is_footer = $request->is_footer;
        $main_project->is_version = 0;
        $main_project->uploaded_by_user_id = Auth::user()->id;
        $main_project->uploaded_by_company_id = Auth::user()->company_id;
        $main_project->save();

        $feedback = new newFeedback;
        $feedback->project_id = $main_project->id;
        $feedback->name = $request->feedback_name;
        $feedback->project_type = $project_type;
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
                    $bannerupload[$index]->move(public_path('new_banners/'), $file_name);
                    $file_bytes = filesize(public_path('new_banners/' . $file_name));
            
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
                    $directory = 'new_banners/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('new_banners/' . $file_name) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                        unlink('new_banners/' . $file_name);
                    }
                }
            }

        }
        else if($request->project_type == 2){
            //this is video upload method
            $validator = $request->validate([
                'poster' => 'mimes:jpeg,png,jpg,gif',
                'video' => 'required|mimes:mp4',
                'video_size_id' => 'required'
            ]);

            $size_info = Sizes::where('id', $request->video_size_id)->first();
            $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

            if($request->has('poster'))
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('new_posters'), $poster_name);
            }
            else
            {
                $poster_name = NULL;
            }


            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('new_videos'), $video_name);
            $video_bytes = filesize(public_path('/new_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

            $video = new newVideo;
            $video->name = $sub_project_name;
            $video->title = $request->video_title;
            $video->size_id = $request->video_size_id;
            $video->codec = $request->codec;
            $video->aspect_ratio = $request->aspect_ratio;
            $video->fps = $request->fps;
            $video->size = $video_size;
            $video->poster_path = $poster_name;
            $video->video_path = $video_name;
            $video->version_id = $version->id;
            $video->save();

        }
        else if($request->project_type == 3){
            //this is gif upload method
            if($request->hasfile('gifupload')){
                $gif_size = $request->gif_size_id;
                $gifupload = $request->gifupload;

                foreach($gif_size as $index => $size){
                    $removeX = explode("x", $size);
                    $request_width = $removeX[0];
                    $request_height = $removeX[1];
                    $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                    $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . rand() . '.' . $gifupload[$index]->extension();
                    $gifupload[$index]->move(public_path('new_gifs/'), $file_name);
                    $file_bytes = filesize(public_path('new_gifs/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $gif = new newGif;
                    $gif->name = $sub_project_name;
                    $gif->size = $file_size;
                    $gif->file_path = $file_name;
                    $gif->size_id = $size_info['id'];
                    $gif->version_id = $version->id;
                    $gif->save();
                }
            }
        }
        else if($request->project_type == 4){
            //this is social upload method
            if($request->hasfile('socialupload')){

                $validator = $request->validate([
                    'socialupload' => 'required',
                    'socialupload.*' => 'mimes:jpeg,jpg,png,gif'
                ]);
    
                $platforms = $request->platform; 
                $uploads = $request->socialupload;
    
                foreach($platforms as $index => $platform)
                {
                    $original_file_name = $uploads[$index]->getClientOriginalName();
                    $name = explode('.',$original_file_name);
    
                    $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                    $uploads[$index]->move(public_path('new_socials'), $file_name);

                    list($width, $height) = getimagesize(public_path('new_socials/'.$file_name));

                    $file_bytes = filesize(public_path('new_socials/'.$file_name));
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
    
                    $social = new newSocial;
                    $social->name = $project_name .'_' . $platform . '_' . $name[0];
                    $social->width = $width;
                    $social->height = $height;
                    $social->size = $file_size;
                    $social->version_id = $version->id;
                    $social->file_path = $file_name;
                    $social->save();
                }
            }
        }
        else{
            return back()->with('danger', 'Pleae select correct project type');
        }

        return redirect('/project/preview/view/'.$main_project->id);
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

    function bannerEditView($id){
        $sub_project_id = $id;
        $sub_project_info = newBanner::where('id', $id)->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('newpreview.banner.banner_edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    function bannerEditPost(Request $request, $id){
        $validator = $request->validate([
            'upload' => 'required|file|mimes:zip'
        ]);

        if($request->banner_size_id != 0)
        {
            $banner_id = $id;
            $banner_info = newBanner::where('id', $banner_id)->first();
            $old_file_directory = public_path() . '/new_banners/' . $banner_info['file_path'];
            
            if(file_exists($old_file_directory)){
                // unlink('banner_collection/' . $banner_info['file_path']);
                $files = File::deleteDirectory($old_file_directory);
            }

            $version_info = newVersion::where('id', $banner_info['version_id'])->first();
            $feedback_info = newFeedback::where('id', $version_info['feedback_id'])->first();
            $project_info = newPreview::where('id', $feedback_info['project_id'])->first();
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . rand() . '.' . $request->upload->extension();
            $request->upload->move(public_path('new_banners'), $file_name);
            $file_bytes = filesize(public_path('/new_banners/' . $file_name));
    
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
    
            newBanner::where('id', $banner_id)->update($sub_project_details);
    
            $zip = new ZipArchive();
            $file_path = str_replace(".zip", "", $file_name);
            $directory = 'new_banners/' . $file_path;
            if (!is_dir($directory)) {
                if ($zip->open('new_banners/' . $file_name) === TRUE) {
                    // Unzip Path
                    $zip->extractTo($directory);
                    $zip->close();
                }
                unlink('new_banners/' . $file_name);
            }
            return redirect('/project/preview/view/' . $project_info['id']);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
    }

    public function bannerDownload($id){
        $banner = newBanner::where('id', $id)->first();
        $file_name = $banner['file_path'].'.zip';
        $source = public_path('new_banners/'.$banner['file_path']);
        $destination = $source;
        $zipcreation = $this->zip_creation($source, $destination);
        return response()->download(public_path('new_banners/'.$file_name))->deleteFileAfterSend(true);
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

    function bannerAddVersionView($id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::where('id', $version['feedback_id'])->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        $versionCount = newVersion::where('feedback_id', $feedback['id'])->count();
        return view('newpreview.banner.bannerversionaddon', compact('size_list', 'version', 'feedback', 'versionCount', 'version_id'));
    }

    function videoAddVersionView($id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::where('id', $version['feedback_id'])->first();
        $video_sizes = Sizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        $versionCount = newVersion::where('feedback_id', $feedback['id'])->count();
        return view('newpreview.video.videoversionaddon', compact('video_sizes', 'version', 'feedback', 'versionCount', 'version_id'));
    }

    function gifAddVersionView($id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::where('id', $version['feedback_id'])->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        $versionCount = newVersion::where('feedback_id', $feedback['id'])->count();
        return view('newpreview.gif.gifversionaddon', compact('size_list', 'version', 'feedback', 'versionCount', 'version_id'));
    }

    function socialAddVersionView($id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::where('id', $version['feedback_id'])->first();
        $versionCount = newVersion::where('feedback_id', $feedback['id'])->count();
        return view('newpreview.social.socialversionaddon', compact('version', 'feedback', 'versionCount', 'version_id'));
    }

    function bannerAddVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);

        if($request->version_request == 1){
            $version_id = $id;
        }
        else if($request->version_request == 2){
            $version = new newVersion;
            $version->name = $request->version_name;
            $version->feedback_id = $feedback['id'];
            $version->is_active = 1;
            $version->save();

            $version_id = $version->id;

            $exceptionVersions = newVersion::select('id')->where('id', '!=', $version_id)->where('feedback_id', $feedback['id'])->get()->toArray();
            newVersion::whereIn('id', $exceptionVersions)->where('feedback_id', $feedback['id'])->update(['is_active' => 0]);
        }
        else{
            return back()->with('danger', 'Please Select Correct Option!');
        }

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
                $bannerupload[$index]->move(public_path('new_banners/'), $file_name);
                $file_bytes = filesize(public_path('new_banners/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $banner = new newBanner;
                $banner->name = $sub_project_name;
                $banner->size = $file_size;
                $newFileName = str_replace(".zip", "", $file_name);
                $banner->file_path = $newFileName;
                $banner->size_id = $size_info['id'];
                $banner->version_id = $version_id;
                $banner->save();

                $zip = new ZipArchive();
                $file_path = str_replace(".zip", "", $file_name);
                $directory = 'new_banners/' . $file_path;
                if (!is_dir($directory)) {
                    if ($zip->open('new_banners/' . $file_name) === TRUE) {
                        // Unzip Path
                        $zip->extractTo($directory);
                        $zip->close();
                    }
                    unlink('new_banners/' . $file_name);
                }
            }
        }
        return redirect('/project/preview/view/'.$project_id);
    }

    function videoAddVersionPost(Request $request, $id){
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'required|mimes:mp4',
            'video_size_id' => 'required'
        ]);

        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);

        if($request->version_request == 1){
            $version_id = $id;
        }
        else if($request->version_request == 2){
            $version = new newVersion;
            $version->name = $request->version_name;
            $version->feedback_id = $feedback['id'];
            $version->is_active = 1;
            $version->save();

            $version_id = $version->id;

            $exceptionVersions = newVersion::select('id')->where('id', '!=', $version_id)->where('feedback_id', $feedback['id'])->get()->toArray();
            newVersion::whereIn('id', $exceptionVersions)->where('feedback_id', $feedback['id'])->update(['is_active' => 0]);
        }
        else{
            return back()->with('danger', 'Please Select Correct Option!');
        }

        $size_info = Sizes::where('id', $request->video_size_id)->first();
        $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

        if($request->has('poster')){
            $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
            $request->poster->move(public_path('new_posters'), $poster_name);
        }
        else{
            $poster_name = NULL;
        }

        $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
        $request->video->move(public_path('new_videos'), $video_name);
        $video_bytes = filesize(public_path('/new_videos/'.$video_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
        $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

        $video = new newVideo;
        $video->name = $sub_project_name;
        $video->title = $request->video_title;
        $video->size_id = $request->video_size_id;
        $video->codec = $request->codec;
        $video->aspect_ratio = $request->aspect_ratio;
        $video->fps = $request->fps;
        $video->size = $video_size;
        $video->poster_path = $poster_name;
        $video->video_path = $video_name;
        $video->version_id = $version_id;
        $video->save();

        return redirect('/project/preview/view/'.$project_id);
    }

    function gifAddVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);

        if($request->version_request == 1){
            $version_id = $id;
        }
        else if($request->version_request == 2){
            $version = new newVersion;
            $version->name = $request->version_name;
            $version->feedback_id = $feedback['id'];
            $version->is_active = 1;
            $version->save();

            $version_id = $version->id;

            $exceptionVersions = newVersion::select('id')->where('id', '!=', $version_id)->where('feedback_id', $feedback['id'])->get()->toArray();
            newVersion::whereIn('id', $exceptionVersions)->where('feedback_id', $feedback['id'])->update(['is_active' => 0]);
        }
        else{
            return back()->with('danger', 'Please Select Correct Option!');
        }

        if($request->hasfile('gifupload')){
            $gif_size = $request->gif_size_id;
            $gifupload = $request->gifupload;

            foreach($gif_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $gifupload[$index]->extension();
                $gifupload[$index]->move(public_path('new_gifs/'), $file_name);
                $file_bytes = filesize(public_path('new_gifs/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $gif = new newGif;
                $gif->name = $sub_project_name;
                $gif->size = $file_size;
                $gif->file_path = $file_name;
                $gif->size_id = $size_info['id'];
                $gif->version_id = $version_id;
                $gif->save();
            }
        }
        return redirect('/project/preview/view/'.$project_id);
    }

    function socialAddVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);

        if($request->version_request == 1){
            $version_id = $id;
        }
        else if($request->version_request == 2){
            $version = new newVersion;
            $version->name = $request->version_name;
            $version->feedback_id = $feedback['id'];
            $version->is_active = 1;
            $version->save();

            $version_id = $version->id;

            $exceptionVersions = newVersion::select('id')->where('id', '!=', $version_id)->where('feedback_id', $feedback['id'])->get()->toArray();
            newVersion::whereIn('id', $exceptionVersions)->where('feedback_id', $feedback['id'])->update(['is_active' => 0]);
        }
        else{
            return back()->with('danger', 'Please Select Correct Option!');
        }

        if($request->hasfile('socialupload')){

            $validator = $request->validate([
                'socialupload' => 'required',
                'socialupload.*' => 'mimes:jpeg,jpg,png,gif'
            ]);

            $platforms = $request->platform; 
            $uploads = $request->socialupload;

            foreach($platforms as $index => $platform)
            {
                $original_file_name = $uploads[$index]->getClientOriginalName();
                $name = explode('.',$original_file_name);

                $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                $uploads[$index]->move(public_path('new_socials'), $file_name);

                list($width, $height) = getimagesize(public_path('new_socials/'.$file_name));

                $file_bytes = filesize(public_path('new_socials/'.$file_name));
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];

                $social = new newSocial;
                $social->name = $project_name .'_' . $platform . '_' . $name[0];
                $social->width = $width;
                $social->height = $height;
                $social->size = $file_size;
                $social->version_id = $version->id;
                $social->file_path = $file_name;
                $social->save();
            }
        }
        return redirect('/project/preview/view/'.$project_id);
    }

    function bannerEditVersionView($id){
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('newpreview.banner.bannerversionedit', compact('version', 'feedback', 'size_list'));
        
    }

    function videoEditVersionView($id){
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $video_sizes = Sizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('newpreview.video.videoversionedit', compact('version', 'feedback', 'video_sizes'));
    }

    function gifEditVersionView($id){
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        return view('newpreview.gif.gifversionedit', compact('version', 'feedback', 'size_list'));
        
    }

    function socialEditVersionView($id){
        $version = newVersion::find($id);
        $feedback = newFeedback::find($version['feedback_id']);
        return view('newpreview.social.socialversionedit', compact('version', 'feedback'));
        
    }

    function bannerEditVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($version_id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);
        
        newVersion::where('id', $version_id)->update(['name' => $request->version_name]);

        if($request->hasfile('bannerupload')){
            $banners = newBanner::where('version_id', $version_id)->get();
            foreach ($banners as $banner) {
                $file_path = public_path() . '/new_banners/' . $banner['file_path'];
                if(file_exists($file_path)){
                    // unlink('banner_collection/' . $sub_project['file_path']);
                    $files = File::deleteDirectory($file_path);
                }
                newBanner::where('id', $banner->id)->delete();
            }

            $banner_size = $request->banner_size_id;
            $bannerupload = $request->bannerupload;

            foreach($banner_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $bannerupload[$index]->extension();
                $bannerupload[$index]->move(public_path('new_banners/'), $file_name);
                $file_bytes = filesize(public_path('new_banners/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $banner = new newBanner;
                $banner->name = $sub_project_name;
                $banner->size = $file_size;
                $newFileName = str_replace(".zip", "", $file_name);
                $banner->file_path = $newFileName;
                $banner->size_id = $size_info['id'];
                $banner->version_id = $version_id;
                $banner->save();

                $zip = new ZipArchive();
                $file_path = str_replace(".zip", "", $file_name);
                $directory = 'new_banners/' . $file_path;
                if (!is_dir($directory)) {
                    if ($zip->open('new_banners/' . $file_name) === TRUE) {
                        // Unzip Path
                        $zip->extractTo($directory);
                        $zip->close();
                    }
                    unlink('new_banners/' . $file_name);
                }
            }
        }

        return redirect('/project/preview/view/'.$project_id);
    }

    function videoEditVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($version_id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);
        
        newVersion::where('id', $version_id)->update(['name' => $request->version_name]);
        return redirect('/project/preview/view/'.$project_id);
    }

    function gifEditVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($version_id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);
        
        newVersion::where('id', $version_id)->update(['name' => $request->version_name]);

        if($request->hasfile('gifupload')){
            $gifs = newGif::where('version_id', $version_id)->get();
            foreach ($gifs as $gif) {
                $file_path = public_path() . '/new_gif/' . $gif['file_path'];
                if(file_exists($file_path)){
                    // unlink('banner_collection/' . $sub_project['file_path']);
                    @unlink($file_path);
                }
                newGif::where('id', $gif->id)->delete();
            }

            $gif_size = $request->gif_size_id;
            $gifupload = $request->gifupload;

            foreach($gif_size as $index => $size){
                $removeX = explode("x", $size);
                $request_width = $removeX[0];
                $request_height = $removeX[1];
                $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
        
                $file_name = $sub_project_name . '_' . time() . rand() . '.' . $gifupload[$index]->extension();
                $gifupload[$index]->move(public_path('new_gifs/'), $file_name);
                $file_bytes = filesize(public_path('new_gifs/' . $file_name));
        
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];
        
                $gif = new newGif;
                $gif->name = $sub_project_name;
                $gif->size = $file_size;
                $gif->file_path = $file_name;
                $gif->size_id = $size_info['id'];
                $gif->version_id = $version_id;
                $gif->save();
            }
        }

        return redirect('/project/preview/view/'.$project_id);
    }

    function socialEditVersionPost(Request $request, $id){
        $version_id = $id;
        $version = newVersion::find($version_id);
        $feedback = newFeedback::find($version['feedback_id']);
        $project_id = $feedback['project_id'];
        $project = newPreview::find($project_id);
        $project_name = str_replace(" ", "_", $project['name']);
        
        newVersion::where('id', $version_id)->update(['name' => $request->version_name]);

        if($request->hasfile('socialupload')){
            $socials = newSocial::where('version_id', $version_id)->get();
            foreach ($socials as $social) {
                $file_path = public_path() . '/new_social/' . $social['file_path'];
                if(file_exists($file_path)){
                    // unlink('banner_collection/' . $sub_project['file_path']);
                    @unlink($file_path);
                }
                newSocial::where('id', $social->id)->delete();
            }

            $platforms = $request->platform; 
            $uploads = $request->socialupload;
    
            foreach($platforms as $index => $platform)
            {
                $original_file_name = $uploads[$index]->getClientOriginalName();
                $name = explode('.',$original_file_name);

                $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                $uploads[$index]->move(public_path('new_socials'), $file_name);

                list($width, $height) = getimagesize(public_path('new_socials/'.$file_name));

                $file_bytes = filesize(public_path('new_socials/'.$file_name));
                $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                $file_size = round($file_bytes, 2) . " " . $label[$i];

                $social = new newSocial;
                $social->name = $project_name .'_' . $platform . '_' . $name[0];
                $social->width = $width;
                $social->height = $height;
                $social->size = $file_size;
                $social->version_id = $version->id;
                $social->file_path = $file_name;
                $social->save();
            }
        }

        return redirect('/project/preview/view/'.$project_id);
    }

    function addFeedbackOrProjectTypeView($id){
        $project = newPreview::find($id);
        $logo_list = Logo::get();
        $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
        $video_sizes = Sizes::orderBy('width', 'DESC')->get();
        $company_details = Logo::where('id', Auth::user()->company_id)->first();
        $color = $company_details['default_color'];
        return view('newpreview.addprojecttype', compact('logo_list', 'size_list', 'color', 'project', 'video_sizes'));
    }

    function addFeedbackOrProjectTypePost(Request $request, $id){
        $project = newPreview::find($id);
        $project_name = str_replace(" ", "_", $project['name']);
        $project_type = $request->project_type;

        $feedback = new newFeedback;
        $feedback->project_id = $id;
        $feedback->name = $request->feedback_name;
        $feedback->project_type = $project_type;
        $feedback->description = $request->feedback_description;
        $feedback->is_active = 1;
        $feedback->save();

        $exceptionFeedbacks = newFeedback::select('id')->where('project_id', $project['id'])->where('id', '!=', $feedback->id)->get()->toArray();
        newFeedback::whereIn('id', $exceptionFeedbacks)->where('project_id', $project['id'])->update(['is_active' => 0]);

        $version = new newVersion;
        $version->name = $request->version_name;
        $version->feedback_id = $feedback->id;
        $version->is_active = 1;
        $version->save();

        // $exceptionVersions = newVersion::select('id')->where('id', '!=', $version->id)->get()->toArray();
        // newVersion::whereIn('id', $exceptionVersions)->update(['is_active' => 0]);

        newPreview::where('id', $id)->update(['is_version' => 1]);

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
                    $bannerupload[$index]->move(public_path('new_banners/'), $file_name);
                    $file_bytes = filesize(public_path('new_banners/' . $file_name));
            
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
                    $directory = 'new_banners/' . $file_path;
                    if (!is_dir($directory)) {
                        if ($zip->open('new_banners/' . $file_name) === TRUE) {
                            // Unzip Path
                            $zip->extractTo($directory);
                            $zip->close();
                        }
                        unlink('new_banners/' . $file_name);
                    }
                }
            }
        }
        else if($request->project_type == 2){
            //this is video upload method
            $validator = $request->validate([
                'poster' => 'mimes:jpeg,png,jpg,gif',
                'video' => 'required|mimes:mp4',
                'video_size_id' => 'required'
            ]);

            $size_info = Sizes::where('id', $request->video_size_id)->first();
            $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

            if($request->has('poster'))
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('new_posters'), $poster_name);
            }
            else
            {
                $poster_name = NULL;
            }


            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('new_videos'), $video_name);
            $video_bytes = filesize(public_path('/new_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

            $video = new newVideo;
            $video->name = $sub_project_name;
            $video->title = $request->video_title;
            $video->size_id = $request->video_size_id;
            $video->codec = $request->codec;
            $video->aspect_ratio = $request->aspect_ratio;
            $video->fps = $request->fps;
            $video->size = $video_size;
            $video->poster_path = $poster_name;
            $video->video_path = $video_name;
            $video->version_id = $version->id;
            $video->save();
        }
        else if($request->project_type == 3){
            //this is gif upload method
            if($request->hasfile('gifupload')){
                $gif_size = $request->gif_size_id;
                $gifupload = $request->gifupload;

                foreach($gif_size as $index => $size){
                    $removeX = explode("x", $size);
                    $request_width = $removeX[0];
                    $request_height = $removeX[1];
                    $size_info = BannerSizes::where('width', $request_width)->where('height', $request_height)->first();
                    $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
            
                    $file_name = $sub_project_name . '_' . time() . rand() . '.' . $gifupload[$index]->extension();
                    $gifupload[$index]->move(public_path('new_gifs/'), $file_name);
                    $file_bytes = filesize(public_path('new_gifs/' . $file_name));
            
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
            
                    $gif = new newGif;
                    $gif->name = $sub_project_name;
                    $gif->size = $file_size;
                    $gif->file_path = $file_name;
                    $gif->size_id = $size_info['id'];
                    $gif->version_id = $version->id;
                    $gif->save();
                }
            }
        }
        else if($request->project_type == 4){
            //this is social upload method
            if($request->hasfile('socialupload')){

                $validator = $request->validate([
                    'socialupload' => 'required',
                    'socialupload.*' => 'mimes:jpeg,jpg,png,gif'
                ]);
    
                $platforms = $request->platform; 
                $uploads = $request->socialupload;
    
                foreach($platforms as $index => $platform)
                {
                    $original_file_name = $uploads[$index]->getClientOriginalName();
                    $name = explode('.',$original_file_name);
    
                    $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                    $uploads[$index]->move(public_path('new_socials'), $file_name);

                    list($width, $height) = getimagesize(public_path('new_socials/'.$file_name));

                    $file_bytes = filesize(public_path('new_socials/'.$file_name));
                    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                    for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
                    $file_size = round($file_bytes, 2) . " " . $label[$i];
    
                    $social = new newSocial;
                    $social->name = $project_name .'_' . $platform . '_' . $name[0];
                    $social->width = $width;
                    $social->height = $height;
                    $social->size = $file_size;
                    $social->version_id = $version->id;
                    $social->file_path = $file_name;
                    $social->save();
                }
            }
        }
        else{
            return back()->with('danger', 'Pleae select correct project type');
        }

        return redirect('/project/preview/view/'.$id);
    }

    function feedbackEditView($id){
        $feedback = newFeedback::find($id);

        return view('newpreview.feedbackedit', compact('feedback', 'id'));
    }

    function feedbackEditPost(Request $request, $id){
        $feedback = newFeedback::find($id);
        newFeedback::where('id', $id)->update(['name' => $request->feedback_name, 'description' => $request->feedback_description]);

        return redirect('/project/preview/view/'.$feedback['project_id']);
    }

    function videoEditView($id){
        $sub_project_id = $id;
        $sub_project_info = newVideo::where('id', $id)->first();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        return view('newpreview.video.video_edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    function gifEditView($id){
        $sub_project_id = $id;
        $sub_project_info = newGif::where('id', $id)->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('newpreview.gif.gif_edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    function socialEditView($id){
        $sub_project_id = $id;
        $sub_project_info = newSocial::where('id', $id)->first();
        return view('newpreview.social.social_edit', compact('sub_project_info', 'sub_project_id'));
    }

    function videoEditPost(Request $request, $id){
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'mimes:mp4',
        ]);

        if($request->video_size_id != 0){
            $sub_project_id = $id;
            $sub_project_info = newVideo::find($id);
            $size_info = Sizes::where('id', $request->video_size_id)->first();
            $version_info = newVersion::where('id', $sub_project_info['version_id'])->first();
            $feedback_info = newFeedback::where('id', $version_info['feedback_id'])->first();
            $main_project_info = newPreview::where('id', $feedback_info['project_id'])->first();
            $sub_project_name = $main_project_info['name'].'_'.$size_info['width'].'x'.$size_info['height'];

            if($request->video != NULL){
                $poster_name = $sub_project_info['poster_path'];
                $video_path = public_path('new_videos/').$sub_project_info['video_path'];
                if (file_exists($video_path)) {
                    @unlink($video_path);
                }

                $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
                $request->video->move(public_path('new_videos'), $video_name);
                $video_bytes = filesize(public_path('/new_videos/'.$video_name));

                $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
                for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
                $video_size = round( $video_bytes, 2 ) . " " . $label[$i];
            }
            else if($request->poster != NULL)
            {
                $video_name = $sub_project_info['video_path'];
                $video_size = $sub_project_info['size'];
                if($sub_project_info['poster_path'] == NULL){
                    $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                    $request->poster->move(public_path('new_posters'), $poster_name);
                }
                else{
                    $poster_path = public_path('new_posters/').$sub_project_info['poster_path'];
                    if (file_exists($poster_path)) {
                        @unlink($poster_path);
                    }
                    //then add the new one
                    $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                    $request->poster->move(public_path('new_posters'), $poster_name);
                }
            }
            else{
                $poster_name = $sub_project_info['poster_path'];
                $video_name = $sub_project_info['video_path'];
                $video_size = $sub_project_info['size'];
            }

            $sub_project_details = [
                'name' => $sub_project_name,
                'title' => $request->title,
                'codec' => $request->codec,
                'size_id' => $request->video_size_id,
                'aspect_ratio' => $request->aspect_ratio,
                'fps' => $request->fps,
                'size' => $video_size,
                'poster_path' => $poster_name,
                'video_path' => $video_name
            ];

            newVideo::where('id', $sub_project_id)->update($sub_project_details);
            return redirect('/project/preview/view/'.$main_project_info->id);
        }
    }

    function gifEditPost(Request $request, $id){
        $validator = $request->validate([
            'upload' => 'required|mimes:gif'
        ]);

        if($request->gif_size_id != 0)
        {
            $gif_id = $id;
            $gif_info = newGif::where('id', $gif_id)->first();
            $old_file_directory = public_path() . '/new_gifs/' . $gif_info['file_path'];
            
            if(file_exists($old_file_directory)){
                @unlink($old_file_directory);
            }

            $version_info = newVersion::where('id', $gif_info['version_id'])->first();
            $feedback_info = newFeedback::where('id', $version_info['feedback_id'])->first();
            $project_info = newPreview::where('id', $feedback_info['project_id'])->first();
            $size_info = BannerSizes::where('id', $request->gif_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . rand() . '.' . $request->upload->extension();
            $request->upload->move(public_path('new_gifs'), $file_name);
            $file_bytes = filesize(public_path('/new_gifs/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];
    
            $sub_project_details = [
                'name' => $sub_project_name,
                'size_id' => $request->gif_size_id,
                'size' => $file_size,
                'file_path' => $file_name
            ];
    
            newGif::where('id', $gif_id)->update($sub_project_details);

            return redirect('/project/preview/view/' . $project_info['id']);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
    }

    function socialEditPost(Request $request, $id){
        $validator = $request->validate([
            'socialupload' => 'required',
            'socialupload.*' => 'mimes:jpeg,jpg,png,gif'
        ]);

        $social_id = $id;
        $social_info = newSocial::where('id', $social_id)->first();
        $old_file_directory = public_path() . '/new_socials/' . $social_info['file_path'];
        
        if(file_exists($old_file_directory)){
            @unlink($old_file_directory);
        }

        $version_info = newVersion::where('id', $social_info['version_id'])->first();
        $feedback_info = newFeedback::where('id', $version_info['feedback_id'])->first();
        $project_info = newPreview::where('id', $feedback_info['project_id'])->first();
        $project_name = $project_info['name'];

        $platforms = $request->platform; 
        $uploads = $request->socialupload;

        $original_file_name = $uploads->getClientOriginalName();
        $name = explode('.',$original_file_name);

        $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads->extension();
        $uploads->move(public_path('new_socials'), $file_name);

        list($width, $height) = getimagesize(public_path('new_socials/'.$file_name));

        $file_bytes = filesize(public_path('new_socials/'.$file_name));
        $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
        $file_size = round($file_bytes, 2) . " " . $label[$i];

        $sub_project_details = [
            'name' => $project_name .'_' . $platforms . '_' . $name[0],
            'width' => $width,
            'height' => $height,
            'size' => $file_size,
            'file_path' => $file_name
        ];

        newSocial::where('id', $social_id)->update($sub_project_details);

        return redirect('/project/preview/view/' . $project_info['id']);
    }

    function deletePreview($id){
        $feedbacks = newFeedback::where('project_id', $id)->get();

        foreach($feedbacks as $feedback){
            if($feedback['project_type'] == 1){
                $versions = newVersion::where('feedback_id', $feedback->id)->get();
                
                if($versions != NULL){
                    foreach($versions as $version){
                        $banners = newBanner::where('version_id', $version->id)->get();

                        foreach ($banners as $banner) {
                            $file_path = public_path() . '/new_banners/' . $banner['file_path'];
                            if(file_exists($file_path)){
                                // unlink('banner_collection/' . $sub_project['file_path']);
                                $files = File::deleteDirectory($file_path);
                            }
                            newBanner::where('id', $banner->id)->delete();
                        }
                        newVersion::where('id', $version->id)->delete();
                    }
                }
            }
            else if($feedback['project_type'] == 2){
                $versions = newVersion::where('feedback_id', $feedback->id)->get();
                
                if($versions != NULL){
                    foreach($versions as $version){
                        $videos = newVideo::where('version_id', $version->id)->get();

                        foreach ($videos as $video) {
                            $video_path = public_path() . '/new_videos/' . $video['video_path'];
                            if(file_exists($video_path)){
                                @unlink($video_path);
                            }
                            $poster_path = public_path() . '/new_posters/' . $video['poster_path'];
                            if(file_exists($poster_path)){
                                @unlink($poster_path);
                            }
                            newVideo::where('id', $video->id)->delete();
                        }
                        newVersion::where('id', $version->id)->delete();
                    }
                }
            }
            else if($feedback['project_type'] == 3){
                $versions = newVersion::where('feedback_id', $feedback->id)->get();

                if($versions != NULL){
                    foreach($versions as $version){
                        $gifs = newGif::where('version_id', $version->id)->get();

                        foreach ($gifs as $gif) {
                            $file_path = public_path() . '/new_gifs/' . $gif['file_path'];
                            if(file_exists($file_path)){
                                @unlink($file_path);
                            }
                            newGif::where('id', $gif->id)->delete();
                        }
                        newVersion::where('id', $version->id)->delete();
                    }
                }
            }
            else if($feedback['project_type'] == 4){
                $versions = newVersion::where('feedback_id', $feedback->id)->get();

                if($versions != NULL){
                    foreach($versions as $version){
                        $socials = newSocial::where('version_id', $version->id)->get();

                        foreach ($socials as $social) {
                            $file_path = public_path() . '/new_socials/' . $social['file_path'];
                            if(file_exists($file_path)){
                                @unlink($file_path);
                            }
                            newSocial::where('id', $social->id)->delete();
                        }
                        newVersion::where('id', $version->id)->delete();
                    }
                }
            }
            else{
                dd('Getting another project type. Something is not right');
            }

            newFeedback::where('id', $feedback->id)->delete();
        }

        newPreview::where('id', $id)->delete();

        return redirect('/view-previews')->with('warning', 'Preview has been deleted!');
    }
}
