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
use App\Social;
use App\BannerCategories;
use App\Feedback;
use App\NewBannerList;
use \App\Mail\SendMail;
use App\Helper\Helper;

class bannerShowcaseController extends Controller
{
    public function bannerShowcaseList(){
        return view('view_bannershowcase.showcase-list');
    }
}
