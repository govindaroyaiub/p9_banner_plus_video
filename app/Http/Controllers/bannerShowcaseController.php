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
        //show the banner project add page
    }

    public function banner_project_add_post(){
        //post function to insert the banner(s)
    }

    public function banner_project_edit_view(){
        //show the banner project edit page
    }

    public function banner_project_edit_post(){
        //post function to update the project
    }

    public function banner_project_delete(){
        //delete function to remove the entire project
    }

    public function banner_add_feedback_view(){
        //show the banner add on page. where the banner can be uploaded to the existing preview or create a new feeback round
    }

    public function banner_add_feedback_post(){
        //post function to insert the add on banners. here the main logic will reside into the database
    }

    public function banner_edit_feedback_view(){
        //banner feedback edit page
    }

    public function banner_edit_feedback_post(){
        //post function to update the banner feedback id
    }

    public function banner_delete_feedback(){
        //delete the banner feedback id and as well as directories
    }

    public function banner_index_view_delete(){
        //this is the Delete All Button click action where the banners will be deleted but the project itself will stay
    }

    public function banner_add_category_view(){
        //banner add category page from the preview page
    }

    public function banner_add_category_post(){
        //post function to add a category inside the feedback
    }

    public function banner_edit_category_view(){
        //category edit function view
    }

    public function banner_edit_category_post(){
        //post function to update the category
    }

    public function banner_delete_category(){
        //delete the category
    }
}
