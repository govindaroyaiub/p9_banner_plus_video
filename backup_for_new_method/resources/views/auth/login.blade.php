@extends('layouts.app')

@section('content')

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white shadow-sm p-3 max-w-md mx-auto rounded-lg">
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
                           name="password" required
                           autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                </div>

                <div class="mb-4">
                    <input type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="bg-primary px-3 py-2 text-white w-full rounded-lg">
                    {{ __('Login') }}
                </button>

                
            </form>
        </div>
    </div>

@endsection
