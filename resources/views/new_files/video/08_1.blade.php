<?php $direct_name = "banner_videos/" ?>

@if (glob($direct_name.$project->video_path))
<div class="md:w-3/4 mx-8">
    <div class="videos">
        <div class="md:flex">
            <div class="md:w-2/4">
                <h2 class="text-xl font-semibold mb-4 px-2 py-2 video-title" style="background-color: {{$project_color}}; color: white; border-radius: 5px;">
                    {{ $project->title }}
                </h2>
            <div class="video-container aspect-ratio-08-1" style="aspect-ratio: 1/0.8"> 
                <video class="video" playsinline controls controlsList="nodownload" data-poster="poster.jpg" width="560" height="auto">
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
