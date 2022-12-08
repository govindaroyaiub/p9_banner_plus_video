<main class="main">
    <div x-show="show" class="px-10 py-6" id="show1">
        <div class="container mx-auto px-4 py-4">
            <div class="banners" style="text-align: center;">
                @foreach($data as $banner)
                <?php
                    $directory = 'showcase_collection/'.$banner->file_path;
                    $resolution = explode("x", Helper::getBannerSizeinfo($banner->id));
                    $bannerSize = Helper::getBannerFileSize($banner->id);
                    $width = $resolution[0];
                    $height = $resolution[1];
                ?>
                <div class="single-div">
                    <small style="float: left;">{{ $width }}x{{ $height }}</small>
                    <small class="mx-auto text-red-700 size_text">{{ $bannerSize }}</small>
                    <br>
                    <iframe src="{{ asset($directory.'/index.html') }}" width="{{ $width }}"
                        height="{{ $height }}" frameBorder="0" scrolling="no" id="rel{{ $banner->id }}"></iframe>
                    <ul class="flex space-x-2 icons" style="color:{{ $main_project_info['color'] }};">
                        <li><i id="relBt{{ $banner->id }}"
                                class="color-primary underline flex mt-2">
                                <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </i></li>
                            @if(Auth::check())
                            @if(Auth::user()->company_id == 7)

                            @else
                            <li>
                                <a href="/showcase/download/{{$banner->id}}"
                                class="color-primary underline flex mt-2">
                                    <svg class="w-5 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="/showcase/edit/{{ $banner->id }}" class="color-primary flex mt-2">
                                    <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="/showcase/delete/{{ $banner->id }}" class="color-primary flex mt-2" onclick="return confirm('Are you sure you want to delete this banner?');">
                                    <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </li>
                            @endif
                        @endif
                    </ul>
                </div>
                <script>
                    function reload() {
                        document.getElementById("rel{{ $banner->id }}").src += '';
                    }
                    var relBtn = document.getElementById("relBt{{ $banner->id }}");
                    relBtn.onclick = reload;
                </script>
                @endforeach
            </div>
        </div>
    </div>
</main>