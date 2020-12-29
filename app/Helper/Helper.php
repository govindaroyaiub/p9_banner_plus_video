<?php
namespace App\Helper;

use App\User;
use App\MainProject;
use App\SubProject;
use App\Comments;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use App\BannerProject;

class Helper
{
    public static function getTitle($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['name'];
    }

    public static function getWebsite($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['website'];
    }

    public static function getFavicon($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['favicon'];
    }

    public static function getCompanyWebsite($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['company_website'];
    }

    public static function getUserDetails($id)
    {
        $user_details = User::where('id', $id)->first();
        return $user_details;
    }
}