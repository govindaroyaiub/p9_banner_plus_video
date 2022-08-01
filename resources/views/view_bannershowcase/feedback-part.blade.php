<main class="main">
    <?php $i=1; ?>
    @foreach ($data as $id => $row)
    <div class="container mx-auto px-4 py-3">
        <div @if(Helper::getFeedbackStatus($id) == 1) x-data={show:true} @else x-data={show:false} @endif class="rounded-sm">
            <div class="px-10 py-6 cursor-pointer all-versions" id="version{{$id}}" @click="show=!show" style="background-color: {{ $main_project_info['color'] }}">
                <label class="text-white">{{$i++}}. </label>
                <label class="underline text-white">
                    {{ Helper::getFeedbackName($id) }}
                </label> - 
                <label class="text-white">
                    {{ \Carbon\Carbon::parse(Helper::getFeedbackDate($id))->format('d F Y H:s:i') }}
                </label>
                <label class="text-white" id="feedback{{$id}}"
                @if(Helper::getFeedbackStatus($id) == 1) 
                    style="float: right; tranform-origin: center; transform: rotate(180deg);"
                @else style="float: right; tranform-origin: center; transform: rotate(0deg);" 
                @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                      </svg>
                </label>
            </div>
            <div x-show="show" class="border border-b-0 px-1 py-1 collapse" id="collapse{{$id}}" style="border-color: {{ $main_project_info['color'] }}">
                @if(Auth::user())
                <div class="flex float-right" style="z-index: 999;">
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
                    <a href="/delete/feedback/{{$main_project_id}}/{{$id}}" class="text-red-600" onclick="return confirm('Slow down HOTSHOT! You sure you want to delete this version?!');">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </a>
                </div>
                @endif
                <div class="container mx-auto px-4 py-12">
                    <div class="banners">
                        @foreach($row as $index => $banner)
                            @if($is_category == false) <label class="underline" style="display:flex; margin-left: 7px; font-size: 18px;">{{ Helper::getCategoryName($index) }}</label>  @endif
                            @foreach ($banner as $banner)
                            <?php
                                $directory = 'showcase_collection/'.$banner->file_path;
                                $resolution = explode("x", Helper::getBannerSizeinfo($banner->id));
                                $bannerSize = Helper::getBannerFileSize($banner->id);
                                $width = $resolution[0];
                                $height = $resolution[1];
                            ?>
                            <div class="single-div">
                                <small>{{ $width }}x{{ $height }}</small>
                                <small class="mx-auto text-red-700 size_text">{{ $bannerSize }}</small>
                                <iframe src="{{ asset($directory.'/index.html') }}" width="{{ $width }}"
                                    height="{{ $height }}" frameBorder="0" scrolling="no" id="rel{{ $banner->id }}" class="rels{{$id}}"></iframe>
                                <ul class="flex space-x-2 icons" style="color:{{ $main_project_info['color'] }};">
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
                                    @if(Auth::user())
                                    <li>
                                        <li><a href="/banner/download/{{$banner->id}}"
                                        class="color-primary underline flex mt-2">
                                            <svg class="w-5 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/banner/edit/{{ $banner->id }}" class="color-primary underline flex mt-2">
                                            <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/banner/delete/{{ $banner->id }}" class="color-primary underline flex mt-2" onclick="return confirm('Are you sure you want to delete this banner?');">
                                            <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </li>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js" integrity="sha512-VEBjfxWUOyzl0bAwh4gdLEaQyDYPvLrZql3pw1ifgb6fhEvZl9iDDehwHZ+dsMzA0Jfww8Xt7COSZuJ/slxc4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                function reloadAll() {
                    var versionElement = document.getElementById('version{{$id}}');
                    var versionID = document.getElementById('version{{$id}}').id;
                    var collapseID = document.getElementById('collapse{{$id}}').id;
                    var displayStatus = document.getElementById("collapse{{$id}}").style.display;

                    if(displayStatus == 'none'){
                        // console.log("Version: " + versionID + " Collapse: " + collapseID + " is opened!");
                        console.log('open');
                        setHeaderView(versionID, displayStatus);
                    }
                    else{
                        // console.log("Version: " + versionID + " Collapse: " + collapseID + " is closed!");
                        console.log('close');
                        setHeaderView(versionID, displayStatus);
                    }
                    
                    var els = document.getElementsByClassName("rels{{$id}}");

                    for(var i = 0; i < els.length; i++)
                    {
                        // console.log(els[i]);
                        els[i].src += "";
                    }
                }
                var relBtn = document.getElementById("version{{$id}}");
                relBtn.onclick = reloadAll;

                function setHeaderView(versionID, displayStatus){
                    //display none value is coming after the collapse is opened.
                    //so changing the value to opposite to send understandable axios request
                    str = versionID.replace("version", "");
                    var rotate = gsap.timeline({});

                    if(displayStatus == 'none'){
                        displayStatus = 'block';
                        rotate
                        .to('#feedback' + str, {duration: 0.65, rotate: 180, ease: "power0.none"})
                    }
                    else{
                        displayStatus = 'none';
                        rotate
                        .to('#feedback' + str, {duration: 0.65, rotate: 0, ease: "power0.none"})
                    }

                    axios.post('/setFeedbackStatus/' + versionID, 
                    {
                        displayStatus: displayStatus
                    })
                    .then(function (response)
                    {
                        if(response)
                        {
                            console.log(response);
                        }
                    })
                    .catch(function (error)
                    {
                        alert('Opps! There was an error in the process! See ConoleLog');
                        console.log(error);
                    });
                }
            </script>
        </div>
    </div>
    @endforeach
</main>