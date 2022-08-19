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
            <br>
            <div class="flex justify-between w-full">
                <h3 class="text-xl font-semibold tracking-wide">Logos</h3>
                <a href="/logo/add">
                    <button type="button"
                        class="leading-tight bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </a>
            </div>
            <br>
            <table id="datatable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th data-priority="1">No</th>
                        <th data-priority="2">Name</th>
                        <th data-priority="3">URLs</th>
                        <th data-priority="4">Favicon</th>
                        <th data-priority="5">Default Color</th>
                        <th data-priority="6">Actions</th>
                    </tr>
                </thead>
                <?php $i=1; ?>
                <tbody>
                @foreach($logo_list as $logo)
                    <tr align="center">
                        <td class="border px-4 py-2">{{ $i++ }}</td>
                        <td class="border px-4 py-2" width="150px">
                            {{ $logo->name }}
                            <hr>
                            <img src="{{url('/logo_images/').'/'.$logo->path}}" class="py-2">
                        </td>
                        <td class="border px-4 py-2">
                            Preview: <a href="{{ $logo->website }}" target="_blank" style="color:#4299e1; text-decoration: underline;">{{ $logo->website }}</a>
                            <hr>
                            Website: <a href="{{ $logo->company_website }}" target="_blank" style="color:#4299e1; text-decoration: underline;">{{ $logo->company_website }}</a>
                        </td>
                        <td class="border px-4 py-2">
                            <img src="{{ Helper::getFavicon($logo->id) }}">
                        </td>
                        <td class="border px-4 py-2">
                            <div style="position: relative; width: 60px; height: 40px; background: {{ $logo->default_color }};"></div>
                            <input type="text" value="{{ $logo->default_color }}" style="width: 80px;" id="color_code" readonly>
                        </td>
                        <td class="border px-4 py-2">
                            <div style="display: flex; width: 135px; margin: 0 auto;">
                                <a href="/logo/edit/{{$logo->id}}">
                                    <button type="button"
                                        class="bg-blue-600 text-gray-900 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
                                <br>
                                <a href="/logo/delete/{{$logo->id}}" onclick="return confirm('Are you sure you want to delete this logo?');" class="px-4">
                                    <button type="button"
                                        class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
