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
use \App\Mail\SendMail;
use App\Helper\Helper;

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

            // $sub_project_info = BannerProject::join('banner_sizes', 'banner_projects.size_id', 'banner_sizes.id')
            //                                 ->select(
            //                                     'banner_projects.id',
            //                                     'banner_projects.name',
            //                                     'banner_projects.size',
            //                                     'banner_projects.file_path',
            //                                     'banner_sizes.width',
            //                                     'banner_sizes.height'
            //                                 )
            //                                 ->where('project_id', $main_project_id)
            //                                 ->get();       

            $data = [];

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
                                            ->where('version_id', $version_id)
                                            ->get();

                foreach($sub_project_info as $sub_project){
                    $banner_id = $sub_project->id;
                    $data[$version_id][$banner_id] = $sub_project;
                }
            }                

            // return view('view_banner.banner-index', compact(
            // 'main_project_info',
            // 'sub_project_info',
            // 'main_project_id'
            // ));

            return view('view_banner.banner-develop', compact(
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
        $result = MainProject::where('id', $id)->update(['color' => $color]);
        return 200;
    }
}
