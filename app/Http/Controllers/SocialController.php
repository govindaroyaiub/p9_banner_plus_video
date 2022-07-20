<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
Use App\Social;
use \App\Mail\SendMail;
use App\Helper\Helper;

class SocialController extends Controller
{
    function view_socials_list(){
        $socials = MainProject::where('project_type', 3)
                                        ->where('uploaded_by_company_id', Auth::user()->company_id)
                                        ->orderBy('created_at', 'DESC')
                                        ->get();
        return view('view_social.socials', compact('socials'));
    }

    function add_socials(){
        $logo_list = Logo::get();
        $company_details = Logo::where('id', Auth::user()->company_id)->first();
        $color = $company_details['default_color'];
        return view('view_social.social_add', compact('logo_list', 'color'));
    }

    function add_socials_post(Request $request){
        if($request->hasfile('upload')){

            $validator = $request->validate([
                'upload' => 'required',
                'upload.*' => 'mimes:jpeg,jpg,png'
            ]);

            $platforms = $request->platform; 
            $uploads = $request->upload;

            $pro_name = $request->project_name;
            $project_name = str_replace(" ", "_", $request->project_name);

            $main_project = new MainProject;
            $main_project->name = $pro_name;
            $main_project->client_name = $request->client_name;
            $main_project->logo_id = $request->logo_id;
            $main_project->color = $request->color;
            $main_project->is_logo = 1;
            $main_project->is_footer = 1;
            $main_project->project_type = 3;
            $main_project->is_version = 0;
            $main_project->uploaded_by_user_id = Auth::user()->id;
            $main_project->uploaded_by_company_id = Auth::user()->company_id;
            $main_project->save();

            $array = [];

            foreach($platforms as $index => $platform)
            {
                $original_file_name = $uploads[$index]->getClientOriginalName();
                $name = explode('.',$original_file_name);

                $file_name = $pro_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                $uploads[$index]->move(public_path('social_collection'), $file_name);

                $data = array(
                    'name' => $pro_name .'_' . $platform . '_' . $name[0],
                    'project_id' => $main_project->id,
                    'file_path' => $file_name
                );

                array_push($array, $data);
            }
            Social::insert($array);

            return redirect('/project/social/view/' . $main_project->id);
        }
    }
}
