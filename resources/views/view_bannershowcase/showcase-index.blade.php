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
            height: auto;
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

        .custom-radius{
            border-bottom-left-radius: 0!important;
            border-bottom-right-radius: 0!important;
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
                    var icons = document.getElementsByClassName("icons");
                    var versions = document.getElementsByClassName("all-versions");
                    var collapses = document.getElementsByClassName("collapse");

                    for(var i = 0; i < icons.length; i++){
                        icons[i].style.color = color;
                    }

                    for(var j = 0; j < versions.length; j++){
                        versions[j].style.backgroundColor = color;
                    }

                    for(var k = 0; k < collapses.length; k++){
                        collapses[k].style.borderColor = color;
                    }
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
            @if($main_project_info['uploaded_by_company_id'] == 1)
            <div>
                <h1 style="font-size: 16px;">Client Name: <span class="font-semibold">{{ $main_project_info['client_name'] }}</span></h1>
                <h1 style="font-size: 16px;">Project Name: <span class="font-semibold">{{ $main_project_info['name'] }}</span></h1>
            </div>
            @else
                <div>
                    <h1>Client Name: <span class="font-semibold">{{ $main_project_info['client_name'] }}</span></h1>
                    <h1>Project Name: <span class="font-semibold">{{ $main_project_info['name'] }}</span></h1>
                </div>
            @endif

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
    
    <div class="container mx-auto px-4 py-4">
        {{-- If the user is authenticated, then the user can do these actions --}}
        @if(Auth::user())
        <ul class="flex space-x-4">
            <li>
                <a class="flex" href="/" target="_blank">
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

    <main class="main">
        <div x-show="show" class="px-10 py-6">
            <div class="container mx-auto px-4 py-4">
                @foreach ($data as $index => $feedback)
                    {{ Helper::getFeedbackName($index) }}

                    @foreach ($feedback as $index => $category)
                        {{ Helper::getCategoryName($index) }}

                        @foreach ($category as $index => $banner)
                            {{ Helper::getBannerInfo($index) }}
                        @endforeach

                    @endforeach

                @endforeach
            </div>
        </div>
    </main>

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