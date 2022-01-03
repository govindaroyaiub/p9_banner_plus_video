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
use App\Gif;
use App\BannerProject;
use App\Helper\Helper;
use Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        $current_year = date("Y");
        if(url('/') == $verification['website'] || url('/') == 'http://p9_banner_plus_video.test')
        {
            if(url('/') != 'http://localhost:8000')
            {
                $company_id = Auth::user()->company_id;
                $user_list = User::select(
                                    'id', 
                                    'name as username', 
                                    'email', 
                                    'is_send_mail',
                                    'is_admin')
                                ->where('company_id', $company_id)
                                ->where('is_deleted', 0)
                                ->orderBy('name', 'ASC')
                                ->get();
            }
            else
            {
                $user_list = User::join('logo', 'logo.id', 'users.company_id')
                                ->select(
                                    'users.id',
                                    'users.name as username',
                                    'users.email',
                                    'users.is_send_mail',
                                    'users.is_admin',
                                    'logo.name as logoname'
                                    )
                                ->orderBy('users.name', 'ASC')
                                ->where('users.is_deleted', 0)
                                ->get();
            }
            // $total_comments = Comments::get()->count();

            $video_sizes = SubProject::join('main_project', 'main_project.id', 'sub_project.project_id')
                                    ->select('size')
                                    ->where('main_project.project_type', 1)
                                    ->where('main_project.uploaded_by_company_id', Auth::user()->company_id)
                                    ->whereYear('sub_project.created_at', $current_year)
                                    ->get();

            $banner_sizes = BannerProject::join('main_project', 'main_project.id', 'banner_projects.project_id')
                                    ->select('size')
                                    ->where('main_project.project_type', 0)
                                    ->where('main_project.uploaded_by_company_id', Auth::user()->company_id)
                                    ->whereYear('banner_projects.created_at', $current_year)
                                    ->get();

            $gif_sizes = Gif::join('main_project', 'main_project.id', 'gif_projects.project_id')
                                    ->select('size')
                                    ->where('main_project.project_type', 2)
                                    ->where('main_project.uploaded_by_company_id', Auth::user()->company_id)
                                    ->whereYear('gif_projects.created_at', $current_year)
                                    ->get();

            $total_banner_projects = MainProject::where('project_type', 0)
                                                ->where('uploaded_by_company_id', Auth::user()->company_id)
                                                ->whereYear('created_at', $current_year)
                                                ->count();

            $total_video_projects = MainProject::where('project_type', 1)
                                                ->where('uploaded_by_company_id', Auth::user()->company_id)
                                                ->whereYear('created_at', $current_year)
                                                ->count();

            $total_gif_projects = MainProject::where('project_type', 2)
                                                ->where('uploaded_by_company_id', Auth::user()->company_id)
                                                ->whereYear('created_at', $current_year)
                                                ->count();

            $total_videos = $video_sizes->count();
            $total_banners = $banner_sizes->count();
            $total_gifs = $gif_sizes->count();

            $total_size = array();
            $total_banner_size = array();

            $main_banner_ids = Helper::getMainBannerIds(Auth::user()->company_id);
            
            $jan = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '1')->whereYear('created_at', $current_year)->get()->count();
            $feb = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '2')->whereYear('created_at', $current_year)->get()->count();
            $mar = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '3')->whereYear('created_at', $current_year)->get()->count();
            $apr = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '4')->whereYear('created_at', $current_year)->get()->count();
            $may = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '5')->whereYear('created_at', $current_year)->get()->count();
            $jun = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '6')->whereYear('created_at', $current_year)->get()->count();
            $jul = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '7')->whereYear('created_at', $current_year)->get()->count();
            $aug = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '8')->whereYear('created_at', $current_year)->get()->count();
            $sep = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '9')->whereYear('created_at', $current_year)->get()->count();
            $oct = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '10')->whereYear('created_at', $current_year)->get()->count();
            $nov = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '11')->whereYear('created_at', $current_year)->get()->count();
            $dec = BannerProject::whereIn('project_id', $main_banner_ids)->whereMonth('created_at', '12')->whereYear('created_at', $current_year)->get()->count();

            try{
                return view('home', compact(
                    'user_list', 
                    'total_banners', 
                    'total_videos',
                    'total_gifs',
                    'total_gif_projects', 
                    'total_banner_projects', 
                    'total_video_projects', 
                    'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec' 
                ));
            }
            catch(Exception $e)
            {
                logger($e);
                return $e;
            }
            
        }
        else
        {
            try
            {
                Session::flush();
                Auth::logout();
                return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
            }
            catch(Exception $e)
            {
                logger($e);
                return $e;
            }
        }
    }

    public function project()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'] || url('/') == 'http://p9_banner_plus_video.test')
        {
            $project_list = MainProject::where('project_type', 1)->where('uploaded_by_company_id', Auth::user()->company_id)->orderBy('created_at', 'DESC')->get();
            return view('project', compact('project_list'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function project_add()
    {
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'] || url('/') == 'http://p9_banner_plus_video.test')
        {
            $logo_list = Logo::get();
            $size_list = Sizes::orderBy('width', 'DESC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('add_project', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function project_add_post(Request $request)
    {
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'required|mimes:mp4',
        ]);

        $pro_name = $request->project_name;
        $project_name = str_replace(" ","_", $request->project_name);

        $size_info = Sizes::where('id', $request->size_id)->first();
        $sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

        if($request->has('poster'))
        {
            $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
            $request->poster->move(public_path('poster_images'), $poster_name);
        }
        else
        {
            $poster_name = NULL;
        }

        $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
        $request->video->move(public_path('banner_videos'), $video_name);
        $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
        $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

        $main_project = new MainProject;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $request->color;
        $main_project->is_logo = 1;
        $main_project->is_footer = 1;
        $main_project->project_type = 1;
        $main_project->uploaded_by_user_id = Auth::user()->id;
        $main_project->uploaded_by_company_id = Auth::user()->company_id;
        $main_project->save();

        $sub_project = new SubProject;
        $sub_project->name = $sub_project_name;
        $sub_project->title = $request->title;
        $sub_project->project_id = $main_project->id;
        $sub_project->size_id = $request->size_id;
        $sub_project->codec = $request->codec;
        $sub_project->aspect_ratio = $request->aspect_ratio;
        $sub_project->fps = $request->fps;
        $sub_project->size = $video_size;
        $sub_project->poster_path = $poster_name;
        $sub_project->video_path = $video_name;
        $sub_project->save();

        return redirect('/project/video/view/'.$main_project->id);
    }

    public function project_edit($id)
    {
        $project_name = MainProject::where('id', $id)->first();
        $naming_convention = str_replace(" ", "_", $project_name['name']);
        $logo_list = Logo::get();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        $project_info = MainProject::where('id', $id)->first();
        return view('edit_project', compact('logo_list', 'size_list', 'project_info', 'id', 'naming_convention'));
    }

    public function project_edit_post(Request $request, $id)
    {
        $main_project_id = $id;
        $pro_name = $request->project_name;
        $project_name = str_replace(" ","_", $request->project_name);
        $sub_projects = SubProject::where('project_id', $main_project_id)->get();

        $main_project_details = [
            'name' => $pro_name,
            'client_name' => $request->client_name,
            'logo_id' => $request->logo_id,
            'color' => $request->color,
            'is_logo' => $request->is_logo,
            'is_footer' => $request->is_footer
        ];

        MainProject::where('id', $main_project_id)->update($main_project_details);

        foreach($sub_projects as $sub_project)
        {
            $size_info = Sizes::where('id', $sub_project['size_id'])->first();

            $old_sub_project_name = $sub_project->name;
            $old_poster_path = $sub_project->poster_path;
            $old_video_path = $sub_project->video_path;

            $new_sub_project_name = $project_name.'_'.$size_info['width'].'x'.$size_info['height'];

            if($old_poster_path != NULL)
            {
                //str_replace($search,$replace,$subject)
                $new_poster_path = str_replace($old_sub_project_name,$new_sub_project_name,$old_poster_path);
            }
            else
            {
                $new_poster_path = NULL;
            }
            //str_replace($search,$replace,$subject)
            $new_video_path = str_replace($old_sub_project_name,$new_sub_project_name,$old_video_path);

            rename('poster_images/'.$old_poster_path, 'poster_images/'.$new_poster_path);
            rename('banner_videos/'.$old_video_path, 'banner_videos/'.$new_video_path);

            $new_sub_details = [
                'name' => $new_sub_project_name,
                'poster_path' => $new_poster_path,
                'video_path' => $new_video_path
            ];

            SubProject::where('id', $sub_project->id)->update($new_sub_details);
        }
        return redirect('/video')->with('success', $project_name.' has been updated!');
    }

    public function project_addon($id)
    {
        $main_project_id = $id;
        $logo_list = Logo::get();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        return view('project_addon', compact('logo_list', 'size_list', 'main_project_id'));
    }

    public function project_addon_post(Request $request, $id)
    {
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'required|mimes:mp4',
        ]);

        $main_project_id = $id;
        $project_info = MainProject::where('id', $main_project_id)->first();
        $size_info = Sizes::where('id', $request->size_id)->first();
        $sub_project_name = $project_info['name'].'_'.$size_info['width'].'x'.$size_info['height'];

        if($request->has('poster'))
        {
            $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
            $request->poster->move(public_path('poster_images'), $poster_name);
        }
        else
        {
            $poster_name = NULL;
        }

        $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
        $request->video->move(public_path('banner_videos'), $video_name);
        $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
        $video_size = round( $video_bytes, 2 ) . " " . $label[$i];

        $sub_project = new SubProject;
        $sub_project->name = $sub_project_name;
        $sub_project->title = $request->title;
        $sub_project->project_id = $main_project_id;
        $sub_project->size_id = $request->size_id;
        $sub_project->codec = $request->codec;
        $sub_project->aspect_ratio = $request->aspect_ratio;
        $sub_project->fps = $request->fps;
        $sub_project->size = $video_size;
        $sub_project->poster_path = $poster_name;
        $sub_project->video_path = $video_name;
        $sub_project->save();

        return redirect('/project/video/view/'.$main_project_id);
    }

    public function video_edit($id)
    {
        $sub_project_id = $id;
        $sub_project_info = SubProject::where('id', $id)->first();
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        return view('video_edit', compact('sub_project_info', 'size_list', 'sub_project_id'));
    }

    public function video_edit_post(Request $request, $id)
    {
        $validator = $request->validate([
            'poster' => 'mimes:jpeg,png,jpg,gif',
            'video' => 'mimes:mp4',
        ]);

        $sub_project_id = $id;
        $sub_project_info = SubProject::where('id', $id)->first();
        $size_info = Sizes::where('id', $request->size_id)->first();
        $main_project_info = MainProject::where('id', $sub_project_info['project_id'])->first();
        $sub_project_name = $main_project_info['name'].'_'.$size_info['width'].'x'.$size_info['height'];


        if($request->poster != NULL && $request->video != NULL)
        {
            if($sub_project_info['poster_path'] == NULL)
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            else
            {
                $poster_path = public_path('poster_images/').$sub_project_info['poster_path'];
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
                //then add the new one
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            $video_path = public_path('banner_videos/').$sub_project_info['video_path'];
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('banner_videos'), $video_name);
            $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];
        }
        else if($request->poster == NULL && $request->video != NULL)
        {
            $poster_name = $sub_project_info['poster_path'];
            $video_path = public_path('banner_videos/').$sub_project_info['video_path'];
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            $video_name = $sub_project_name.'_'.time().'.'.$request->video->extension();
            $request->video->move(public_path('banner_videos'), $video_name);
            $video_bytes = filesize(public_path('/banner_videos/'.$video_name));

            $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for( $i = 0; $video_bytes >= 1024 && $i < ( count( $label ) -1 ); $video_bytes /= 1024, $i++ );
            $video_size = round( $video_bytes, 2 ) . " " . $label[$i];
        }
        else if($request->poster != NULL && $request->video == NULL)
        {
            $video_name = $sub_project_info['video_path'];
            $video_size = $sub_project_info['size'];
            if($sub_project_info['poster_path'] == NULL)
            {
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
            else
            {
                $poster_path = public_path('poster_images/').$sub_project_info['poster_path'];
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
                //then add the new one
                $poster_name = $sub_project_name.'_'.time().'.'.$request->poster->extension();
                $request->poster->move(public_path('poster_images'), $poster_name);
            }
        }
        else
        {
            $poster_name = $sub_project_info['poster_path'];
            $video_name = $sub_project_info['video_path'];
            $video_size = $sub_project_info['size'];
        }

        $sub_project_details = [
            'name' => $sub_project_name,
            'title' => $request->title,
            'codec' => $request->codec,
            'size_id' => $request->size_id,
            'aspect_ratio' => $request->aspect_ratio,
            'fps' => $request->fps,
            'size' => $video_size,
            'poster_path' => $poster_name,
            'video_path' => $video_name
        ];

        SubProject::where('id', $sub_project_id)->update($sub_project_details);
        return redirect('/project/video/view/'.$main_project_info['id']);

    }

    public function video_delete($id)
    {
        $sub_project_info = SubProject::where('id', $id)->first();

        if($sub_project_info['poster_path'] != NULL)
        {
            $poster_path = public_path('poster_images/').$sub_project_info['poster_path'];
            if (file_exists($poster_path)) {
                @unlink($poster_path);
            }
        }

        $video_path = public_path('banner_videos/').$sub_project_info['video_path'];
        if (file_exists($video_path)) {
            @unlink($video_path);
        }
        SubProject::where('id', $id)->delete();

        return redirect('/project/video/view/'.$sub_project_info['project_id']);
    }

    public function project_delete($id)
    {
        $main_project_info = MainProject::where('id', $id)->first();

        $sub_project_info = SubProject::where('project_id', $id)->get();
        foreach($sub_project_info as $sub_project)
        {
            if($sub_project->poster_path != NULL)
            {
                $poster_path = public_path('poster_images/').$sub_project->poster_path;
                if (file_exists($poster_path)) {
                    @unlink($poster_path);
                }
            }
            $video_path = public_path('banner_videos/').$sub_project->video_path;
            if (file_exists($video_path)) {
                @unlink($video_path);
            }
            SubProject::where('id', $sub_project->id)->delete();
        }
        MainProject::where('id', $id)->delete();
        return redirect('/video')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    public function client()
    {
        if(Auth::user()->company_id == 1)
        {
            $logo_list = Logo::get();
            return view('client_list', compact('logo_list'));
        }
        else
        {
            return view('404');
        }
    }

    public function client_add()
    {
        if(Auth::user()->company_id == 1)
        {
            return view('add_logo');
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    public function logo_add_post(Request $request)
    {
        $request->validate([
            'logo_file' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);

        $imageName = $request->company_name.'_'.time().'.'.$request->logo_file->extension();
        $request->logo_file->move(public_path('logo_images'), $imageName);

        $logo = new Logo;
        $logo->name = $request->company_name;
        $logo->favicon = $request->favicon;
        $logo->default_color = $request->default_color;
        $logo->website = $request->website;
        $logo->company_website = $request->company_website;
        $logo->path = $imageName;
        $logo->save();

        return redirect('/logo')->with('success', 'Logo for '.$request->company_name.' has been uploaded!');
    }

    public function logo_edit($id)
    {
        $logo = Logo::where('id', $id)->first();

        return view('edit_logo', compact('logo', 'id'));
    }

    public function logo_edit_post(Request $request, $id)
    {
        $logo = Logo::where('id', $id)->first();

        if($request->logo_file != NULL)
        {
            $request->validate([
                'logo_file' => 'required|image|mimes:jpeg,png,jpg,svg',
            ]);

            //first delete previous logo
            $image_path = public_path('logo_images/').$logo['path'];
            if (file_exists($image_path)) 
            {
                @unlink($image_path);
            }

            //then insert the new one
            $imageName = $request->company_name.'_'.time().'.'.$request->logo_file->extension();
            $request->logo_file->move(public_path('logo_images'), $imageName);
        }
        else
        {
            $imageName = $logo['path'];
        }

        $details = [
            'name' => $request->company_name,
            'website' => $request->website,
            'company_website' => $request->company_website,
            'favicon' => $request->favicon,
            'default_color' => $request->default_color,
            'path' => $imageName
        ];

        Logo::where('id', $id)->update($details);

        return redirect('/logo')->with('success', $request->company_name.' has been updated!');
    }

    public function logo_delete($id)
    {
        $logo_info = Logo::where('id', $id)->first();
        Logo::where('id', $id)->delete();

        $image_path = public_path('logo_images/').$logo_info['path'];
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
        return redirect('/logo')->with('danger', $logo_info['name'].' logo has been deleted!');
    }

    public function sizes()
    {
        $size_list = Sizes::orderBy('width', 'DESC')->get();
        return view('sizes', compact('size_list'));
    }

    public function size_add()
    {
        return view('add_size');
    }

    public function size_add_post(Request $request)
    {
        $size = New Sizes;
        $size->name = $request->size_name;
        $size->width = $request->width;
        $size->height = $request->height;
        $size->save();

        return redirect('/sizes')->with('success', 'Size Added Successfully!');
    }

    public function size_delete($id)
    {
        $size_info = Sizes::where('id', $id)->first();
        Sizes::where('id', $id)->delete();
        return redirect('/sizes')->with('danger', $size_info['name'].' ('.$size_info['width'].'X'.$size_info['height'].')'.' has been deleted!');
    }

    public function add_user()
    { 
        if(Auth::user()->is_admin == 1)
        {
            $client_list = Logo::orderBy('name', 'ASC')->get();
            return view('add_user', compact('client_list'));
        }
        else
        {
            return redirect('/')->with('danger', 'Sorry You do not have Admin Privileges!');
        }
    }

    public function add_user_post(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->company_id = $request->company_id;
        $user->password = Hash::make('2bEmwRx');
        $user->save();

        return redirect('/home')->with('create-user', 'User: '.$request->name.' '.'Email: '.$request->email.' '.'Password: 2bEmwRx, has been created!');
    }

    public function change_password()
    {
        return view('change_password');
    }

    public function change_password_post(Request $request)
    {
        $user_id = Auth::user()->id;

        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $repeat_password = $request->repeat_password;

        if (Hash::check($current_password, Auth::user()->password))
        {
            if($new_password == $repeat_password)
            {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($new_password)]);
                Auth::logout();
                return redirect('/login')->with('info-password', 'Password has been changed. Please login again. Thank you!');
            }
            else
            {
                return back()->with('danger', 'New Password and Repeat Password do not match! You high?');
            }
        }
        else
        {
            return back()->with('info', 'Current Password is not matched! Are you high?');
        }
    }

    public function reset_password($id)
    {
        User::where('id', $id)->update(['password' => Hash::make('2bEmwRx')]);
        return redirect('/user/edit/'.$id)->with('info-password', 'Password has been reset. New password: 2bEmwRx');
    }

    public function edit_user($id)
    {
        $user_info = User::where('id', $id)->first();
        $client_list = Logo::orderBy('name', 'ASC')->get();
        return view('user_edit', compact('user_info', 'id', 'client_list'));
    }

    public function edit_user_post(Request $request, $id)
    {
        $user_info = [
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'is_admin' => $request->is_admin
        ];
        User::where('id', $id)->update($user_info);
        return back()->with('user-update-success', 'User updated!');
    }

    public function delete_user($id)
    {
        User::where('id', $id)->update(['is_deleted' => 1]);
        return redirect('/')->with('delete-user', 'User has been deleted');
    }

    public function change_mail_status(Request $request)
    {
        User::where('id', $request->id)->update(['is_send_mail' => $request->status]);
        if($request->status == 1)
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }
}
