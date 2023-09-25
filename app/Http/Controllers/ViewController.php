<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Comments;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use App\Helper\Helper;
use Carbon\Carbon;
use App\newPreview;
use App\newPreviewType;
use App\newFeedback;
use App\newVersion;
use App\newBanner;


class ViewController extends Controller
{
    function view($id){
        $main_project_id = $id;
        $info = newPreview::join('logo', 'new_previews_table.logo_id', 'logo.id')
                                        ->select(
                                            'new_previews_table.name as name',
                                            'new_previews_table.client_name',
                                            'new_previews_table.logo_id',
                                            'new_previews_table.color',
                                            'new_previews_table.is_logo',
                                            'new_previews_table.is_footer',
                                            'new_previews_table.is_version',
                                            'new_previews_table.uploaded_by_company_id',
                                            'new_previews_table.uploaded_by_user_id',
                                            'logo.name as logo_name',
                                            'logo.website',
                                            'logo.path' 
                                        )
                                        ->where('new_previews_table.id', $main_project_id)
                                        ->first();

        return view('newpreview.index', compact(
            'info',
            'main_project_id'
        ));
    }
}
