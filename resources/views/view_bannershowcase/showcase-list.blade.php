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
        <div class="md:w-3/4 mx-4">
            @include('alert')
            <br>
            <div class="flex justify-between w-full">
                <h3 class="text-xl font-semibold tracking-wide">Showcase List</h3>
                <a href="/">
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
                        <th data-priority="2">Project Name</th>
                        <th data-priority="3" width="140px" max-width="160px">Client Name</th>
                        <th data-priority="4" width="110px" max-width="135px">Uploader</th>
                        <th data-priority="5" width="270px" max-width="290px">Actions</th>
                    </tr>
                </thead>
                <?php $i=1; ?>
                <tbody>
                    <tr style="text-align: center;">
                        <td class="border px-4 py-2">{{ $i++ }}</td>
                        <td class="border px-4 py-2">
                            
                        </td>
                        <td class="border px-4 py-2" width="140px" max-width="160px"></td>
                        <td class="border px-4 py-2" width="110px" max-width="135px" style="font-size: 15px;">
                            <label class="text-red-500 font-semibold"></label>
                            <hr>
                            <label class="text-red-500 font-semibold"></label>
                        </td>
                        <td class="border px-4 py-2"  width="270px" max-width="290px">
                            <a href="/">
                                <button type="button"
                                    class="bg-indigo-600 text-gray-200 rounded hover:bg-indigo-500 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </a>
                            <a href="/" target="_blank">
                                <button type="button"
                                    class="bg-green-500 text-gray-200 rounded hover:bg-green-400 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </a>
                        
                            <a href="/">
                                <button type="button"
                                    class="bg-blue-600 text-gray-900 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </a>

                            <a href="/" onclick="return confirm('Are you sure you want to delete this project?');">
                                <button type="button"
                                    class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
