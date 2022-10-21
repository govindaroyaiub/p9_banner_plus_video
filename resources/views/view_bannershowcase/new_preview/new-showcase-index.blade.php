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
        section {
            position: relative;
            width: 100%;
            height: 21vh;
            overflow: hidden;
        }

        section .content {
            position: relative;
            z-index: 1;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 1rem 4rem 1rem 4rem;
            font-size: 15px;
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
            transform: scaleX(1.5);
        }

        .single-div {
            display: inline-block;
        }

        #planetnineLogo {
            width: 100%;
            max-width: 50%;
        }

        #polygon {
            position: absolute;
            top: -30%;
            right: 0;
            width: 100%;
            height: auto;
            max-width: 500px;
            min-width: 500px;
            float: right;
        }

        @media only screen and (min-width : 320px) {
            #polygon{
                display: none;
            }

            section .content{
                font-size: 12px;
            }
        }

        /* Extra Small Devices, Phones */
        @media only screen and (min-width : 480px) {
            #polygon{
                display: none;
            }

            section .content{
                font-size: 13px;
            }
        }

        /* Small Devices, Tablets */
        @media only screen and (min-width : 768px) {
            #polygon{
                display: block;
                max-width: 380px;
                min-width: 380px;
                float: right;
            }

            section {
                height: 17vh;
            }
        }

        /* Medium Devices, Desktops */
        @media only screen and (min-width : 992px) {
            #polygon{
                display: block;
                max-width: 380px;
                min-width: 380px;
                float: right;
            }

            section {
                height: 21vh;
            }
        }

        /* Large Devices, Wide Screens */
        @media only screen and (min-width : 1200px) {
            #polygon{
                display: block;
                float: right;
            }

            section {
                height: 21vh;
            }
        }

    </style>
</head>

<body class="font-body">
    <section id="top">
        <div class="content">
            <div>
                <img src="{{ asset('logo_images/logo.png') }}" id="planetnineLogo" class="py-1" alt="planetnineLogo">
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
    <div>
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

        @endif
        @endif
    </div>
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
        $('#polygon').mousemove(function (e) {
            let mouseX = e.pageX;
            let mouseY = e.pageY;

            $(this).css({
                'transform': 'translate(' + mouseX / -20 + 'px ,' + mouseY / -20 + 'px'
            })
        });
    });

</script>

</html>
