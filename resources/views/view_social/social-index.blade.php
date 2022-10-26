<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial;
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
        .container {
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
            bottom: 3px;
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
</head>

<body>

    <div style="text-align:center">
        <h2>Image Showcase: {{ $main_project_info['name'] }}</h2>
        <p>Click on the images below:</p>
    </div>

    <!-- The four columns -->
    @if($socials_info->count() > 0)
        <div class="row">
            @foreach ($socials_info as $social)
                <?php
                    $file_path = $social->file_path;
                    $directory = 'social_collection/'.$file_path;
                    list($width, $height) = getimagesize($directory);
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
