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

        /* .footer{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        } */

        .button1 {background-color: red;}
        .button2 {background-color: #03befc;}
        .button3 {background-color: #fc6203;}
        .button4 {background-color: #4c4f6d;}

        .size_text{
            float: right!important;
        }

        .custom-radius{
            border-bottom-left-radius: 0!important;
            border-bottom-right-radius: 0!important;
        }

        /* .footer{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        } */

        .feedback-bar{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            color: white;
        }

        .left{
            display: flex;
            align-items: center;
            height: 100%;
        }

        .right{
            display: flex;
            align-items: center;
            height: 100%;
        }

        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            #show1{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            #show2{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            .single-div{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            #feedbackPart{
                padding-left: 0.1rem!important;
                padding-right: 0.1rem!important;
            }
        }
        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            #show1{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            #show2{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            .single-div{
                padding-left: 0!important;
                padding-right: 0!important;
            }

            #feedbackPart{
                padding-left: 0.1rem!important;
                padding-right: 0.1rem!important;
            }
        }
    </style>
    <?php $project_color = Helper::getProjectColor($main_project_id) ?>
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
                    var header = document.getElementsByClassName("header")[0];
                    var footer = document.getElementsByClassName("footer")[0];
                    var icons = document.getElementsByClassName("icons");
                    var versions = document.getElementsByClassName("all-versions");
                    var collapses = document.getElementsByClassName("collapse");
                    var feedbacks = document.getElementsByClassName("feedbacks");

                    if(header){
                        document.getElementsByClassName("header")[0].style.borderColor = color;
                    }
                    if(footer){
                        document.getElementsByClassName("footer")[0].style.backgroundColor = color;
                    }
                    if(icons){
                        for(var i = 0; i < icons.length; i++){
                            icons[i].style.color = color;
                        }
                    }
                    if(versions){
                        for(var j = 0; j < versions.length; j++){

                            if(versions[j].style.backgroundColor == 'white'){
                                versions[j].style.borderColor = color;
                                versions[j].style.color = color;
                            }
                            else{
                                versions[j].style.backgroundColor = color;
                                versions[j].style.borderColor = color;
                            }
                        }
                    }
                    if(collapses){
                        for(var k = 0; k < collapses.length; k++){
                            collapses[k].style.borderColor = color;
                        }
                    }
                    if(feedbacks){
                        for(var l = 0; l < feedbacks.length; l++){
                            feedbacks[l].style.backgroundColor = color;
                        }
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
                <h1 style="font-size: 16px;">ID: <span class="font-semibold">{{ $main_project_id }}</span></h1>
                <h1 style="font-size: 16px;">Client Name: <span class="font-semibold">{{ $main_project_info['client_name'] }}</span></h1>
                <h1 style="font-size: 16px;">Project Name: <span class="font-semibold">{{ $main_project_info['name'] }}</span></h1>
                <h1 style="font-size: 16px;">Total Video(s): <span class="font-semibold">{{ Helper::getTotalVideosCount($main_project_id) }}</span></h1>
                <h1 style="font-size: 16px;">Date: <span class="font-semibold">{{ \Carbon\Carbon::parse(Helper::getProjectCreationDate($main_project_id))->format('d F Y') }}</span></h1>
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
                     alt="{{ $main_project_info['client_name'] }}" class="logo-main mr-4"/>
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
    @if(Auth::user())
        <ul class="flex space-x-4">
            <li><a class="flex" href="/" target="_blank">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span></a>
            </li>
            <li>
                <a class="flex" href="/video-showcase" target="_blank" style="color: #3182ce;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                      </svg>
                    <span>Videos</span>
                </a>
            </li>
            <li><a class="flex text-green-600" href="/project/video-showcase/addon/{{ $main_project_id }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Add More</span></a>
            </li>
        </ul>
    @endif
</div>

@if($videos->count() == 0)
        <main class="main">
            <div class="container mx-auto px-4 py-4">
                <label class="text-red-700">No Video Found!</label>
                <br>
                <label class="text-red-700">Please Add Video or Delete This Project.</label>
            </div>
        </main>
    @else
        @if($is_version == false)
            @include('new_files.video.singlepage')
        @else
            @include('new_files.video.feedback')
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
