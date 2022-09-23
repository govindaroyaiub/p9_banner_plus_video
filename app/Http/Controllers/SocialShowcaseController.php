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
use App\AllSocials;
use App\CreativeCategories;

class SocialShowcaseController extends Controller
{
    public function social_list(){
        if(Auth::user()->company_id == 1){
            $socials = MainProject::where('project_type', 8)->orderBy('created_at', 'DESC')->get();
        }
        else{
            $socials = MainProject::where('project_type', 8)->where('logo_id', Auth::user()->company_id)->orderBy('created_at', 'DESC')->get();
        }
        return view('new_files/social/list', compact('socials'));
    }
}
