<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $main_project_info['name'] }}</title>
    <link rel="shortcut icon" href="https://www.planetnine.com/wp-content/uploads/2020/06/cropped-favicon-32x32.png"
        type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #4c4f6d;
            width: 80px;
            height: 80px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin: 0 auto !important;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

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

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function list_comments() {
            $(".loader").hide();
            $.ajax({
                url: '/get_comments/' +{{ $main_project_id }},
                type: 'get',
                success: function (result) {
                    if (result) {
                        $("#not_needed").css("display", "none");
                        $('.comment_listing').html(result);
                    }
                }
            })
        }

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

        function get_color() {
            setInterval(function () {
                list_comments();
            }, 3000);
            $.ajax({
                url: '/get_colors/' +{{ $main_project_id }},
                type: 'get',
                success: function (result) {
                    if(result)
                    {
                        $('.header').css({"borderColor": result});
                        $('.footer').css({"backgroundColor": result});
                    }
                }
            })
        }
        
        $(document).ready(function(){
            $("#b1").click(function()
            {
                $(this).data('clicked', true);
                var color_rgb = $( this ).css( "background-color" );
                var color = rgb2hex(color_rgb);
                $.ajax({
                    url: '/set_color/' +{{ $main_project_id }},
                    data: {
                        color: color,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function (result) {
                        if(result)
                        {
                            get_color();
                        }
                        else
                        {
                            alert('Something is Wrong!');
                        }
                    }
                })
            });

            $("#b2").click(function()
            {
                $(this).data('clicked', true);
                var color_rgb = $( this ).css( "background-color" );
                var color = rgb2hex(color_rgb);
                $.ajax({
                    url: '/set_color/' +{{ $main_project_id }},
                    data: {
                        color: color,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function (result) {
                        if(result)
                        {
                            get_color();
                        }
                        else
                        {
                            alert('Something is Wrong!');
                        }
                    }
                })
            });

            $("#b3").click(function()
            {
                $(this).data('clicked', true);
                var color_rgb = $( this ).css( "background-color" );
                var color = rgb2hex(color_rgb);
                $.ajax({
                    url: '/set_color/' +{{ $main_project_id }},
                    data: {
                        color: color,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function (result) {
                        if(result)
                        {
                            get_color();
                        }
                        else
                        {
                            alert('Something is Wrong!');
                        }
                    }
                })
            });

            $("#b4").click(function()
            {
                $(this).data('clicked', true);
                var color_rgb = $( this ).css( "background-color" );
                var color = rgb2hex(color_rgb);
                $.ajax({
                    url: '/set_color/' +{{ $main_project_id }},
                    data: {
                        color: color,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function (result) {
                        if(result)
                        {
                            get_color();
                        }
                        else
                        {
                            alert('Something is Wrong!');
                        }
                    }
                })
            });
        });

        $(function () {
            list_comments();
            setInterval(function () {
                list_comments();
            }, 6000);
            $('.submit').click(function () {
                var comment = $('.comment').val();
                show_loader();
                $.ajax({
                    url: '/store_comments/' +{{ $main_project_id }},
                    data: {
                        comment: comment,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function () {
                        $('.comment').val('').change();
                        list_comments();
                    }
                })
            })
        })

        function show_loader() {
            $("#comment_button").hide();
            setTimeout(hide_loader, 4500);
            $(".loader").show();
        }

        function hide_loader() {
            $(".loader").hide();
            $("#comment_button").show();
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
                @else

                @endif
                <div x-data="{ commentModal: false }">
                    <svg @click.transition="commentModal = true" class="w-8 h-8 text-primary" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                        </path>
                    </svg>

                    <div x-show="commentModal" @click.away="commentModal = false"
                        class="h-screen bg-white shadow absolute top-0 right-0 w-64 p-4 rounded-lg">
                        <svg class="w-8 h-8 text-red-400 font-semibold" @click="commentModal = false" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div x-show="commentModal" @click.away="commentModal = false"
                            class="h-screen bg-white shadow absolute top-0 right-0 w-64 p-4 rounded-lg"
                            id="comment_modal">
                            <svg class="w-8 h-8 text-red-400 font-semibold" @click="commentModal = false" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <div id="not_needed">
                                <p class="my-4">If you like this video feel free to feedback us!</p>
                            </div>
                            <div>
                                <p class="my-4" style="text-decoration: underline;">Comments:</p>
                                <div class="comment_listing">
                                </div>
                                <textarea name="comment_content" id="comment" cols="5" rows="5"
                                    class="comment w-full border border-gray-600 focus:outline-none rounded-lg"></textarea>
                                <br>
                                <a href="javascript:void(0)" id="comment_button"
                                    class="submit bg-primary px-20 py-2 rounded-lg w-full text-white mt-2">Comment
                                </a>
                                <br>
                                <div class="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </header>

    <div class="container mx-auto px-4 py-2">
        <button class="button button1" id="b1"></button>
        <button class="button button2" id="b2"></button>
        <button class="button button3" id="b3"></button>
        <button class="button button4" id="b4"></button>
    </div>

    <div class="container mx-auto px-4 py-2">
        @if(Auth::user())
        <ul class="flex space-x-4">
            <li><a class="flex" href="/home" target="_blank">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span></a></li>
            <li>
                <a class="flex" href="/project/banner/addon/{{ $main_project_id }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Add More</span></a>
            </li>
        </ul>
        @endif
    </div>

    <main class="main">
        <div class="container mx-auto px-4 py-4">
            <div class="banners">
                @foreach($sub_project_info as $project)
                <?php
                    $zip = new ZipArchive;
                    $file_path = str_replace(".zip","", $project->file_path);
                    $directory = 'banner_collection/'.$file_path;
                ?>
                <div>
                    <small>{{ $project->width }}x{{ $project->height }}</small>
                    <small class="mx-auto text-red-700">{{ $project->size }}</small>
                    <iframe src="{{ asset($directory.'/index.html') }}" width="{{ $project->width }}"
                        height="{{ $project->height }}" frameBorder="0" scrolling="no" id="rel{{ $project->id }}"></iframe>
                    <ul class="flex space-x-2">
                        <li><i id="relBt{{ $project->id }}"
                                class="color-primary underline flex mt-2">
                                <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </i></li>
                        <li><a href="{{ asset('/banner_collection/'.$project->file_path) }}"
                                class="color-primary underline flex mt-2" download>
                                <svg class="w-5 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a></li>

                        @if(Auth::user())
                        <li><a href="/banner/edit/{{ $project->id }}" class="color-primary underline flex mt-2">
                                <svg class="w-5 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a></li>
                        <li><a href="/banner/delete/{{ $project->id }}" class="color-primary underline flex mt-2">
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
    </main>

    @if($main_project_info->is_footer == 1)
    <footer class="footer" style="background-color: {{ $main_project_info['color'] }}">
        <div class="container mx-auto px-4 py-3 text-white text-center">&copy; All Right Reserved. <a
                href="https://www.planetnine.com/" target="_blank" style="text-decoration: underline;">Planet Nine</a>
            - <?= Date('Y') ?></div>
    </footer>
    @endif
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
