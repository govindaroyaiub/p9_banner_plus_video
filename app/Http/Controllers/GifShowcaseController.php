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
use App\AllGifs;
use App\CreativeCategories;

class GifShowcaseController extends Controller
{
    public function gif_list(){
        if(Auth::user()->company_id == 1){
            $gifs = MainProject::where('project_type', 7)->orderBy('created_at', 'DESC')->get();
        }
        else{
            $gifs = MainProject::where('project_type', 7)->where('logo_id', Auth::user()->company_id)->orderBy('created_at', 'DESC')->get();
        }
        return view('new_files/gif/list', compact('gifs'));
    }
}
