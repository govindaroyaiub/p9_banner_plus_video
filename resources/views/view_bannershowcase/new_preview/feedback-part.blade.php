<main class="main">
    <?php $i=1; ?>
    @foreach ($data as $id => $row)
    <div class="container mx-auto px-4 py-3">
        <div @if(Helper::getFeedbackStatus($id) == 1) x-data={show:true} @else x-data={show:false} @endif class="rounded-sm">
            <div class="px-10 py-2 cursor-pointer" @click="show=!show" style="background: {{ $project_color }}">
                <div class="center" style="width: auto; text-align: center;">
                    {{-- <span class="feedback-text text-white">{{$i++}}. {{ Helper::getFeedbackName($id) }} - {{ \Carbon\Carbon::parse(Helper::getFeedbackDate($id))->format('d F Y H:s:i') }}</span> --}}
                    <span class="feedback-text text-white">{{$i++}}. {{ Helper::getFeedbackName($id) }}</span>
                </div>
            </div>
            <div x-show="show" class="border border-b-0 px-1 py-1" style="border-color: {{ $project_color }}">
                <div style="z-index: 999; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between;">
                    
                    <div class="float-left">
                        @if(Helper::getFeedbackList($id) != NULL)
                        <div style="position: absolute; display: block; opacity: 1; width: 350px; height auto; z-index: 999999; background-color: rgb(255, 247, 209); border-radius: 8px;">
                            <div class="upperPart text-red-500" style="position: absolute; width: 100%; height: auto; padding: 2px 2px 2px 2px; background-color: rgb(255, 242, 171);">
                                <div class="cursor-pointer" style="float: right;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>  
                                </div>
                            </div>
                            <br>
                            <div class="lowerPart px-2 py-2 feedbackListArea" style="word-wrap: break-word; white-space: pre-line;">
                                {{ Helper::getFeedbackList($id) }}
                            </div>
                        </div>
                        <div class="cursor-pointer flex underline px-2 py-2" id="viewFeedbackList{{$id}}" style="color: #256D85">
                            View Changes
                        </div>
                        @endif
                    </div>

                    @if(Auth::check())
                        @if(Auth::user()->company_id == 7)
                        
                        @else
                        <div class="flex float-right">
                            <a href="/banner/add/feedback/{{$main_project_id}}/{{$id}}" class="text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <a href="/banner/edit/feedback/{{$main_project_id}}/{{$id}}" class="text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="/banner/delete/feedback/{{$main_project_id}}/{{$id}}" class="text-red-600" onclick="return confirm('Slow down HOTSHOT! You sure you want to delete this feedback?!');">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
                
                <div class="container mx-auto px-4 py-2">
                    <div class="banners" style="text-align: center;">
                        @foreach($row as $index => $banner)
                            @if(Helper::getFeedbackCategoryCount($id) > 1) 
                                <div class="py-2 text-white rounded-md feedbacks" style="margin-left: 7px; font-size: 18px; background-color: {{ $project_color }}; padding-left: 10px; margin-bottom: 20px; margin-top: 10px;">
                                    <label>{{ Helper::getCategoryName($index) }}</label>
                                    <div class="float-right mx-4 flex" style="margin-top: 2px; z-index: 99;">
                                        <a href="/banner/categories/{{$id}}/edit/{{$index}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a href="/banner/categories/{{$id}}/delete/{{$index}}" onclick="return confirm('Are you sure you want to delete this category?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @foreach ($banner as $banner)
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
                                    height="{{ $height }}" frameBorder="0" scrolling="no" id="rel{{ $banner->id }}" class="rels{{$id}}"></iframe>
                                <ul class="flex space-x-2 icons" style="color:{{ $project_color }};">
                                    <li>
                                        <i id="relBt{{ $banner->id }}"
                                            class="color-primary underline flex mt-2">
                                            <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </i>
                                    </li>
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
                        @endforeach
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js" integrity="sha512-VEBjfxWUOyzl0bAwh4gdLEaQyDYPvLrZql3pw1ifgb6fhEvZl9iDDehwHZ+dsMzA0Jfww8Xt7COSZuJ/slxc4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        </div>
    </div>
    @endforeach
</main>