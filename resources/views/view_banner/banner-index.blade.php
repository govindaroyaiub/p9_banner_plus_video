<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $main_project_info['name'] }}</title>
    <link rel="shortcut icon" href="{{ Helper::getFavicon($main_project_info['uploaded_by_company_id']) }}"
        type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <style>
        .logo-main {
            width: 200px;
            height: 45px;
        }

        .button {
            border: none;
            color: white;
            padding: 9px 13px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button1 {
            background-color: red;
        }

        .button2 {
            background-color: #03befc;
        }

        .button3 {
            background-color: #fc6203;
        }

        .button4 {
            background-color: #4c4f6d;
        }

        li:hover {
            cursor: pointer;
        }

        .single-div{
            display: inline-block;
            padding: 0 7px;
        }

        .size_text{
            float: right!important;
        }

    </style>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        function rgb2hex(rgb) {
            if (  rgb.search("rgb") == -1 ) {
                return rgb;
            } else {
                rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
                function hex(x) {
                    return ("0" + parseInt(x).toString(16)).slice(-2);
                }
                return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]); 
            }
        }

        function get_color(element)
        {   
            var get_color = window.getComputedStyle(element).backgroundColor;
            var color = rgb2hex(get_color);
            set_color(color);
        }

        function set_color(color)
        {
            axios.post('/set_color/' + {{ $main_project_id }}, 
            {
                color: color
            })
            .then(function (response)
            {
                if(response)
                {
                    document.getElementsByClassName("header")[0].style.borderColor = color;
                    document.getElementsByClassName("footer")[0].style.backgroundColor = color;
                    document.getElementsByClassName("icons")[0].style.color = color;
                }
            })
            .catch(function (error)
            {
                alert('Opps! There was an error in the process! See ConoleLog');
                console.log(error);
            });
        }
        
    </script>
</head>

<body class="font-body">
    <header class="header relative border-b" style="border-color: {{ $main_project_info['color'] }}">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div>
                <h3>Client Name: <span class="font-semibold">{{ $main_project_info['client_name'] }}</span></h3>
                <h3>Project Name: <span class="font-semibold">{{ $main_project_info['name'] }}</span></h3>
            </div>

            <div class="flex">
                @if($main_project_info->is_logo == 1)
                <img src="{{ asset('/logo_images/'.'/'.$main_project_info->path) }}"
                    alt="{{ $main_project_info['client_name'] }}" class="logo-main mr-4" />
                @endif
            </div>
    </header>

    <div class="container mx-auto px-4 py-2">
        <button class="button button1" id="b1" onclick="get_color(this)"></button>
        <button class="button button2" id="b2" onclick="get_color(this)"></button>
        <button class="button button3" id="b3" onclick="get_color(this)"></button>
        <button class="button button4" id="b4" onclick="get_color(this)"></button>
    </div>

    <div class="container mx-auto px-4 py-2">
        {{-- If the user is authenticated, then the user can do these actions --}}
        @if(Auth::user())
        <ul class="flex space-x-4">
            <li>
                <a class="flex" href="/" target="_blank" style="color: {{ $main_project_info['color'] }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="flex text-green-600" href="/project/banner/addon/{{ $main_project_id }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Add More</span>
                </a>
            </li>
            <li>
                <a class="flex text-red-600" href="/delete-all-banners/{{ $main_project_id }}" onclick="return confirm('Slow down HOTSHOT! You sure you want to delete all the banners?!');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    <span>Delete All</span>
                </a>
            </li>
        </ul>
        @endif

    </div>
    {{-- if there are no banners for this project then it will show no banners in the preview --}}

    @if($sub_project_info->count() == 0)
        <main class="main">
            <div class="container mx-auto px-4 py-4">
                <label class="text-red-700">No Banner Found!</label>
                <br>
                <label class="text-red-700">Please Add Banner or Delete This Project.</label>
            </div>
        </main>
    
    @else
        {{-- if the project has no version then it will show the preview the normal way.
        and if it has version then the preview will show in tabs --}}

        @if($main_project_info['is_version'] == 0)
        <main class="main">
            <div x-show="show" class="px-10 py-6">
                <div class="container mx-auto px-4 py-4">
                    <div class="banners">
                        @foreach($sub_project_info as $project)
                        <?php
                            $zip = new ZipArchive;
                            $file_path = str_replace(".zip","", $project->file_path);
                            $directory = 'banner_collection/'.$file_path;
                        ?>
                        <div class="single-div">
                            <small>{{ $project->width }}x{{ $project->height }}</small>
                            <small class="mx-auto text-red-700 size_text">{{ $project->size }}</small>
                            <iframe src="{{ asset($directory.'/index.html') }}" width="{{ $project->width }}"
                                height="{{ $project->height }}" frameBorder="0" scrolling="no" id="rel{{ $project->id }}"></iframe>
                            <ul class="flex space-x-2 icons" style="color:{{ $main_project_info['color'] }};">
                                <li><i id="relBt{{ $project->id }}"
                                        class="color-primary underline flex mt-2">
                                        <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </i></li>
                                @if(Auth::user())
                            
                                <li><a href="{{ asset('/banner_collection/'.$project->file_path) }}"
                                    class="color-primary underline flex mt-2" download>
                                    <svg class="w-5 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a></li>
                                <li><a href="/banner/edit/{{ $project->id }}" class="color-primary underline flex mt-2">
                                        <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a></li>
                                <li><a href="/banner/delete/{{ $project->id }}" class="color-primary underline flex mt-2" onclick="return confirm('Are you sure you want to delete this banner?');">
                                        <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a></li>
                                @endif
                            </ul>
                        </div>
                        <script>
                            function reload() {
                                document.getElementById("rel{{ $project->id }}").src += '';
                            }
                            var relBtn = document.getElementById("relBt{{ $project->id }}");
                            relBtn.onclick = reload;
                        </script>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

        @else
        <main class="main">
            <?php $i=1; ?>
            @foreach ($data as $id => $row)
            <div class="container mx-auto px-4 py-3">
                <div @if(Helper::getVersionStatus($id) == 1) x-data={show:true} @else x-data={show:false} @endif class="rounded-sm">
                    <div class="bg-gray-100 px-10 py-6 cursor-pointer" id="version{{$id}}" @click="show=!show">
                        <label class="text-blue-500">{{$i++}}. </label>
                        <label class="underline text-blue-500 hover:text-blue-700 cursor-pointer" type="button">
                            {{ Helper::getVersionName($id) }}
                        </label> - 
                        <label class="text-blue-500 hover:text-blue-700 cursor-pointer" type="button">
                            {{ \Carbon\Carbon::parse(Helper::getVersionDate($id))->format('d F Y') }}
                        </label>
                    </div>
                    <div x-show="show" class="border border-b-0 px-1 py-1" id="collapse{{$id}}" class="collapse">
                        @if(Auth::user())
                        <div class="flex float-right" style="z-index: 999;">
                            <a href="/banner/add/version/{{$main_project_id}}/{{$id}}" class="text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <a href="/banner/edit/version/{{$main_project_id}}/{{$id}}" class="text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                  </svg>
                            </a>
                            <a href="/delete/version/{{$main_project_id}}/{{$id}}" class="text-red-600" onclick="return confirm('Slow down HOTSHOT! You sure you want to delete this version?!');">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            </a>
                        </div>
                        @endif
                        <div class="container mx-auto px-4 py-12">
                            <div class="banners">
                                @foreach($row as $project)
                                <?php
                                    $zip = new ZipArchive;
                                    $file_path = str_replace(".zip","", $project->file_path);
                                    $directory = 'banner_collection/'.$file_path;
                                ?>
                                <div class="single-div">
                                    <small>{{ $project->width }}x{{ $project->height }}</small>
                                    <small class="mx-auto text-red-700 size_text">{{ $project->size }}</small>
                                    <iframe src="{{ asset($directory.'/index.html') }}" width="{{ $project->width }}"
                                        height="{{ $project->height }}" frameBorder="0" scrolling="no" id="rel{{ $project->id }}" class="rels{{$id}}"></iframe>
                                    <ul class="flex space-x-2 icons" style="color:{{ $main_project_info['color'] }};">
                                        <li>
                                            <i id="relBt{{ $project->id }}"
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
                                            <a href="{{ asset('/banner_collection/'.$project->file_path) }}"
                                            class="color-primary underline flex mt-2" download>
                                                <svg class="w-5 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/banner/edit/{{ $project->id }}" class="color-primary underline flex mt-2">
                                                <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/banner/delete/{{ $project->id }}" class="color-primary underline flex mt-2" onclick="return confirm('Are you sure you want to delete this banner?');">
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
                                        document.getElementById("rel{{ $project->id }}").src += '';
                                    }
                                    var relBtn = document.getElementById("relBt{{ $project->id }}");
                                    relBtn.onclick = reload;
                                </script>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <script>
                        function reloadAll() {
                            var versionID = document.getElementById('version{{$id}}').id;
                            var collapseID = document.getElementById('collapse{{$id}}').id;
                            var displayStatus = document.getElementById("collapse{{$id}}").style.display;

                            if(displayStatus == 'none'){
                                // console.log("Version: " + versionID + " Collapse: " + collapseID + " is opened!");
                                setHeaderView(versionID, displayStatus);
                            }
                            else{
                                // console.log("Version: " + versionID + " Collapse: " + collapseID + " is closed!");
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

                            if(displayStatus == 'none'){
                                displayStatus = 'block';
                            }
                            else{
                                displayStatus = 'none';
                            }

                            axios.post('/setVersionStatus/' + versionID, 
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
        @endif
    @endif

    @if($main_project_info->is_footer == 1)
    <footer class="footer" style="background-color: {{ $main_project_info['color'] }}">
        <div class="container mx-auto px-4 py-3 text-white text-center">&copy; All Right Reserved. <a
                href="{{ Helper::getCompanyWebsite($main_project_info->uploaded_by_company_id) }}" target="_blank" style="text-decoration: underline;">{{ Helper::getTitle($main_project_info->uploaded_by_company_id) }}</a>
            - <?= Date('Y') ?></div>
    </footer>
    @endif
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
