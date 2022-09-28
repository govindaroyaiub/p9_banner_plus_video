@foreach($data as $project)
<?php
    $resolution = explode("x", Helper::getVideoResolution($project->size_id));
    $aspect_ratio = explode(":", Helper::getVideoAspectRatio($project->id));
    $width = $resolution[0];
    $height = $resolution[1];
    $arW = $aspect_ratio[0];
    $arH = $aspect_ratio[1];
?>
    <div class="container mx-auto px-4 py-10">
        <div class="md:flex -mx-8 mb-10">
            @if(($width == 1920 && $height == 1080) || ($width == 3840 && $height == 2160))
                @include('new_files.video.16_9')
            @elseif($width == 1080 && $height == 1080)
                @include('new_files.video.1_1')
            @elseif(($width == 1080 && $height == 1920) || ($width == 2160 && $height == 3840) || ($width == 720 && $height == 1280))
                @include('new_files.video.056_1')
            @elseif($width == 1080 && $height == 1350)
                @include('new_files.video.08_1')
            @elseif($width == 328 && $height == 574)
                @include('new_files.video.057_1')
            @elseif($width == 1080 && $height == 1536)
                @include('new_files.video.07_1')
            @endif
            <div class="md:w-1/4 mx-8">
                <h2 class="text-xl font-semibold" style="text-decoration: underline;">Specifications:</h2>
                <table class="table w-full">
                    <tbody>
                    <tr>
                        <td>Aspect Ratio:</td>
                        <td>{{ $project->aspect_ratio }}</td>
                    </tr>
                    <tr>
                        <td>Resolution (WxH):</td>
                        <td>{{ $width }}x{{ $height }}</td>
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
                                download>Download Banner
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