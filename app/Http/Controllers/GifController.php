<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Session;
use App\User;
use App\MainProject;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use App\Gif;
use App\Helper\Helper;

class GifController extends Controller
{
    public function index()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            if(Auth::user()->company_id == 1){
                $gifs = MainProject::where('project_type', 2)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            }
            else{
                $gifs = MainProject::where('project_type', 2)
                                    ->where('uploaded_by_company_id', Auth::user()->company_id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            }
            return view('view_gif.gif', compact('gifs'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function gif_add()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('view_gif.gif_add', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function gif_add_post(Request $request)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:gif'
        ]);

        if($request->banner_size_id != 0)
        {
            $pro_name = $request->project_name;
            $project_name = str_replace(" ", "_", $request->project_name);
    
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . '.' . $request->upload->extension();
            $request->upload->move(public_path('gif_collection'), $file_name);
            $file_bytes = filesize(public_path('/gif_collection/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];
    
            $main_project = new MainProject;
            $main_project->name = $pro_name;
            $main_project->client_name = $request->client_name;
            $main_project->logo_id = $request->logo_id;
            $main_project->color = $request->color;
            $main_project->is_logo = 1;
            $main_project->is_footer = 1;
            $main_project->project_type = 2;
            $main_project->uploaded_by_user_id = Auth::user()->id;
            $main_project->uploaded_by_company_id = Auth::user()->company_id;
            $main_project->save();
    
            $sub_project = new Gif;
            $sub_project->name = $sub_project_name;
            $sub_project->project_id = $main_project->id;
            $sub_project->size_id = $request->banner_size_id;
            $sub_project->size = $file_size;
            $sub_project->file_path = $file_name;
            $sub_project->save();
    
            return redirect('/project/gif/view/' . $main_project->id);
        }
        else
        {
            return back()->with('danger', 'Please Select Size!');
        }
        
    }

    public function project_addon($id)
    {
        $main_project_id = $id;
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_gif.gif_addon', compact('size_list', 'main_project_id'));
    }

    public function project_addon_post(Request $request, $id)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:gif'
        ]);

        if($request->banner_size_id != 0)
        {
            $main_project_id = $id;
            $project_info = MainProject::where('id', $main_project_id)->first();
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
            $file_name = $sub_project_name . '_' . time() . '.' . $request->upload->extension();
            $request->upload->move(public_path('gif_collection'), $file_name);
            $file_bytes = filesize(public_path('/gif_collection/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];
    
            $sub_project = new GIF;
            $sub_project->name = $sub_project_name;
            $sub_project->project_id = $main_project_id;
            $sub_project->size_id = $request->banner_size_id;
            $sub_project->size = $file_size;
            $sub_project->file_path = $file_name;
            $sub_project->save();
    
            return redirect('/project/gif/view/' . $main_project_id);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
        
    }

    public function gif_delete_all($id)
    {
        $main_project_info = MainProject::where('id', $id)->first();

        $sub_project_info = Gif::where('project_id', $id)->get();
        foreach($sub_project_info as $sub_project)
        {
            $file_path = public_path('gif_collection/').$sub_project->file_path;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
            Gif::where('id', $sub_project->id)->delete();
        }
        MainProject::where('id', $id)->delete();
        return redirect('/gif')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    public function gif_delete($id)
    {
        $sub_project_info = Gif::where('id', $id)->first();

        $file_path = public_path('gif_collection/').$sub_project_info['file_path'];
        if (file_exists($file_path)) {
            @unlink($file_path);
        }
        Gif::where('id', $id)->delete();

        return redirect('/project/gif/view/'.$sub_project_info['project_id']);
    }

    public function gif_edit($id)
    {
        $sub_project_id = $id;
        $sub_project_info = Gif::where('id', $id)->first();
        $size_list = BannerSizes::orderBy('width', 'ASC')->get();
        return view('view_gif.gif-edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    public function gif_edit_post(Request $request, $id)
    {
        $validator = $request->validate([
            'upload' => 'required|file|mimes:gif'
        ]);

        if($request->banner_size_id != 0)
        {
            $banner_id = $id;
            $banner_info = Gif::where('id', $banner_id)->first();
            unlink('gif_collection/' . $banner_info['file_path']);
    
            $project_info = MainProject::where('id', $banner_info['project_id'])->where('project_type', 2)->first();
            $size_info = BannerSizes::where('id', $request->banner_size_id)->first();
            $sub_project_name = $project_info['name'] . '_' . $size_info['width'] . 'x' . $size_info['height'];;
    
            $file_name = $sub_project_name . '_' . time() . '.' . $request->upload->extension();
            $request->upload->move(public_path('gif_collection'), $file_name);
            $file_bytes = filesize(public_path('/gif_collection/' . $file_name));
    
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $file_bytes >= 1024 && $i < (count($label) - 1); $file_bytes /= 1024, $i++) ;
            $file_size = round($file_bytes, 2) . " " . $label[$i];
    
            $sub_project_details = [
                'name' => $sub_project_name,
                'size_id' => $request->banner_size_id,
                'size' => $file_size,
                'file_path' => $file_name
            ];
    
            Gif::where('id', $banner_id)->update($sub_project_details);
    
            return redirect('/project/gif/view/' . $project_info['id']);
        }
        else
        {
            return back()->with('danger', 'Please Select Size First!');
        }
    }

    public function project_edit($id)
    {
        $project_name = MainProject::where('id', $id)->first();
        $naming_convention = str_replace(" ", "_", $project_name['name']);
        $logo_list = Logo::get();
        $size_list = BannerSizes::orderBy('width', 'DESC')->get();
        $project_info = MainProject::where('id', $id)->first();
        
        return view('view_gif.edit_project', compact('logo_list', 'size_list', 'project_info', 'id', 'naming_convention'));
    }

    public function project_edit_post(Request $request, $id)
    {
        $main_project_id = $id;
        $pro_name = $request->project_name;
        $old_project_details = MainProject::where('id', $id)->where('project_type', 2)->first();
        $project_name = str_replace(" ", "_", $request->project_name);
        $old_project_name = str_replace(" ", "_", $old_project_details['name']);

        $sub_projects = Gif::where('project_id', $main_project_id)->get();

        $main_project_details = [
            'name' => $pro_name,
            'client_name' => $request->client_name,
            'logo_id' => $request->logo_id,
            'color' => $request->color,
            'is_logo' => $request->is_logo,
            'is_footer' => $request->is_footer
        ];

        MainProject::where('id', $main_project_id)->update($main_project_details);

        if($old_project_name != $project_name)
        {
            foreach ($sub_projects as $sub_project) 
            {
                $size_info = BannerSizes::where('id', $sub_project['size_id'])->first();
    
                $old_sub_project_name = $sub_project->name;
                $old_file_path = $sub_project->file_path;
    
                $new_sub_project_name = $project_name . '_' . $size_info['width'] . 'x' . $size_info['height'];
    
                if ($old_file_path != NULL)
                {
                    //str_replace($search,$replace,$subject)
                    $new_file_path = str_replace($old_sub_project_name,$new_sub_project_name,$old_file_path);
                } 
                else 
                {
                    $new_file_path = NULL;
                }
    
                rename('gif_collection/' . $old_file_path, 'gif_collection/' . $new_file_path);
    
                $new_sub_details = [
                    'name' => $new_sub_project_name,
                    'file_path' => $new_file_path,
                ];
    
                Gif::where('id', $sub_project->id)->update($new_sub_details);
            }
        }
        return redirect('/gif')->with('success', $project_name . ' has been updated!');
    }
}
