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
use App\BannerCategories;
use App\Feedback;
use App\Banner;
use App\AllVideos;
use App\AllGifs;
use App\AllSocials;
use App\CreativeCategories;

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

    public static function getProjectColor($id){
        $data = MainProject::where('id', $id)->first();
        return $data['color'];
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

    public static function getNewMainBannerIds($id)
    {
        $banner_ids = Banner::join('main_project', 'banner_categories_list.project_id', 'main_project.id')
                                ->select('main_project.id')
                                ->where('main_project.uploaded_by_company_id', $id)
                                ->where('main_project.project_type', 4)
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

    public static function getFeedbackName($id){
        $feedback = Feedback::where('id', $id)->first();
        return $feedback['name'];
    }

    public static function getFeedbackList($id){
        $feedback = Feedback::where('id', $id)->first();
        return $feedback['description'];
    }

    public static function getFeedbackStatus($id){
        $data = Feedback::where('id', $id)->first();
        return $data['is_open'];
    }

    public static function getFeedbackDate($id){
        $data = Feedback::where('id', $id)->first();
        return $data['created_at'];
    }

    public static function getCategoryName($id){
        $category = BannerCategories::where('id', $id)->first();
        return $category['name'];
    }

    public static function getFeedbackCategoryCount($id){
        return BannerCategories::where('feedback_id', $id)->get()->count();
    }

    public static function getBannerInfo($id){
        $banner = Banner::where('id', $id)->first();
        return $banner['name'];
    }

    public static function getBannerSizeinfo($id){
        $banner = Banner::where('id', $id)->first();
        $size = BannerSizes::where('id', $banner['size_id'])->first();
        return $size['width'].'x'.$size['height'];
    }

    public static function getBannerFileSize($id){
        $banner = Banner::where('id', $id)->first();
        return $banner['size'];
    }

    public static function getVideoResolution($id){
        $data = Sizes::where('id', $id)->first();
        return $data['width'].'x'.$data['height'];
    }

    public static function getVideoAspectRatio($id){
        $data = AllVideos::where('id', $id)->first();
        return $data['aspect_ratio'];
    }

    public static function getProjectCreationDate($id){
        $data = MainProject::where('id', $id)->first();
        return $data['created_at'];
    }

    public static function getTotalBannersCount($id){
        return Banner::where('project_id', $id)->count();
    }

    public static function getTotalVideosCount($id){
        return AllVideos::where('project_id', $id)->count();
    }

    public static function getTotalGifsCount($id){
        return AllGifs::where('project_id', $id)->count();
    }

    public static function getTotalSocialsCount($id){
        return AllSocials::where('project_id', $id)->count();
    }

    public static function getVideoCountInsideFeedback($id){
        $video = AllVideos::where('id', $id)->first();
        $feedback_id = $video['feedback_id'];
        return AllVideos::where('feedback_id', $feedback_id)->count();
    }

    public static function getWebsiteOfLogo($id){
        $logo = Logo::where('id', $id)->first();
        return $logo['website'];
    }
}