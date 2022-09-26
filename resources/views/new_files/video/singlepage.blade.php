@foreach($data as $project)
<?php
    $resolution = explode("x", Helper::getVideoResolution($project->size_id));
    $aspect_ratio = explode(":", Helper::getVideoAspectRatio($project->id));
    $width = $resolution[0];
    $height = $resolution[1];
    $arW = $aspect_ratio[0];
    $arH = $aspect_ratio[1];
    $direct_name = "banner_videos/";
?>
@if($arW == 16 && $arH == 9)
    <style>
        .aspect_ratio{
            padding-top: 56.25%;
        }
    </style>
@elseif($arw == 1 && $arH == 1)
<style>
    .aspect_ratio{
        padding-top: 100%;
    }
</style>
@else
<style>
    .aspect_ratio{
        aspect-ratio: $arH / $arW;
    }
</style>
@endif
        <div class="container mx-auto px-4 py-10">
            <div class="md:flex -mx-8 mb-10">
                @if (glob($direct_name.$project->video_path))
                <div class="md:w-3/4 mx-8">
                    <div class="videos">
                        <h2 class="text-xl font-semibold mb-4">
                            {{ $project->title }}
                        </h2>
                        <div class="video-container aspect_ratio">
                            <video class="video" playsinline controls data-poster="poster.jpg" width="560" height="auto">
                                <source src="{{ asset('/banner_videos/'.$project->video_path) }}"
                                        type="video/mp4"/>
                            </video>
                        </div>

                        <ul class="flex space-x-4 icons" style="color: {{ $main_project_info['color'] }};">
                            <li><a href="{{ asset('/banner_videos/'.$project->video_path) }}"
                                    class="color-primary underline flex mt-4" download>Download
                                    <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a></li>


                            @if(Auth::user())
                                <li><a href="/video-showcase/edit/{{ $project->id }}"
                                        class="color-primary underline flex mt-4">Edit
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a></li>
                                <li><a href="/video-showcase/delete/{{ $project->id }}"
                                        class="color-primary underline flex mt-4" onclick="return confirm('Are you sure you want to delete this video?');">Delete
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                @else
                <div class="md:w-3/4 mx-8">
                    <div class="videos">
                        <h2 class="text-xl font-semibold mb-4" style="color: red;">
                            Video not found!
                        </h2>
                    </div>
                </div>
                @endif
                <div class="md:w-1/4 mx-8">
                    <h2 class="text-xl font-semibold mb-8" style="text-decoration: underline;">Specifications:</h2>
                    <table class="table w-full">
                        <tbody>
                        <tr>
                            <td>Aspect Ratio:</td>
                            <td>{{ $project->aspect_ratio }}</td>
                        </tr>
                        <tr>
                            <td>Resolution (WxH):</td>
                            <td>{{ $project->width }}x{{ $project->height }}</td>
                        </tr>
                        <tr>
                            <td>Codec:</td>
                            <td>{{ $project->codec }}</td>
                        </tr>
                        <tr>
                            <td>Framerate:</td>
                            <td>{{ $project->fps }}</td>
                        </tr>
                        <tr>
                            <td>Size:</td>
                            <td>{{ $project->size }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <?php $direct_name = "poster_images/" ?>
                        
                    @if($project->poster_path != NULL)
                        @if(glob($direct_name.$project->poster_path))
                        <div class="mt-4">
                            <div class="companion-banner">
                                <h2 class="text-xl font-semibold mb-4">Companion Banner</h2>

                                <img class="block companion-img"
                                    src="{{ asset('/poster_images/'.$project->poster_path) }}"
                                    alt="companion banner">

                                <div class="flex items-center space-x-4 mt-2">
                                    @if(mime_content_type(public_path('/poster_images/'.$project->poster_path)) == "image/gif")
                                    <a href="#"
                                    class="flex"
                                    onclick="document.querySelector('.companion-img').src='{{ asset('/poster_images/'.'/'.$project->poster_path) }}'; return false;">
                                        <span class="underline">Reload</span>
                                        &nbsp;
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </a>
                                    @endif
                                    <a href="{{ asset('/poster_images/'.'/'.$project->poster_path) }}"
                                    class="color-primary underline flex"
                                    download>
                                        <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="mt-4">
                            <div class="companion-banner">
                                <h2 class="text-xl font-semibold mb-4" style="color: red;">Companion Banner not found!</h2>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach