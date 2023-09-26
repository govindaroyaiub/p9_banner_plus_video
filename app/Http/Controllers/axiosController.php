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
use App\newBanner;
use App\Sizes;
use App\Logo;
use App\BannerSizes;
use Carbon\Carbon;

class axiosController extends Controller
{
    function getProjectType(Request $request, $id){
        $data = newPreviewType::where('project_id', $id)->first();
        return $data['project_type'];
    }

    function getNewFeedbackName(Request $request, $id){
        $feedback = newFeedback::where('project_id', $id)->first();
        return $feedback['description'].' '.Carbon::parse($feedback['created_at'])->format('d.m.Y');
    }

    function getNewBannersData(Request $request, $id){
        $feedback = newFeedback::where('project_id', $id)->first();
        $version = newVersion::where('feedback_id', $feedback['id'])->first();
        $banners = newBanner::join('banner_sizes', 'banner_sizes.id', 'new_banners_table.size_id')
                            ->select(
                                'new_banners_table.id', 
                                'banner_sizes.width', 
                                'banner_sizes.height', 
                                'new_banners_table.size',
                                'new_banners_table.file_path',
                                'new_banners_table.version_id')
                            ->get();
        return $banners;
    }
}
