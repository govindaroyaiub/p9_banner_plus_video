<script src="https://cdn.tailwindcss.com"></script>
<div id="authentication-modal" tabindex="-1" aria-hidden="true"
    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full login-part"
    style="background: white;">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto" style="margin: 0 auto;">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="py-6 px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-center mb-1">{{ __('Login') }}</h3>
                @include('alert')
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="font-semibold mb-2 block">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email"
                            class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="font-semibold mb-2 block">{{ __('Password') }}</label>


                        <input id="password" type="password"
                            class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <button type="submit" class="bg-primary px-3 py-2 text-white w-full rounded-lg" style="background-color: #4b4e6d;">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
