@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        @if (session('status'))
            <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="md:flex -mx-4">
            @include('sidebar')
            <div class="md:w-3/4 mx-4">
                @include('alert')
                <div class="md:grid grid-cols-4 gap-8 mt-4">
                    <div class="mb-4 md:mb-0 bg-blue-400 p-2 rounded-lg text-center shadow-sm">
                        <h3 class="text-gray-800 text-2xl">Total Banners</h3>
                        <h2 class="text-blue-800 text-3xl font-bold">{{ $total_banners }}</h2>
                    </div>
                    <div class="mb-4 md:mb-0 bg-green-400 p-2 rounded-lg text-center shadow-sm">
                        <h3 class="text-gray-800 text-2xl">Total Videos</h3>
                        <h2 class="text-green-800 text-3xl font-bold">{{ $total_videos }}</h2>
                    </div>
                    <div class="mb-4 md:mb-0 bg-purple-600 p-2 rounded-lg text-center shadow-sm">
                        <h3 class="text-gray-800 text-2xl">Total Video Space</h3>
                        <h2 class="text-blue-800 text-3xl font-bold">{{ $total_number }}</h2>
                    </div>
                    <div class="mb-4 md:mb-0 bg-red-400 p-2 rounded-lg text-center shadow-sm">
                        <h3 class="text-gray-800 text-2xl">Total Comments</h3>
                        <h2 class="text-red-800 text-3xl font-bold">{{ $total_comments }}</h2>
                    </div>
                </div>
                <br>
                <br>
                <div class="flex justify-between w-full">
                    <h3 class="text-xl font-semibold tracking-wide">Users</h3>
                    @if(Auth::user()->is_admin == 1)
                    <a href="/user/add">
                        <button type="button"
                            class="leading-tight mb-4 md:mb-0 bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white">Add
                            User</Button>
                    </a>
                    @endif
                </div>
                <br>
                <table id="datatable" class="stripe hover table w-full" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                    <tr>
                        <th class="bg-gray-200 px-4 py-2">No.</th>
                        <th class="bg-gray-200 px-4 py-2">Name</th>
                        <th class="bg-gray-200 px-4 py-2">Email</th>
                        <th class="bg-gray-200 px-4 py-2">Status</th>
                        @if(url('/') == 'http://localhost:8000')
                        <th class="bg-gray-200 px-4 py-2">Company</th>
                        @endif
                        @if(Auth::user()->is_admin == 1)
                        <th class="bg-gray-200 px-4 py-2">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                    @foreach($user_list as $user)
                        <tr style="text-align: center;">
                            <td class="border px-4 py-2">{{$i++}}</td>
                            <td class="border px-4 py-2">{{ $user->username }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            @if($user->is_admin == 1)
                            <td class="border px-4 py-2">Admin</td>
                            @else
                            <td class="border px-4 py-2">User</td>
                            @endif
                            @if(url('/') == 'http://localhost:8000')
                            <td class="border px-4 py-2">{{ $user->logoname }}</td>
                            @endif
                            @if(Auth::user()->is_admin == 1)
                            <td class="border px-4 py-2">
                            <a href="/user/edit/{{$user->id}}">
                                <button type="button"
                                    class="bg-blue-600 text-gray-900 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="/user/delete/{{$user->id}}">
                                <button type="button"
                                    class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
