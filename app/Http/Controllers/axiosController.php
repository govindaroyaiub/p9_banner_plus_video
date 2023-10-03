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
    // function getProjectType(Request $request, $id){
    //     $data = newPreviewType::where('project_id', $id)->first();
    //     $feedback = newFeedback::where('project_id', $id)->first();
    //     $version = newVersion::where('feedback_id', $feedback['id'])->first();
    //     return $data = [
    //         'project_type' => $data['project_type'],
    //         'feedback_id' => $feedback['id'],
    //         'version_id' => $version['id']
    //     ];
    // }

    function getFeedbackType($id){
        $feedback = newFeedback::find($id);
        $versions = newVersion::where('feedback_id', $id)->get();
        $activeVersion = newVersion::where('feedback_id', $id)->where('is_active', 1)->first();

        return $data = [
            'project_type' => $feedback['project_type'],
            'versions' => $versions,
            'feedback_name' => $feedback['name'].' '.Carbon::parse($feedback['created_at'])->format('d.m.Y'),
            'activeVersion_id' => $activeVersion['id']
        ];
    }

    function getActiveVwersionBannerData(Request $request, $id){
        $banners = newBanner::join('banner_sizes', 'banner_sizes.id', 'new_banners_table.size_id')
                            ->select(
                                'new_banners_table.id', 
                                'banner_sizes.width', 
                                'banner_sizes.height', 
                                'new_banners_table.size',
                                'new_banners_table.file_path',
                                'new_banners_table.version_id')
                            ->where('new_banners_table.version_id', $id)
                            ->get();
        return $banners;
    }

    function deleteBanner(Request $request, $id){
        $banner = newBanner::where('id', $id)->first();
        $version = $banner['version_id'];
        $file_path = public_path() . '/new_showcase_collection/' . $banner['file_path'];
        if(file_exists($file_path)){
            // unlink('banner_collection/' . $sub_project['file_path']);
            $files = File::deleteDirectory($file_path);    
        }
        newBanner::where('id', $id)->delete();
        
        return $data = [
            'version_id' => $version
        ];
    }

    function getVersionsFromFeedback(Request $request, $id){
        $versions = newVersion::where('feedback_id', $id)->get();
        $versionCount = $versions->count();
        $isActiveVersion = newVersion::where('feedback_id', $id)->where('is_active', 1)->first();
        return $data = [
            'versions' => $versions,
            'versionCount' => $versionCount,
            'isActiveVersion' => $isActiveVersion
        ];
    }

    function setBannerActiveVersion(Request $request, $id){
        $version = newVersion::find($id);
        $feedback = newFeedback::where('id', $version['feedback_id'])->first();
        newVersion::where('id', $id)->update(['is_active' => 1]);
        $exceptionVersions = newVersion::select('id')->where('id', '!=', $id)->where('feedback_id', $feedback['id'])->get()->toArray();
        newVersion::whereIn('id', $exceptionVersions)->update(['is_active' => 0]);
        $versions = newVersion::where('feedback_id', $feedback['id'])->get();

        return $data = [
            'versions' => $versions,
            'activeVersion_id' => $id
        ];
    }

    function deleteBannerVersion($id){
        $banners = newBanner::where('version_id', $id)->get();
        $version = newVersion::find($id);
        $feedback_id = $version['feedback_id'];

        foreach ($banners as $banner) {
            $file_path = public_path() . '/new_showcase_collection/' . $banner['file_path'];
            if(file_exists($file_path)){
                // unlink('banner_collection/' . $sub_project['file_path']);
                $files = File::deleteDirectory($file_path);
            }
            newBanner::where('id', $banner->id)->delete();
        }

        newVersion::where('id', $id)->delete();
        
        $lastVersion = newVersion::where('feedback_id', $feedback_id)->orderBy('id', 'DESC')->first();
        newVersion::where('id', $lastVersion['id'])->update(['is_active' => 1]);

        return $data = [
            'feedback_id' => $feedback_id
        ];
    }

    function getActiveFeedbackProjectType($id){
        $feedback = newFeedback::find($id);
        $projectType = newPreviewType::where('id', $feedback['type_id'])->first();
        $versions = newVersion::where('feedback_id', $feedback['id'])->get();
        $activeVersion = newVersion::where('feedback_id', $feedback['id'])->where('is_active', 1)->first();

        return $data = [
            'feedback_name' => $feedback['name'].' '.Carbon::parse($feedback['created_at'])->format('d.m.Y'),
            'project_type' => $projectType['project_type'],
            'versions' => $versions,
            'active_version' => $activeVersion['id']
        ];
    }

    function getAllFeedbacks($project_id){
        $feedbacks = newFeedback::where('project_id', $project_id)->get();
        $activeFeedback = newFeedback::where('project_id', $project_id)->where('is_active', 1)->first();
        return $data = [
            'feedbacks' => $feedbacks,
            'activeFeedback_id' => $activeFeedback['id']
        ];
    }

    function updateActiveFeedback($id){
        $feedback = newFeedback::find($id);
        newFeedback::where('id', $id)->update(['is_active' => 1]);
        $exceptionFeedbacks = newFeedback::select('id')->where('id', '!=', $id)->get()->toArray();
        newFeedback::whereIn('id', $exceptionFeedbacks)->update(['is_active' => 0]);

        $feedbacks = newFeedback::where('project_id', $feedback['project_id'])->get();

        return $data = [
            'feedbacks' => $feedbacks,
            'activeFeedback_id' => $id
        ];
    }

    function feedbackDelete($id){
        $feedback = newFeedback::find($id);
        $project_id = $feedback['project_id'];

        if($feedback['project_type'] == 1){
            $versions = newVersion::where('feedback_id', $id)->get();

            foreach($versions as $version){
                $banners = newBanner::where('version_id', $version['id'])->get();
                foreach ($banners as $banner) {
                    $file_path = public_path() . '/new_showcase_collection/' . $banner['file_path'];
                    if(file_exists($file_path)){
                        // unlink('banner_collection/' . $sub_project['file_path']);
                        $files = File::deleteDirectory($file_path);
                    }
                    newBanner::where('id', $banner->id)->delete();
                }
            }
        }
        else if($feedback['project_type'] == 2){

        }
        else if($feedback['project_type'] == 3){

        }
        else{

        }

        newVersion::where('feedback_id', $id)->delete();
        newFeedback::where('id', $id)->delete();

        $lastFeedback = newFeedback::where('project_id', $project_id)->orderBy('id', 'DESC')->first();
        newFeedback::where('id', $lastFeedback['id'])->update(['is_active' => 1]);
        $feedbackCount = newFeedback::where('project_id', $project_id)->count();
        if($feedbackCount == 1){
            newPreview::where('id', $project_id)->update(['is_version' => '0']);
        }
    }
}
