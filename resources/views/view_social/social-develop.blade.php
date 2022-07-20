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
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

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

        /* The grid: Four equal columns that floats next to each other */
        .column {
            display: inline-block;
            padding: 5px 5px;
        }

        /* Style the images inside the grid */
        .column img {
            opacity: 0.8;
            cursor: pointer;
        }

        .column img:hover {
            opacity: 1;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* The expanding image container */
        .imageContainer {
            position: relative;
            display: none;
        }

        .images {
            width: 300px;
            height: auto;
            border-radius: 10px;
        }

        .row {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
            align-content: center;
            align-items: center;
            text-align: center;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 99;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 100%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 100%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: auto;
            transform-origin: center;
        }

        #anotherCaption {
            margin: auto;
            display: block;
            width: 100%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: auto;
            transform-origin: center;
        }

        /* Add Animation */
        .modal-content,
        #caption,
        #anotherCaption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .alt-wrap {
            display: block;
            position: relative;
            margin: 20px;
            color: whitesmoke;
        }

        /* The alt text itself */
        /* Will be added with js */
        .alt-wrap p.alt {
            position: absolute;
            opacity: 0;
            /* hide initially */
            left: 0;
            right: 0;
            bottom: 0px;
            margin: 0;
            padding: 10px;
            font-size: 13px;
            line-height: 22px;
            background-color: rgba(0, 0, 0, 0.8);
            transition: all 300ms ease;
            transition-delay: 100ms;
            overflow: hidden;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* Hovering over the wrapper shows its alt p*/
        .alt-wrap:hover>p.alt {
            opacity: 1;
            transition-delay: 0s;
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
    
    <div class="container mx-auto px-4 py-4">
        {{-- If the user is authenticated, then the user can do these actions --}}
        

    </div>
    {{-- if there are no banners for this project then it will show no banners in the preview --}}

    @if($socials_info->count() == 0)
        <main class="main">
            <div class="container mx-auto px-4 py-4">
                <label class="text-red-700">No Banner Found!</label>
                <br>
                <label class="text-red-700">Please Add Banner or Delete This Project.</label>
            </div>
        </main>
    
    @else
        <main class="main">
            <div class="px-10">
                <div style="text-align:center; ">
                    <strong>Click on the images below:</strong>
                </div>
                <div class="container mx-auto px-4 py-4">
                    @if($socials_info->count() > 0)
                        <div class="row">
                            @foreach ($socials_info as $social)
                                <?php
                                    $file_path = $social->file_path;
                                    $directory = 'social_collection/'.$file_path;
                                ?>
                                <div class="column">
                                    <img src="{{ asset($directory) }}" alt="{{ $social->name }}"
                                        onclick="myFunction(this);" class="images">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>
                </div>
            </div>
        </main>        
    @endif

    @if($main_project_info->is_footer == 1)
    <footer class="footer" style="background-color: {{ $main_project_info['color'] }}">
        <div class="container mx-auto px-4 py-3 text-white text-center">&copy; All Right Reserved. <a
                href="{{ Helper::getCompanyWebsite($main_project_info->uploaded_by_company_id) }}" target="_blank" style="text-decoration: underline;">{{ Helper::getTitle($main_project_info->uploaded_by_company_id) }}</a>
            - <?= Date('Y') ?></div>
    </footer>
    @endif
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script>
        $(".images").wrap('<div class="alt-wrap"/>');
        $(".images").each(function () {
            $(this).after('<p class="alt">' + $(this).attr('alt') + '</p>');
        })

        function myFunction(imgs) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            var anotherCaptionText = document.getElementById("anotherCaption");
            modal.style.display = "block";
            modalImg.src = imgs.src;
            captionText.innerHTML = imgs.alt;

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function () {
                modal.style.display = "none";
            }
        }

    </script>
</body>

</html>
