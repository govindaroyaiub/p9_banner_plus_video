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
use App\Social;

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

    public static function getVersionDate($id){
        $data = Version::where('id', $id)->first();
        return $data['created_at'];
    }

    public static function getVersionStatus($id){
        $data = Version::where('id', $id)->first();
        return $data['is_open'];
    }

    public static function getImageResolution($id){
        $social = Social::where('id', $id)->first();
        $file_path = 'social_collection/'.$social['file_path'];
        list($width, $height, $type, $attr) = getimagesize($file_path);

        return $width.'x'.$height;
    }


    public static function getImageFileSize($id){
        $social = Social::where('id', $id)->first();
        $file_path = 'social_collection/'.$social['file_path'];

        $file_bytes = filesize($file_path);
        $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
        $file_size = round($file_bytes, 2) . " " . $label[$i];

        return $file_size;
    }
}