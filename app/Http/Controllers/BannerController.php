<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\User;
use App\MainProject;
use App\Comments;
use App\Logo;
use App\BannerSizes;
use App\BannerProject;

class BannerController extends Controller
{
    public function index()
    {
        $banner_list = MainProject::where('project_type', 0)->orderBy('created_at', 'DESC')->get();
        return view('view_banner.banner', compact('banner_list'));
    }

    public function banner_add()
    {
        $logo_list = Logo::get();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner_add', compact('logo_list', 'size_list'));
    }

    public function banner_add_post(Request $request)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:zip'
        ]);

        $pro_name = $request->project_name;
        $project_name = str_replace(" ","_", $request->project_name);
        
        $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
        $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

        $file_name = $sub_project_name.'_'.time().'.'.$request->upload->extension();
        $request->upload->move(public_path('banner_collection'), $file_name);
        $file_bytes = filesize(public_path('/banner_collection/'.$file_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $file_bytes >= 1024 && $i < ( count( $label ) -1 ); $file_bytes /= 1024, $i++ );
        $file_size = round( $file_bytes, 2 ) . " " . $label[$i];

        $main_project = new MainProject;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $request->color;
        $main_project->is_logo = 1;
        $main_project->is_footer = 1;
        $main_project->project_type = 0;
        $main_project->save();

        $sub_project = new BannerProject;
        $sub_project->name = $sub_project_name;
        $sub_project->project_id = $main_project->id;
        $sub_project->size_id = $request->banner_size_id;
        $sub_project->size = $file_size;
        $sub_project->file_path = $file_name;
        $sub_project->save();

        $zip = new ZipArchive();
        $file_path = str_replace(".zip","", $sub_project->file_path);
        $directory = 'banner_collection/'.$file_path;
        if(!is_dir($directory))
        {
            if ($zip->open('banner_collection/'.$sub_project->file_path) === TRUE) 
            { 
                // Unzip Path 
                $zip->extractTo($directory); 
                $zip->close(); 
            } 
        }
        return redirect('/project/banner/view/'.$main_project->id);
    }

    public function sizes()
    {
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner_sizes', compact('size_list'));
    }

    public function size_add()
    {
        return view('view_banner.banner_add_size');
    }

    public function size_add_post(Request $request)
    {
        $size = New BannerSizes;
        $size->width = $request->width;
        $size->height = $request->height;
        $size->save();

        return redirect('/banner_sizes')->with('success', $request->width.'x'.$request->height.' Added Successfully!');
    }

    public function project_addon($id)
    {
        $main_project_id = $id;
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_banner.banner_addon', compact('size_list', 'main_project_id'));
    }

    public function project_addon_post(Request $request, $id)
    {
        $main_project_id = $id;
        $project_info = MainProject::where('id', $main_project_id)->first();
        $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
        $sub_project_name = $project_info['name'].'_'.$size_info['width'].'x'.$size_info['height'];

        $file_name = $sub_project_name.'_'.time().'.'.$request->upload->extension();
        $request->upload->move(public_path('banner_collection'), $file_name);
        $file_bytes = filesize(public_path('/banner_collection/'.$file_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $file_bytes >= 1024 && $i < ( count( $label ) -1 ); $file_bytes /= 1024, $i++ );
        $file_size = round( $file_bytes, 2 ) . " " . $label[$i];

        $sub_project = new BannerProject;
        $sub_project->name = $sub_project_name;
        $sub_project->project_id = $main_project_id;
        $sub_project->size_id = $request->banner_size_id;
        $sub_project->size = $file_size;
        $sub_project->file_path = $file_name;
        $sub_project->save();

        $zip = new ZipArchive();
        $file_path = str_replace(".zip","", $sub_project->file_path);
        $directory = 'banner_collection/'.$file_path;
        if(!is_dir($directory))
        {
            if ($zip->open('banner_collection/'.$sub_project->file_path) === TRUE) 
            { 
                // Unzip Path 
                $zip->extractTo($directory); 
                $zip->close(); 
            } 
        }

        return redirect('/project/banner/view/'.$main_project_id);
    }

    public function banner_delete_all($id)
    {
        $main_project_info = MainProject::where('id', $id)->first();

        $sub_project_info = BannerProject::where('project_id', $id)->get();
        if(($sub_project_info->count() != 0))
        {
            foreach($sub_project_info as $sub_project)
            {
                $file_path = public_path() . '/banner_collection/'.str_replace(".zip","", $sub_project['file_path']);
                unlink('banner_collection/'.$sub_project['file_path']);
                $files = File::deleteDirectory($file_path);

                BannerProject::where('id', $id)->delete();
            }
        }
        MainProject::where('id', $id)->delete();
        return redirect('/banner')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    public function banner_delete($id)
    {
        $sub_project = BannerProject::where('id', $id)->first();

        $file_path = public_path() . '/banner_collection/'.str_replace(".zip","", $sub_project['file_path']);
        unlink('banner_collection/'.$sub_project['file_path']);
        $files = File::deleteDirectory($file_path);

        BannerProject::where('id', $id)->delete();
        return back();
    }
}
