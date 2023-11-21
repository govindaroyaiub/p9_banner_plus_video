<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $info['name'] }}</title>
    <link rel="shortcut icon" href="{{ Helper::getFavicon($info['uploaded_by_company_id']) }}"
        type="image/x-icon">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/preview.css') }}" rel="stylesheet">

    <?php $project_color = Helper::getProjectColor2($main_project_id) ?>

    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://s0.2mdn.net/ads/studio/cached_libs/gsap_3.5.1_min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-body">
    
    <div id="loaderArea">
        <span class="loader"></span>
    </div>
    <main class="main">
        <div class="viewMessage">
            For better View Please Use Laptop or Desktop
        </div>
        <div id="preview-shapes">
            <div id="left-shapes" style="position: fixed; top: 30%; left: 0%; display: flex; flex-direction: column; transform-origin: center bottom; transform: rotate(-45deg);">
                <div class="left-shape-left left-shape-left-right" style="display: flex; position: relative; top: -90%; left: -90%;">
                    <div id="left-shape11" style="position: relative; left: -2rem; width: 200px; height: 45px; background: #4b4e6d;"></div>
                    <div id="left-shape12" style="position: relative; width: 45px; height: 45px; background: #4b4e6d; border-radius: 50%; left: -3.5rem;"></div>
                </div>
                <div class="left-shape-right left-shape-left-right" style="display: flex; margin-top: 8px; position: relative; top: -90%; left: -90%;">
                    <div id="left-shape21" style="position: relative; left: -4rem; width: 160px; height: 20px; background-color: rgb(217, 218, 227);"></div>
                    <div id="left-shape22" style="position: relative; width: 20px; height: 20px; background-color: rgb(217, 218, 227); border-radius: 50%; left: -4.5rem;"></div>
                </div>
            </div>

            <div id="right-shapes" style="position: fixed; bottom: 3%; right: 0%; display: flex; flex-direction: column; transform-origin: center top; transform: rotate(135deg);">
                <div class="right-shape-left right-shape-left-right" style="display: flex; position: relative; bottom: 90%; right: 90%;">
                    <div id="right-shape11" style="position: relative; right: 6rem; width: 200px; height: 45px; background: #4b4e6d;"></div>
                    <div id="right-shape12" style="position: relative; width: 45px; height: 45px; background: #4b4e6d; border-radius: 50%; left: -7.5rem;"></div>
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
                    <?php $logo_path = Helper::getLogoForPreview($logo_id); ?>
                    <img src="{{ asset('logo_images/logo.png') }}" id="planetnineLogo" class="py-3"
                        alt="planetnineLogo">
                    <h1>Client Name: <span class="font-semibold">{{ $info['client_name'] }}</span></h1>
                    <h1>Project Name: <span lass="font-semibold">{{ $info['name'] }}</span></h1>
                    <h1>Date: <span
                            class="font-semibold">{{ \Carbon\Carbon::parse(Helper::getProjectCreationDate2($main_project_id))->format('d F Y') }}</span>
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
            @if(Auth::user()->company_id == 1)
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
                    <a class="flex text-green-600" href="/project/preview/add/FeedbackOrProjectType/{{ $main_project_id }}">
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
                    <a class="flex text-red-600" href="/project/preview/delete/{{ $main_project_id }}"
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

        <br>

        @if($show_logo == 1)
            <div class="flex row justify-center clientMobileLogo py-2 mb-2">
                <?php $logo_path = Helper::getLogoForPreview($logo_id); ?>
                <img src="{{ asset($logo_path) }}" class="py-3"
                    alt="clientLogo" style="width: 150px; margin: 0 auto;">
            </div>
        @endif

        <div id="showcase-section" class="mx-auto container mt-2">
            <div class="flex row">
                <div class="version-blank-space" style="width: 200px;"></div>
                <div style="flex: 1;">
                    <div class="versions" style="display: flex; justify-content: center; flex-direction: row;"></div>
                </div>
            </div>
            <div id="showcase">
                @include('newpreview.feedback-part-v2')
            </div>
        </div>

        <br>
        <footer class="footer">
            <div class="container mx-auto px-4 py-4 text-white text-center">&copy; All Right Reserved. <a
                    href="{{ Helper::getCompanyWebsite($info->uploaded_by_company_id) }}" target="_blank"
                    style="text-decoration: underline;">{{ Helper::getTitle($info->uploaded_by_company_id) }}</a>
                - <?= Date('Y') ?></div>
        </footer>
    </main>
</body>

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
