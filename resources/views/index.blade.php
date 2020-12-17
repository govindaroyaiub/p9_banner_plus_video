<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planet Nine Video Previewer</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
</head>

<body class="font-body">
<header class="header relative border-b border-primary">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div>
            <h3>Client Name: <span class="font-semibold">De Media Maatschap</span></h3>
            <h3>Project Name: <span class="font-semibold">DMM - James Autoservice</span></h3>
        </div>

        <div class="flex">
            <img src="{{ asset('/images/logo.png') }}" alt="Planet Nine" class="w-32 flex-none mr-4"/>
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

                    <p class="my-4">If you like this video feel free to feedback us!</p>

                    <form action="">
                            <textarea name="comment" id="comment" cols="5" rows="5"
                                      class="w-full border border-gray-600 focus:outline-none rounded-lg"></textarea>
                        <button type="submit" class="bg-primary px-4 py-2 rounded-lg w-full text-white mt-2">Submit
                            Comment!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container mx-auto px-4 py-10">
        <div class="flex -mx-8 mb-10">
            <div class="w-3/4 mx-8">
                <div class="videos">
                    <h2 class="text-xl font-semibold mb-4">
                        Pre-Roll/Bumper Interstitial for Youtube
                    </h2>

                    <div class="video-container aspect-ratio-16-9">
                        <video class="video" playsinline controls data-poster="poster.jpg" width="560" height="315">
                            <source src="{{ asset('/videos/1920X1080.mp4') }}" type="video/mp4"/>
                        </video>
                    </div>
                    <a href="{{ asset('/videos/1920X1080.mp4') }}" class="color-primary underline flex mt-4"
                       download>Download Video
                        <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="w-1/4 mx-8">
                <h2 class="text-xl font-semibold mb-8">Specifications:</h2>
                <table class="table w-full">
                    <tbody>
                    <tr>
                        <td>Aspect:</td>
                        <td>16:9</td>
                    </tr>
                    <tr>
                        <td>Codec:</td>
                        <td>H264</td>
                    </tr>
                    <tr>
                        <td>Framerate:</td>
                        <td>30 FPS</td>
                    </tr>
                    <tr>
                        <td>Size:</td>
                        <td>28 MB</td>
                    </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <div class="companion-banner">
                        <h2 class="text-xl font-semibold mb-4">Companion Banner 300x60</h2>

                        <img class="block" src="{{ '/images/companion-banner.png'  }}" alt="companion banner">

                        <a href="{{ '/images/companion-banner.png'  }}" class="color-primary underline flex mt-2"
                           download>Download
                            <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex -mx-8 my-24">
            <div class="w-3/4 mx-8">
                <div class="videos">
                    <div class="flex">
                        <div class="w-2/4">
                            <div class="video-container aspect-ratio-1-1">
                                <video class="video" playsinline controls data-poster="poster.jpg" width="560"
                                       height="100">
                                    <source src="{{ asset('/videos/1080X1080.mp4') }}" type="video/mp4"/>
                                </video>
                            </div>
                            <a href="{{ asset('/videos/1080X1080.mp4') }}" class="color-primary underline flex mt-4"
                               download>Download Video
                                <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/4 mx-8">
                <h2 class="text-xl font-semibold mb-8">Specifications:</h2>

                <table class="table w-full">
                    <tbody>
                    <tr>
                        <td>Aspect:</td>
                        <td>1:1</td>
                    </tr>
                    <tr>
                        <td>Codec:</td>
                        <td>H264</td>
                    </tr>
                    <tr>
                        <td>Framerate:</td>
                        <td>30 FPS</td>
                    </tr>
                    <tr>
                        <td>Size:</td>
                        <td>28 MB</td>
                    </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <div class="companion-banner">
                        <h2 class="text-xl font-semibold mb-4">Companion Banner 300x60</h2>

                        <img class="block" src="{{ '/images/companion-banner.png'  }}" alt="companion banner">

                        <a href="{{ '/images/companion-banner.png'  }}" class="color-primary underline flex mt-2"
                           download>Download
                            <svg class="w-6 h-6 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="footer bg-primary">
    <div class="container mx-auto px-4 py-3 text-white text-center">&copy; All Right Reserved. Planet Nine
        - <?= Date('Y') ?></div>
</footer>

<script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
