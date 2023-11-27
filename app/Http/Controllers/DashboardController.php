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
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function dashboard2(){
        

        return view('material_ui.dashboard.dashboard');
    }
}
