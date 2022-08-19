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
        if(Auth::user()->company_id == 1){
            $socials = MainProject::where('project_type', 3)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        }
        else{
            $socials = MainProject::where('project_type', 3)
                                ->where('uploaded_by_company_id', Auth::user()->company_id)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        }
        
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

                $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                $uploads[$index]->move(public_path('social_collection'), $file_name);

                $social = new Social;
                $social->name = $project_name .'_' . $platform . '_' . $name[0];
                $social->project_id = $main_project->id;
                $social->file_path = $file_name;
                $social->save();
            }

            return redirect('/project/social/view/' . $main_project->id);
        }
    }

    function social_addon($id){
        $main_project_id = $id;
        return view('view_social.social_addon', compact('main_project_id'));
    }

    function social_addon_post($id, Request $request){
        if($request->hasfile('upload')){

            $validator = $request->validate([
                'upload' => 'required',
                'upload.*' => 'mimes:jpeg,jpg,png'
            ]);

            $platforms = $request->platform; 
            $uploads = $request->upload;

            $pro_name = MainProject::where('id', $id)->first();
            $project_name = str_replace(" ", "_", $pro_name['name']);

            $array = [];

            foreach($platforms as $index => $platform)
            {
                $original_file_name = $uploads[$index]->getClientOriginalName();
                $name = explode('.',$original_file_name);

                $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $uploads[$index]->extension();
                $uploads[$index]->move(public_path('social_collection'), $file_name);

                $data = array(
                    'name' => $project_name .'_' . $platform . '_' . $name[0],
                    'project_id' => $id,
                    'file_path' => $file_name
                );

                array_push($array, $data);
            }
            Social::insert($array);

            return redirect('/project/social/view/' . $id);
        }
    }

    function social_edit_single($id){
        return view('view_social.social_edit_single', compact('id'));
    }

    function social_edit_single_post(Request $request, $id){
        $validator = $request->validate([
            'upload' => 'required|file|mimes:jpeg,jpg,png'
        ]);

        $social_id = $id;
        $social_info = Social::where('id', $social_id)->first();
        $project_info = Mainproject::where('id', $social_info['project_id'])->first();
        $project_name = str_replace(" ", "_", $project_info['name']);

        unlink('social_collection/' . $social_info['file_path']);

        $original_file_name = $request->upload->getClientOriginalName();
        $name = explode('.',$original_file_name);

        $file_name = $project_name . '_' . $name[0] . '_' . time() . '.' . $request->upload->extension();
        $request->upload->move(public_path('social_collection'), $file_name);

        $data = array(
            'name' => $project_name .'_' . $request->platform . '_' . $name[0],
            'file_path' => $file_name
        );

        Social::where('id', $social_id)->update($data);

        return redirect('/project/social/view/' . $project_info['id']);
    }

    function social_project_delete($id){
        $main_project_info = MainProject::where('id', $id)->first();

        $social_project_info = Social::where('project_id', $id)->get();
        foreach($social_project_info as $social_project)
        {
            if($social_project->file_path != NULL)
            {
                $image_path = public_path('social_collection/').$social_project->file_path;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }
            }
            Social::where('id', $social_project->id)->delete();
        }
        MainProject::where('id', $id)->delete();
        return redirect('/social')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    function social_single_delete($id){
        $sub_project = Social::where('id', $id)->first();
        $image_path = public_path('social_collection/').$sub_project['file_path'];
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
        Social::where('id', $id)->delete();
        return back();
    }

    function delete_all_socials($id){
        $main_project_info = MainProject::where('id', $id)->first();

        $social_project_info = Social::where('project_id', $id)->get();
        if (($social_project_info->count() != 0)) {
            foreach ($social_project_info as $social_project) {
                $image_path = public_path('social_collection/').$social_project->file_path;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }
                Social::where('id', $social_project->id)->delete();
            }
        }

        return redirect('/project/social/addon/'.$id)->with('danger', 'Assets been deleted! Please Re-upload.');
    }
}
