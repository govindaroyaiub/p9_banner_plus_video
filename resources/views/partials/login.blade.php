{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<style>
    .focus\:border-primary:focus {
        --border-opacity: 1;
        border-color: {{ $project_color }};
    }

    .header {
            position: relative;
            height: 100vh;
            background: linear-gradient(60deg, rgb(183, 58, 79) 0%, rgb(35, 0, 193) 100%);
        }
        .inner-header {
            width: 100%;
            padding-top: 2rem;
            margin: 0;
        }

        .waves-w{
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .waves {
            width: 100%;
            height: 100%;
            margin-bottom: -7px;
            /*Fix for safari gap*/
            min-height: 100px;
            max-height: 150px;
        }

        /* Animation */

        .parallax>use {
            animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }

        .parallax>use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax>use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax>use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax>use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px, 0, 0);
            }

            100% {
                transform: translate3d(85px, 0, 0);
            }
        }

        /*Shrinking for mobile*/
        @media (max-width: 768px) {
            .waves {
                height: 40px;
                min-height: 40px;
            }
        }
</style>

<div class="header">
    <div class="inner-header">
        <div class="bg-white shadow-sm p-3 max-w-md mx-auto rounded-lg" style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%); border-radius: 8px;">
    
            <h3 class="text-2xl font-bold text-center mb-1">{{ __('Login') }}</h3>
            @include('alert')
            <div class="relative shadow hidden" id="error_section">
                <h1 class=" text-red-700 text-center py-3 mt-2 underline">Opps! The credentials do not match. Please try again</h1>
                {{-- <img src="{{ asset('/logo_images/error.gif') }}" alt="errorGif" id="errorGif" style="margin-left: auto; margin-right: auto; width: 100%;"> --}}
            </div>
            <br>
            
            <form action="" id="axiosLogin" name="axiosLogin">
                <div class="mb-4">
                    <label for="email" class="font-semibold mb-2 block">E-Mail Address</label>
                    <input id="email" type="email"
                        class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="font-semibold mb-2 block">Password</label>
                    <input id="password" type="password"
                        class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg"
                        name="password" required autocomplete="current-password">
                </div>

                <button type="submit" class="px-3 py-2 text-white w-full rounded-lg"
                    style="background-color: {{ $project_color }};">
                    Login
                </button>
            </form>
        </div>
    </div>
    <div class="waves-w">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#password').on('input',function(e){
            let passwordValue = $('#password').val();

            if(passwordValue == 0){
                document.getElementById('error_section').style.display = 'none';
            }
        });

        $("#axiosLogin").submit(function (e) {
            var data = new FormData();
            data.append('email', document.getElementById('email').value);
            data.append('password', document.getElementById('password').value);
            e.preventDefault();

            console.log(email + " " + password);
            axios({
                method: 'post',
                url: "{{ route('doLogin') }}",
                data: data,
                headers: {
                    'Content-Type': `multipart/form-data; boundary=${data._boundary}`,
                }
            })
            .then(response => {
               if(response){
                //if the login is success on ajax request then the page will reload 
                //and show the main content since the logic of Auth::user is already there
                location.reload();
               }
            })
            .catch(function (error) {
                document.getElementById('error_section').style.display = 'block';
                console.log(error);
            });
        });
    });

</script>
