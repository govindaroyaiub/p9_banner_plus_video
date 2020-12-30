@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Add Video</h3>
            <br>
            <form method="POST" action="/project/video/addon/{{ $main_project_id }}" enctype="multipart/form-data">
                @csrf
                <label class="text-primary font-light">Video Title (example: Pre-Roll/Bumper Interstitial for Youtube)</label><br>
                <input type='text' placeholder="Enter Video Title" name="title"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                    <br>
                <label class="text-primary font-light">Advertising Format</label><br>
                <select name="size_id"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required>
                    <option value="0" class="py-2">Select Size</option>
                    @foreach($size_list as $size)
                    <option value="{{ $size->id }}" class="py-2">{{ $size->name }} (
                        {{ $size->width }}x{{ $size->height }} )</option>
                    @endforeach
                </select>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Codec" name="codec"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                </div>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Frame Per Second" name="fps"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                </div>
                <div
                    class="w-2/3 drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Video File Here or Click to Upload</span>
                    <input type="file" name="video" class="drop-zone__input hidden">
                </div>
                <br>
                <div class="w-2/3 drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Poster Image here or Click to Upload (Optional)</span>
                    <input type="file" name="poster" class="drop-zone__input hidden">
                </div>
                
                <br>

                <div class="flex mb-4">
                    <button type="submit"
                        class="w-1/3 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-3 focus:outline-none">ADD</button>
                    <button type="button" onclick="window.history.back()"
                        class="w-1/3 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-3 focus:outline-none">BACK</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
