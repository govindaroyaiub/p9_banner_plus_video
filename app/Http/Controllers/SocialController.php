<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\MainProject;
use App\SubProject;
use App\Comments;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use App\BannerProject;
use App\Gif;
use App\Version;
Use App\Social;
use \App\Mail\SendMail;
use App\Helper\Helper;

class SocialController extends Controller
{
    function view_socials_list(){
        return view('view_social.socials');
    }
}
