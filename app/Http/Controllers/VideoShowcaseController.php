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
use App\Feedback;
use App\Banner;
use App\Helper\Helper;
use Session;
use App\SubProject;
use App\Comments;
use App\AllVideos;
use App\CreativeCategories;

class VideoShowcaseController extends Controller
{
    public function video_list(){
        if(Auth::user()->company_id == 1){
            $videos = MainProject::where('project_type', 6)->orderBy('created_at', 'DESC')->get();
        }
        else{
            $videos = MainProject::where('project_type', 6)->where('logo_id', Auth::user()->company_id)->orderBy('created_at', 'DESC')->get();
        }
        return view('new_files/video/list', compact('videos'));
    }

    public function videoshowcase_add_view(){
        $logo_list = Logo::get();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        $company_details = Logo::where('id', Auth::user()->company_id)->first();
        $color = $company_details['default_color'];
        return view('new_files/video/add', compact('logo_list', 'size_list', 'color'));
    }

    public function videoshowcase_add_post(Request $request){
        if($request->size_id == 0){
            return back()->with('danger', 'Please select the size format!');
        }

        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'required|mimes:mp4',
            'size_id' => 'required'
        ]);

        $pro_name = $request->project_name;
        $project_name = str_replace(" ","_", $request->project_name);

        $size_info = Sizes::where('id', $request->size_id)->first();
        $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

        if($request->has('poster'))
        {
            $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
            $request->poster->move(public_path('poster_images'), $poster_name);
        }
        else
        {
            $poster_name = NULL;
        }

        $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
        $request->video->move(public_path('banner_videos'), $video_name);
        $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
        $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

        $logo_details = Logo::where('id', $request->logo_id)->first();

        $main_project = new MainProject;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $logo_details['default_color'];
        $main_project->is_logo = 1;
        $main_project->is_footer = $request->is_footer;
        $main_project->project_type = 6;
        $main_project->uploaded_by_user_id = Auth::user()->id;
        $main_project->uploaded_by_company_id = Auth::user()->company_id;
        $main_project->save();

        $feedback = new Feedback;
        $feedback->project_id = $main_project->id;
        $feedback->name = $request->feedback_name;
        $feedback->description = $request->feedback_description;
        $feedback->is_open = 1;
        $feedback->save();

        $category = new CreativeCategories;
        $category->name = $request->category_name;
        $category->project_id = $main_project->id;
        $category->feedback_id = $feedback->id;
        $category->save();

        $video = new AllVideos;
        $video->name = $sub_project_name;
        $video->title = $request->title;
        $video->project_id = $main_project->id;
        $video->size_id = $request->size_id;
        $video->codec = $request->codec;
        $video->aspect_ratio = $request->aspect_ratio;
        $video->fps = $request->fps;
        $video->size = $video_size;
        $video->poster_path = $poster_name;
        $video->video_path = $video_name;
        $video->feedback_id = $feedback->id;
        $video->category_id = $category->id;
        $video->save();

        return redirect('/project/video-showcase/view/'.$main_project->id);
    }

    public function videoshowcase_delete($id){
        $main_project_info = MainProject::where('id', $id)->first();

        $videos = AllVideos::where('project_id', $id)->get();
        foreach($videos as $video)
        {
            if($video->poster_path != NULL)
            {
                $poster_path = public_path('poster_images/').$video->poster_path;
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
            }
            $video_path = public_path('banner_videos/').$video->video_path;
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            AllVideos::where('id', $video->id)->delete();
        }
        CreativeCategories::where('project_id', $id)->delete();
        Feedback::where('project_id', $id)->delete();
        MainProject::where('id', $id)->delete();
        return redirect('/video-showcase')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    public function video_delete($id){
        $video = AllVideos::where('id', $id)->first();

        if($video['poster_path'] != NULL)
        {
            $poster_path = public_path('poster_images/').$video['poster_path'];
            if (file_exists($poster_path)) {
                @unlink($poster_path);
            }
        }

        $video_path = public_path('banner_videos/').$video['video_path'];
        if (file_exists($video_path)) {
            @unlink($video_path);
        }
        $video_count = MainProject::where('id', $video['project_id'])->count();
        if($video_count == 1){
            CreativeCategories::where('project_id', $video['project_id'])->delete();
            Feedback::where('project_id', $video['project_id'])->delete();
        }
        AllVideos::where('id', $id)->delete();

        return redirect('/project/video-showcase/view/'.$video['project_id']);
    }

    public function video_edit_view($id){
        $sub_project_id = $id;
        $sub_project_info = AllVideos::where('id', $id)->first();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        return view('new_files/video/video_edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    public function video_edit_post(Request $request, $id){
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'mimes:mp4',
        ]);

        $sub_project_id = $id;
        $sub_project_info = AllVideos::where('id', $id)->first();
        $size_info = Sizes::where('id', $request->size_id)->first();
        $main_project_info = MainProject::where('id', $sub_project_info['project_id'])->first();
        $sub_project_name = $main_project_info['name'].'_'.$size_info['width'].'x'.$size_info['height'];


        if($request->poster != NULL && $request->video != NULL)
        {
            if($sub_project_info['poster_path'] == NULL)
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            else
            {
                $poster_path = public_path('poster_images/').$sub_project_info['poster_path'];
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
                //then add the new one
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            $video_path = public_path('banner_videos/').$sub_project_info['video_path'];
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('banner_videos'), $video_name);
            $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];
        }
        else if($request->poster == NULL && $request->video != NULL)
        {
            $poster_name = $sub_project_info['poster_path'];
            $video_path = public_path('banner_videos/').$sub_project_info['video_path'];
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('banner_videos'), $video_name);
            $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];
        }
        else if($request->poster != NULL && $request->video == NULL)
        {
            $video_name = $sub_project_info['video_path'];
            $video_size = $sub_project_info['size'];
            if($sub_project_info['poster_path'] == NULL)
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            else
            {
                $poster_path = public_path('poster_images/').$sub_project_info['poster_path'];
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
                //then add the new one
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
        }
        else
        {
            $poster_name = $sub_project_info['poster_path'];
            $video_name = $sub_project_info['video_path'];
            $video_size = $sub_project_info['size'];
        }

        $sub_project_details = [
            'name' => $sub_project_name,
            'title' => $request->title,
            'codec' => $request->codec,
            'size_id' => $request->size_id,
            'aspect_ratio' => $request->aspect_ratio,
            'fps' => $request->fps,
            'size' => $video_size,
            'poster_path' => $poster_name,
            'video_path' => $video_name
        ];

        AllVideos::where('id', $sub_project_id)->update($sub_project_details);
        return redirect('/project/video-showcase/view/'.$main_project_info['id']);
    }
}
