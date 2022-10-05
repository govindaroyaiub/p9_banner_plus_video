@extends('layouts.app')


@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/5 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Add Video</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST" action="/video/add/feedback/{{ $project_id }}/{{ $feedback_id }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="text-primary font-light block">Video Title (example: Pre-Roll/Bumper Interstitial
                        for
                        Youtube)</label>
                    <input type='text' placeholder="Enter Video Title" name="title"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2">
                    <label class="text-primary font-light block">Advertising Format</label>
                    <select name="size_id" id="size_id"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required>
                        <option value="0" class="py-2">Select Size</option>
                        @foreach($size_list as $size)
                        <option value="{{ $size->id }}" class="py-2">{{ $size->name }} - {{ $size->width }}x{{ $size->height }}
                        </option>
                        @endforeach
                    </select>
                    <br>
                        <label class="text-primary font-light block mb-3"> If the required size is not listed, Click <a href="/sizes" class="text-red-500" target="_blank">Here</a></label>
                </div>
                <br>

                <div class="flex space-x-2">
                    <input type='text' placeholder="Enter Codec" name="codec" value="H264"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio" id="aspect_ratio"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />

                    <input type='text' placeholder="Enter Frame Per Second" name="fps" value="30 FPS"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div
                    class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Video File Here or Click to Upload</span>
                    <input type="file" name="video" class="drop-zone__input hidden">
                </div>
                <br>
                <div
                    class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Poster Image here or Click to Upload (Optional)</span>
                    <input type="file" name="poster" class="drop-zone__input hidden">
                </div>
                <br>

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-indigo-700 text-gray-200 text-lg rounded hover:bg-indigo-500 px-6 py-2 focus:outline-none">
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
