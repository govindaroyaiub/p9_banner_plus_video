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

    public function videoshowcase_add_post(){
        dd('asdasd');
    }
}