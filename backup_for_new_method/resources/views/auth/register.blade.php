@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white shadow-sm p-3 max-w-md mx-auto rounded-lg">
            <h3 class="text-2xl font-bold text-center mb-1">{{ __('Register') }}</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="font-semibold mb-2 block">{{ __('Name') }}</label>

                    <input id="name" type="text"
                           class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email"
                           class="font-semibold mb-2 block">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email"
                           class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password"
                           class="font-semibold mb-2 block">{{ __('Password') }}</label>

                    <input id="password" type="password"
                           class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg @error('password') is-invalid @enderror"
                           name="password"
                           required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm"
                           class="font-semibold mb-2 block">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password"
                           class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-primary rounded-lg"
                           name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="bg-primary px-3 py-2 text-white rounded-lg mt-1 w-full">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>
@endsection
