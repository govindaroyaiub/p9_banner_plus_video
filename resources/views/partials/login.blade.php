{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<style>
    .focus\:border-primary:focus {
        --border-opacity: 1;
        border-color: {{ $project_color }};
    }
</style>

<div id="authentication-modal" tabindex="-1" aria-hidden="true"
    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full login-part"
    style="background: white;">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto" style="margin: 0 auto;">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <div class="py-6 px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-center mb-1">Login</h3>
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
        {{-- <div class="relative shadow hidden" id="error_section">
            <h1 class=" text-red-700 text-center py-3 mt-2 underline">Opps! The credentials do not match. Please try again</h1>
            <img src="{{ asset('/logo_images/error.gif') }}" alt="errorGif" id="errorGif" style="margin-left: auto; margin-right: auto; width: 100%;">
        </div> --}}
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
