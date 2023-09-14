<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Helper\Helper;
use App\User;
use App\newPreview;
use App\newPreviewType;
use App\newFeedback;
use App\newVersion;
use App\Sizes;
use App\Logo;
use App\BannerSizes;

class PreviewController extends Controller
{
    function viewPreviews(){

        $data = newPreview::orderBy('created_at', 'ASC')->get();
        return view('newpreview.previews', compact('data'));
    }

    function addPreviewsView(){
        $verification = Logo::where('id', Auth::user()->company_id)->first();
        if(url('/') == $verification['website'])
        {
            $logo_list = Logo::get();
            $size_list = BannerSizes::orderBy('width', 'ASC')->orderBy('height', 'ASC')->get();
            $company_details = Logo::where('id', Auth::user()->company_id)->first();
            $color = $company_details['default_color'];
            return view('newpreview.addpreviews', compact('logo_list', 'size_list', 'color'));
        }
        else
        {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('danger', 'Spy Detected! Please Go To Your Login Page.');
        }
    }

    function addPreviewsPost(Request $request){
        dd($request->all());
    }
}
