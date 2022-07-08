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
use App\Version;

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

    public static function getLogo($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['path'];
    }

    public static function getColor($id)
    {
        $company_details = Logo::where('id', $id)->first();
        return $company_details['default_color'];
    }

    public static function getUsername($id)
    {
        $user_details = User::where('id', $id)->first();
        $username = $user_details['name'];
        return $username;
    }

    public static function getMainBannerIds($id)
    {
        $banner_ids = BannerProject::join('main_project', 'banner_projects.project_id', 'main_project.id')
                                ->select('main_project.id')
                                ->where('main_project.uploaded_by_company_id', $id)
                                ->where('main_project.project_type', 0)
                                ->get()
                                ->toArray();

        return $banner_ids;
    }

    public static function getVersionName($id)
    {
        $data = Version::where('id', $id)->first();
        return $data['title'];
    }
}