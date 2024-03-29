@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex -mx-4">
            @include('sidebar')
            <div class="w-3/5 mx-4">
                @include('alert')
                <h3 class="text-xl font-semibold tracking-wide mb-4">Add GIF Project</h3>
                <br>
                <form id="project-add-form" class="max-w-xl" method="POST" action="/project/gif/add"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="text-primary font-light block">Project Name</label>
                        <input type='text' placeholder="Enter Project Name" name="project_name"
                               class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>
                    </div>

                    <div class="mb-4">
                        <label class="text-primary font-light block">Client Name</label>
                        <input type='text' placeholder="Enter Client Name" name="client_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>
                    </div>
                    
                    @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-primary font-light block mb-3">Select Logo/Company</label>
                                <select name="logo_id" id="logo_id"
                                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                                    <option value="0" class="py-2">Select Option</option>
                                    @foreach($logo_list as $logo)
                                        <option value="{{ $logo->id }}" @if(Auth::user()->company_id == $logo->id) selected @endif class="py-2">{{ $logo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-primary font-light block">Select Color</label>
                                <small class="text-xs text-red-500">(Default selected Color is PlanetNine Logo
                                    Color)</small>
                                <input type='color' name="color" value="{{ $color }}"
                                       class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg" required/>
                            </div>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="logo_id" id="logo_id" value="{{ Auth::user()->company_id }}">
                    <input type="hidden" name="color" id="color" value="{{ $color }}">
                    @endif

                    <div class="mb-4">
                        <label class="text-primary font-light block mb-3">Select GIF Width x Height</label>
                        <select name="banner_size_id"
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                                id="banner_size_id">
                            <option value="0" class="py-2">Select Option</option>
                            @foreach($size_list as $size)
                                <option value="{{ $size->id }}" class="py-2">{{ $size->width }}x{{ $size->height }}</option>
                            @endforeach
                        </select>
                        <br>
                        <label class="text-primary font-light block mb-3"> If the required size is not listed, Click <a href="/banner_sizes" class="text-red-500" target="_blank">Here</a></label>
                    </div>
                    <br>

                    {{-- Drag and Drop --}}
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <span class="drop-zone__prompt">Drop GIF File Here or Click to Upload</span>
                        <input type="file" name="upload" class="drop-zone__input hidden">
                    </div>
                    {{-- Drag and Drop --}}

                    <div class="flex space-x-4 mt-4">
                        <button type="submit"
                                class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                            CREATE
                        </button>
                        <button type="button" onclick="window.history.back()"
                                class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                            BACK
                        </button>
                    </div>

                </form>
            </div>
        </div>
@endsection



