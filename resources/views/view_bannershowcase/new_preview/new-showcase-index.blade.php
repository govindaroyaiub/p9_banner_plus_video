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
    <?php $project_color = Helper::getProjectColor($main_project_id) ?>

    <style>
        :root {
        --default_color: {{ $project_color }}
        }
        html {
            height: 100%;
            box-sizing: border-box;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            position: relative;
            margin: 0;
            padding-bottom: 6rem;
            min-height: 100%;
        }

        /* width */
        ::-webkit-scrollbar {
        width: 6px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey; 
        border-radius: 10px;
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #4b4e6d;
        border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #6a6e94; 
        }

        section {
            position: relative;
            width: 100%;
            height: auto;
            overflow: hidden;
        }

        section .content {
            position: relative;
            z-index: 1;
            color: white;
            display: flex;
            justify-content: space-between;
            font-size: 15px;
            padding-bottom: 5rem;
        }

        section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #4b4e6d;
            border-radius: 0 0 50% 50%/0 0 100% 100%;
            transform: scaleX(1.3);
        }

        .single-div {
            display: inline-block;
        }

        #planetnineLogo {
            width: 100%;
            max-width: 80%;
        }

        #polygon {
            position: absolute;
            top: -30%;
            right: 0;
            width: 100%;
            height: auto;
            max-width: 500px;
            min-width: 500px;
            transform-origin: center;
        }

        .custom-radius {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .feedback-bar {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            color: white;
        }

        .left {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .right {
            display: flex;
            align-items: center;
            height: 100%;
        }

        @media only screen and (min-width: 320px) and (max-width: 480px) {
            section .content {
                position: relative;
                z-index: 1;
                color: white;
                display: flex;
                justify-content: space-between;
                font-size: 15px;
                padding-bottom: 2rem;
            }

            #polygon {
                display: none;
            }

            #topDetails {
                text-align: center;
                font-size: 13px;
                padding-left: 0;
                left: 0;
                right: 0;
                margin: 0 auto;
            }

            #planetnineLogo {
                margin: 0 auto;
                text-align: center;
                padding-top: 0
            }

            #preview-shapes{
                display: none;
            }
        }

        @media only screen and (min-width: 481px) and (max-width: 768px) {
            section .content {
                position: relative;
                z-index: 1;
                color: white;
                display: flex;
                justify-content: space-between;
                font-size: 15px;
                padding-bottom: 7rem;
            }

            #polygon {
                max-width: 300px;
                min-width: 300px;
                top: 0;
            }

            #topDetails {
                padding-left: 0;
            }
            
            #preview-shapes{
                display: none;
            }
        }

        @media only screen and (min-width: 769px) and (max-width: 1024px) {
            #polygon {
                max-width: 400px;
                min-width: 400px;
            }

            #topDetails {
                padding-top: 1rem;
            }

            #preview-shapes{
                display: none;
            }
        }

        #tab-container {
            align-items: center;
            position: relative;
            text-align: center;
            color: white;
            margin-left: 5px;
        }

        #tabs{
            opacity: 1;
            display: block;
            overflow: hidden;
            width: 1150px;
            left: 45px;
        }

        #tabs .versions {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: white;
            cursor: pointer;
            transform-origin: center;
            background-color: #6a6e94;
        }

        .owl-item{
            width: 225px!important;
            margin-right: 5px;
        }

        .active,#tabs .versions:hover {
            box-shadow: 2px 2px 5px black;
            background-color: var(--default_color)!important;
        }

        /* #tab-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            width: 100%;
        }

        #tabs {
            display: flex;
            flex: 1;
            flex-wrap: nowrap;
        }

        #tabs div {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: white;
            padding: 5px 10px 5px 10px;
            cursor: pointer;
            transform-origin: center;
            background-color: #6a6e94;
        }

        #left-arrow, #right-arrow {
            position: absolute;
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-60%);
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #4b4e6d;
            border-radius: 50%;
        } */
        #left-arrow, #right-arrow {
            position: absolute;
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-60%);
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #4b4e6d;
            border-radius: 50%;
        }

        #left-arrow {
            left: 0;
        }

        #right-arrow {
            right: 0;
        }

        #bannershow {
            width: 100%;
            height: auto;
            border: 1px solid var(--default_color);
            border-top-width: medium;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border-top-right-radius: 8px;
            border-top-left-radius: 8px;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            /* justify-content: center; */
            /* align-items: center; */
            overflow: hidden;
            min-height: 320px;
        }

        #feedbackInfo {
            position: relative;
            display: block;
            width: fit-content;
            height: auto;
            border: 1px solid;
            color: white;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            text-align: center;
            left: 0;
            right: 0;
            margin: 0 auto;
            background: var(--default_color);
            border-color: var(--default_color);
        }

        #feedbackLabel {
            padding: 20px;
            word-break: break-word;
        }

        #bannerShowcase {
            margin-top: 10px;
            width: 100%;
            height: auto;
            text-align: center;
        }

        #loaderArea {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: inline-block;
        }

        .loader {
            position: relative;
            top: 50%;
            left: 50%;
            width: 48px;
            height: 48px;
            border: 5px solid #FFF;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
            border-bottom-color: var(--default_color);
            border-right-color: var(--default_color);
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
            background-color: #4b4e6d;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            text-align: center;
        }

    </style>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body class="font-body">
    <div id="loaderArea">
        <span class="loader"></span>
    </div>
    <main class="main">
        <div id="preview-shapes">
            <div id="left-shapes" style="position: fixed; top: 30%; left: 0%; display: flex; flex-direction: column; transform-origin: center bottom; transform: rotate(-45deg);">
                <div class="left-shape-left left-shape-left-right" style="display: flex; position: relative; top: -90%; left: -90%;">
                    <div id="left-shape11" style="position: relative; left: -2rem; width: 200px; height: 45px; background: {{ $main_project_info['color'] }};"></div>
                    <div id="left-shape12" style="position: relative; width: 45px; height: 45px; background: {{ $main_project_info['color'] }}; border-radius: 50%; left: -3.5rem;"></div>
                </div>
                <div class="left-shape-right left-shape-left-right" style="display: flex; margin-top: 8px; position: relative; top: -90%; left: -90%;">
                    <div id="left-shape21" style="position: relative; left: -4rem; width: 160px; height: 20px; background-color: rgb(217, 218, 227);"></div>
                    <div id="left-shape22" style="position: relative; width: 20px; height: 20px; background-color: rgb(217, 218, 227); border-radius: 50%; left: -4.5rem;"></div>
                </div>
            </div>

            <div id="right-shapes" style="position: fixed; bottom: 17%; right: 0%; display: flex; flex-direction: column; transform-origin: center top; transform: rotate(135deg);">
                <div class="right-shape-left right-shape-left-right" style="display: flex; position: relative; bottom: 90%; right: 90%;">
                    <div id="right-shape11" style="position: relative; right: 6rem; width: 200px; height: 45px; background: {{ $main_project_info['color'] }};"></div>
                    <div id="right-shape12" style="position: relative; width: 45px; height: 45px; background: {{ $main_project_info['color'] }}; border-radius: 50%; left: -7.5rem;"></div>
                </div>
                <div class="right-shape-right right-shape-left-right" style="display: flex; margin-top: 8px; position: relative; bottom: 90%; right: 90%;">
                    <div id="right-shape21" style="position: relative; right: 8rem; width: 160px; height: 20px; background-color: rgb(217, 218, 227);"></div>
                    <div id="right-shape22" style="position: relative; width: 20px; height: 20px; background-color: rgb(217, 218, 227); border-radius: 50%; left: -8.5rem;"></div>
                </div>
            </div>
        </div>
        <section id="top">
            <div class="container mx-auto px-4 py-4 flex justify-center content">
                <div id="topDetails">
                    <img src="{{ asset('logo_images/logo.png') }}" id="planetnineLogo" class="py-3"
                        alt="planetnineLogo">
                    <h1>Client Name: <span class="font-semibold">{{ $main_project_info['client_name'] }}</span></h1>
                    <h1>Project Name: <span lass="font-semibold">{{ $main_project_info['name'] }}</span></h1>
                    <h1>Total Creatives: <span
                            class="font-semibold">{{ Helper::getTotalBannersCount($main_project_id) }}</span></h1>
                    <h1>Date: <span
                            class="font-semibold">{{ \Carbon\Carbon::parse(Helper::getProjectCreationDate($main_project_id))->format('d F Y') }}</span>
                    </h1>
                </div>
                <div>
                    <img src="{{ asset('logo_images/polygon.png') }}" alt="polygon" id="polygon">
                </div>
            </div>
        </section>
        <div class="container mx-auto px-4 py-4 flex justify-center">
            {{-- If the user is authenticated, then the user can do these actions --}}
            @if(Auth::check())
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
                    <a class="flex" href="/banner-showcase" target="_blank" style="color: #3182ce;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <span>Banners</span>
                    </a>
                </li>
                <li>
                    <a class="flex text-green-600" href="/project/banner-showcase/addon/{{ $main_project_id }}">
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
                    <a class="flex text-red-600" href="/delete-all-banners-showcase/{{ $main_project_id }}"
                        onclick="return confirm('Slow down HOTSHOT! You sure you want to delete all the banners?!');">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete All</span>
                    </a>
                </li>
            </ul>
            @endif
            @endif
        </div>

        @if($banners->count() == 0)
        <div class="container mx-auto px-4 py-4">
            <label class="text-red-700">No Banner Found!</label>
            <br>
            <label class="text-red-700">Please Add Banner or Delete This Project.</label>
        </div>
        @else
        @if($is_version == false)
        <script>
            document.getElementById('loaderArea').style.display = 'none';
        </script>
        @include('view_bannershowcase.new_preview.singlepage-part')
        @else
        @include('view_bannershowcase.new_preview.feedback-part-new')
        @endif
        @endif

        <footer class="footer">
            <div class="container mx-auto px-4 py-4 text-white text-center">&copy; All Right Reserved. <a
                    href="{{ Helper::getCompanyWebsite($main_project_info->uploaded_by_company_id) }}" target="_blank"
                    style="text-decoration: underline;">{{ Helper::getTitle($main_project_info->uploaded_by_company_id) }}</a>
                - <?= Date('Y') ?></div>
        </footer>
    </main>
</body>

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
    integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<script src="https://s0.2mdn.net/ads/studio/cached_libs/gsap_3.5.1_min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" integrity="sha512-9CWGXFSJ+/X0LWzSRCZFsOPhSfm6jbnL+Mpqo0o8Ke2SYr8rCTqb4/wGm+9n13HtDE1NQpAEOrMecDZw4FXQGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    var masterTimeline = gsap.timeline();

    masterTimeline

    .add('f1', '+=2')
    .to('.left-shape-left-right', {duration: 0.75, top: '30%', left: 0, ease: 'power2.out', stagger: 0.2}, 'f1')
    .to('.right-shape-left-right', {duration: 0.75, bottom: '17%', right: 0, ease: 'power2.out', stagger: 0.2}, 'f1')

    $(document).ready(function () {
        console.log($(window).width()); // New width
        var screenWidth = $(window).width();

        if(screenWidth < 1560){
                $('#preview-shapes').css('display', 'none');
            }
            else{
                $('#preview-shapes').css('display', 'block');
            }

        $(window).resize(function() {
            // This will execute whenever the window is resized
            var screenWidth = $(window).width();

            if(screenWidth < 1560){
                $('#preview-shapes').css('display', 'none');
            }
            else{
                $('#preview-shapes').css('display', 'block');
            }
        });

        $("#top").mouseover(function () {
            $('#top').mousemove(function (e) {
                let mouseX = e.pageX;
                let mouseY = e.pageY;

                $('#polygon').css({
                    'transform': 'scale(1.2) translate(' + mouseX / -20 + 'px ,' + mouseY / -20 + 'px)', 'transition': 'ease 0.2s',
                });
            });
        });

        $("#top").mouseout(function () {
            $('#polygon').css({
                'transform': 'scale(1)', 'transition': 'ease 0.2s',
            });
        });

    });

</script>
<script type="text/javascript">
    function chkInternetStatus() {
        if(navigator.onLine) {
            alert("Hurray! You're online!!!");
        } else {
            alert("Oops! You're offline. Please check your network connection...");
        }
    }
</script>
</html>
