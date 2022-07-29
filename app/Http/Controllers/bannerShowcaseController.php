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
use App\BannerList;
use \App\Mail\SendMail;
use App\Helper\Helper;

class bannerShowcaseController extends Controller
{
    public function bannerShowcaseList(){
        return view('view_bannershowcase.showcase-list');
    }

    public function banner_project_add_view(){

    }

    public function banner_project_add_post(){

    }

    public function banner_project_edit_view(){

    }

    public function banner_project_edit_post(){

    }

    public function banner_project_delete(){

    }

    public function banner_add_feedback_view(){

    }

    public function banner_add_feedback_post(){

    }

    public function banner_edit_feedback_view(){

    }

    public function banner_edit_feedback_post(){

    }

    public function banner_delete_feedback(){

    }

    public function banner_add_category_view(){

    }

    public function banner_add_category_post(){

    }

    public function banner_edit_category_view(){

    }

    public function banner_edit_category_post(){

    }

    public function banner_delete_category(){

    }
}
