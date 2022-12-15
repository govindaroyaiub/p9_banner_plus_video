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
            padding-bottom: 3rem;
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
        }

        .custom-radius {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        /* .footer{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        } */

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
            #polygon {
                display: none;
            }

            #topDetails {
                text-align: center;
                font-size: 13px;
                padding-left: 0;
            }

            #planetnineLogo {
                margin: 0 auto;
                text-align: center;
                padding-top: 0
            }
        }

        @media only screen and (min-width: 481px) and (max-width: 768px) {
            #polygon {
                max-width: 300px;
                min-width: 300px;
            }

            #topDetails {
                padding-top: 1rem;
                padding-left: 0;
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
        }

        .tabs {
            display: flex;
            flex-wrap: wrap;
        }

        .tabs label {
            order: 1;
            display: block;
            padding: 0.5rem 2rem;
            margin-right: 0.2rem;
            cursor: pointer;
            font-weight: bold;
            transition: background ease 0.2s;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background: {{ $project_color }};

        }

        .tabs .tab {
            order: 99;
            flex-grow: 1;
            width: 100%;
            display: none;
            padding: 1rem;
            border-top-right-radius: 10px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;
            border: 1px solid {{ $project_color }};
        }

        .tabs input[type="radio"] {
            display: none;
        }

        .tabs input[type="radio"]:checked+label {
            
            background: {{ $project_color }};
        }

        .tabs input[type="radio"]:checked+label+.tab {
            display: block;
        }

        @media (max-width: 45em) {

            .tabs .tab,
            .tabs label {
                order: initial;
            }

            .tabs label {
                width: 100%;
                margin-right: 0;
                margin-top: 0.2rem;
            }
        }

    </style>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>


<body class="font-body">
    <section id="top">
        <div class="container mx-auto px-4 py-4 flex justify-center content">
            <div id="topDetails">
                <img src="{{ asset('logo_images/logo.png') }}" id="planetnineLogo" class="py-3" alt="planetnineLogo">
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
    <main class="main">
        <div class="container mx-auto px-4 py-4">
            <label class="text-red-700">No Banner Found!</label>
            <br>
            <label class="text-red-700">Please Add Banner or Delete This Project.</label>
        </div>
    </main>
    @else
    @if($is_version == false)
    @include('view_bannershowcase.new_preview.singlepage-part')
    @else
    @include('view_bannershowcase.new_preview.feedback-part')
    @endif
    @endif
    <footer class="footer" style="background-color: #4b4e6d; border-radius: 50% 50% 0 0 / 100% 100% 0 0;">
        <div class="container mx-auto px-4 py-4 text-white text-center">&copy; All Right Reserved. <a
                href="{{ Helper::getCompanyWebsite($main_project_info->uploaded_by_company_id) }}" target="_blank"
                style="text-decoration: underline;">{{ Helper::getTitle($main_project_info->uploaded_by_company_id) }}</a>
            - <?= Date('Y') ?></div>
    </footer>
</body>

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
    integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#top").mouseover(function () {
            $('#top').mousemove(function (e) {
                let mouseX = e.pageX;
                let mouseY = e.pageY;

                $('#polygon').css({
                    'transform': 'translate(' + mouseX / -20 + 'px ,' + mouseY / -20 +
                        'px',
                    'transition': ''
                })
            });
        });

        $("#top").mouseout(function () {
            document.getElementById('polygon').style.transform = "translate(0, 0)";
            document.getElementById('polygon').style.transition = "ease 0.15s";
        });

    });

</script>

</html>
