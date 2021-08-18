@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Update <b>{{ $user_info['name'] }}</b></h3>
            <br>
            <form class="max-w-lg" method="POST" action="/user/edit/{{$id}}" enctype="multipart/form-data">
                @csrf
                <input type='text' placeholder="Enter User Name" name="name" value="{{ $user_info['name'] }}"
                    class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                    required />

                <input type='text' placeholder="Enter Email Address" name="email" value="{{ $user_info['email'] }}"
                    class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                    required />

                @if(url('/') == 'http://localhost:8000')
                <label class="text-primary font-light">Select User Company</label><br>
                <select
                    class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                    name="company_id" id="company_id" required>
                    <option value=" " class="py-2">Select Option</option>
                    @foreach($client_list as $client)
                    <option value="{{ $client->id }}" @if($user_info['company_id']== $client->id) selected @endif class="py-1">{{ $client->name }}</option>
                    @endforeach
                </select>
                <br>
                <br>
                @else
                <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
                @endif

                <label class="text-primary font-light">Change Admin Status</label><br>
                <select class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" name="is_admin" required>
                    <option value=" " class="py-2">Select Option</option>
                    <option value="1" class="py-1" @if($user_info['is_admin']==1) selected @endif>Admin</option>
                    <option value="0" class="py-1" @if($user_info['is_admin']==0) selected @endif>User</option>
                </select>

                <a href="/reset-password/{{ $user_info['id'] }}" onclick="return confirm('Are you sure you want to reset the password?');">
                    <button type="button"
                        class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        RESET PASSWORD
                    </button>
                </a>
                <br>
                <div class="flex space-x-4">
                    <button type="submit"
                        class="w-1/2 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        Save
                    </button>
                    <button type="button" onclick="window.history.back()"
                        class="w-1/2 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        Back
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
