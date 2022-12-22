<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;
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
use App\Banner;
use App\CreativeCategories;
use App\AllVideos;
use App\AllSocials;
use App\AllGifs;
use \App\Mail\SendMail;
use App\Helper\Helper;
use Carbon\Carbon;

class ProjectConTroller extends Controller
{
    public function video_view($id)
    {
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $sub_project_info = SubProject::join('sizes', 'sub_project.size_id', 'sizes.id')
                                            ->select(
                                                'sub_project.id',
                                                'sub_project.name as sub_name',
                                                'sub_project.title',
                                                'sub_project.codec',
                                                'sub_project.aspect_ratio',
                                                'sub_project.fps',
                                                'sub_project.size',
                                                'sub_project.poster_path',
                                                'sub_project.video_path',
                                                'sizes.name as size_name',
                                                'sizes.width',
                                                'sizes.height'
                                            )
                                            ->where('project_id', $main_project_id)
                                            ->orderBy('sizes.width', 'DESC')
                                            ->get();             

            $comments = Comments::where('project_id', $main_project_id)->orderBy('created_at', 'DESC')->get();
            $comments_count = Comments::where('project_id', $main_project_id)->get()->count();

            return view('index-main', compact(
            'main_project_info',
            'sub_project_info',
            'comments',
            'comments_count',
            'main_project_id'
            ));
        }
        else 
        {
            return view('404');
        }
    }

    public function banner_view($id)
    {
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.is_version',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $versions = Version::where('project_id', $main_project_id)->get();
            $totalBanners = BannerProject::where('project_id', $main_project_id)->get();
            $data = [];

            //if banner has no version but has banners
            if(($versions->count() == 0 && $totalBanners->count() > 0) || ($versions->count() == 0 && $totalBanners->count() == 0)){
                $sub_project_info = BannerProject::join('banner_sizes', 'banner_projects.size_id', 'banner_sizes.id')
                                                ->select(
                                                    'banner_projects.id',
                                                    'banner_projects.name',
                                                    'banner_projects.size',
                                                    'banner_projects.file_path',
                                                    'banner_sizes.width',
                                                    'banner_sizes.height'
                                                )
                                                ->where('banner_projects.project_id', $main_project_id)
                                                ->get();
            }
            //else there are versions and banners
            else{
                foreach($versions as $version){
                    $version_id = $version->id;

                    $sub_project_info = BannerProject::join('banner_sizes', 'banner_projects.size_id', 'banner_sizes.id')
                                                ->select(
                                                    'banner_projects.id',
                                                    'banner_projects.name',
                                                    'banner_projects.size',
                                                    'banner_projects.file_path',
                                                    'banner_sizes.width',
                                                    'banner_sizes.height'
                                                )
                                                ->where('banner_projects.version_id', $version_id)
                                                ->get();

                    foreach($sub_project_info as $sub_project){
                        $banner_id = $sub_project->id;
                        $data[$version_id][$banner_id] = $sub_project;
                    }
                }
            }
            // return view('view_banner.banner-index', compact(
            // 'main_project_info',
            // 'sub_project_info',
            // 'main_project_id'
            // ));

            return view('view_banner.banner-index', compact(
                'main_project_info',
                'versions',
                'sub_project_info',
                'main_project_id',
                'data'
            ));
        }
        else 
        {
            return view('404');
        }
    }

    public function gif_view($id)
    {
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $sub_project_info = Gif::join('banner_sizes', 'gif_projects.size_id', 'banner_sizes.id')
                                            ->select(
                                                'gif_projects.id',
                                                'gif_projects.name',
                                                'gif_projects.size',
                                                'gif_projects.file_path',
                                                'banner_sizes.width',
                                                'banner_sizes.height'
                                            )
                                            ->where('project_id', $main_project_id)
                                            ->get();             

            return view('view_gif.gif-index', compact(
            'main_project_info',
            'sub_project_info',
            'main_project_id'
            ));
        }
        else 
        {
            return view('404');
        }
    }

    public function social_view($id)
    {
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $socials_info = Social::where('project_id', $main_project_id)->get();             

            return view('view_social.social-develop', compact(
            'main_project_info',
            'socials_info',
            'main_project_id'
            ));
        }
        else 
        {
            return view('404');
        }
    }

    public function banner_showcase_view($id){
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.is_version',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $feedbacks = Feedback::where('project_id', $main_project_id)->get();
            $categories = BannerCategories::where('id', $main_project_id)->get();
            $banners = Banner::where('project_id', $main_project_id)->get();
            $data = [];
            $is_version = false;
            $is_category = false;

            if($main_project_info['is_version'] == 0){
                $data = Banner::where('project_id', $main_project_id)->get();
                $is_version == false;
            }
            else{
                foreach($feedbacks as $index => $feedback){
                    $categories = BannerCategories::where('feedback_id', $feedback->id)->get();
                    foreach($categories as $index => $category){
                        $banners = Banner::where('category_id', $category->id)->get();
                        foreach($banners as $index => $banner){
                            $data[$feedback->id][$category->id][$banner->id] = $banner;
                        }
                    }
                    $is_version = true;
                }
            }
            if($main_project_info['logo_id'] == 7){
                return view('view_bannershowcase.custom-showcase-index', compact(
                    'main_project_info',
                    'main_project_id',
                    'data',
                    'is_version',
                    'banners'
                ));
            }
            else{
                // return view('view_bannershowcase.showcase-index', compact(
                //     'main_project_info',
                //     'main_project_id',
                //     'data',
                //     'is_version',
                //     'banners'
                // ));

                return view('view_bannershowcase.new_preview.new-showcase-index', compact(
                    'main_project_info',
                    'main_project_id',
                    'data',
                    'is_version',
                    'banners'
                ));
            }
        }
        else 
        {
            return view('404');
        }
    }

    public function video_showcase_view(Request $request, $id){
        $main_project_id = $id;
        $main_project_info = MainProject::join('logo', 'main_project.logo_id', 'logo.id')
                                        ->select(
                                            'main_project.name as name',
                                            'main_project.client_name',
                                            'main_project.logo_id',
                                            'main_project.color',
                                            'main_project.is_logo',
                                            'main_project.is_footer',
                                            'main_project.is_version',
                                            'main_project.uploaded_by_company_id',
                                            'main_project.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('main_project.id', $main_project_id)
                                        ->first();

        if($main_project_info != NULL)
        {
            $feedbacks = Feedback::where('project_id', $main_project_id)->get();
            $categories = CreativeCategories::where('id', $main_project_id)->get();
            $videos = AllVideos::where('project_id', $main_project_id)->get();
            $data = [];
            $is_version = false;
            $is_category = false;

            if($main_project_info['is_version'] == 0){
                $data = AllVideos::where('project_id', $main_project_id)->get();
                $is_version == false;
            }
            else{
                foreach($feedbacks as $index => $feedback){
                    $categories = CreativeCategories::where('feedback_id', $feedback->id)->get();
                    foreach($categories as $index => $category){
                        $videos = AllVideos::where('category_id', $category->id)->get();
                        foreach($videos as $index => $video){
                            $data[$feedback->id][$category->id][$video->id] = $video;
                        }
                    }
                    $is_version = true;
                }
            }

            return view('new_files.video.index', compact(
                'main_project_info',
                'main_project_id',
                'data',
                'is_version',
                'videos'
            ));
        }
        else 
        {
            return view('404');
        }
    }

    public function store_comments(Request $request, $id)
    {
        $project_id = $id;
        $project_info = MainProject::where('id', $id)->first();
        $project_name = str_replace("_"," ", $project_info['name']);

        $comment = new Comments;
        $comment->project_id = $project_id;
        $comment->comment = $request->comment;
        $comment->save();

        $details = [
            'title' => $project_name,
            'comment' => $request->comment,
            'id' => $project_id
        ];

        $user_list = User::where('is_send_mail', 1)->get()->toArray();
        $to = array_column($user_list, 'email');
        // $to = array('govinda@planetnine.com');

        \Mail::to($to)->send(new SendMail($details));
    }

    public function get_comments($id)
    {
        $result = Comments::where('project_id', $id)->orderBy('created_at', 'DESC')->get();
        $result_count = Comments::where('project_id', $id)->get()->count();
        if($result_count > 0)
        {
            foreach($result as $row)
            {
                echo '<textarea cols="5" rows="3" class="w-full bg-gray-300 border border-gray-600 focus:outline-none rounded-lg" readonly>'.$row->comment.'</textarea>';
            }
        }
    }

    public function set_color(Request $request, $id)
    {
        $color = $request->color;
        MainProject::where('id', $id)->update(['color' => $color]);
        return 200;
    }

    public function setVersionViewStatus(Request $request, $version_id){
        $displayStatus = $request->displayStatus;
        $version_id = trim($version_id, "version");

        if($displayStatus == 'block'){
            $is_open = 1;
        }
        else{
            $is_open = 0;
        }
        
        Version::where('id', $version_id)->update(['is_open' => $is_open]);
        return $is_open;
    }

    public function setFeedbackStatus(Request $request, $version_id){
        $displayStatus = $request->displayStatus;
        $version_id = trim($version_id, "version");

        if($displayStatus == 'block'){
            $is_open = 1;
        }
        else{
            $is_open = 0;
        }
        
        Feedback::where('id', $version_id)->update(['is_open' => $is_open]);
        return $is_open;
    }

    public function doLogin(Request $request){
        $validator = $request->validate([
            'email' => 'required|email',   // required and email format validation
            'password' => 'required', // required and number field validation
        ]);

        if (Auth::attempt($request->only(["email", "password"]))) {
            return response()->json(["status" => true]);
            
        } else {
            return response()->json([["Invalid credentials"]],422);
        }
    }

    public function doLogout(){
        Auth::logout();
        return redirect()->back();
    }


    public function getBannersForFeedback($project_id, $id){
        $feedback_id = trim($id,"version");
        Feedback::where('id', $feedback_id)->update(['is_open' => 1]);

        $exceptionFeedbacks = Feedback::select('id')->where('id', '!=', $feedback_id)->get()->toArray();

        Feedback::whereIn('id', $exceptionFeedbacks)->update(['is_open' => 0]);

        $feedbacks = Feedback::where('id', $feedback_id)->get();
        $categories = BannerCategories::where('project_id', $project_id)->where('feedback_id', $feedback_id)->get();
        $banners = Banner::where('project_id', $project_id)->where('feedback_id', $feedback_id)->get();
        $data = [];

        $categories = BannerCategories::where('feedback_id', $feedback_id)->get();
        foreach($categories as $index => $category){
            $banners = Banner::where('category_id', $category->id)->get();
            foreach($banners as $index => $banner){
                $data[$category->id][$banner->id] = $banner;
            }
        }

        return response()->json($data);
    }

    public function getFeedbackNameDate($id){
        $category = BannerCategories::where('id', $id)->first();
        return $category['name'].' | '.Carbon::parse($category['created_at'])->format('d F Y H:s:i');
    }

    public function getBannersData($feedbackId, $categoryId){
        $feedback_id = trim($feedbackId,"version");
        return Banner::where('category_id', $categoryId)->where('feedback_id', $feedback_id)->get();
    }
}
