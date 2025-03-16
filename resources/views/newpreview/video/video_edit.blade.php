@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Edit Video</h3>
            <h3 class="text-xl font-semibold tracking-wide text-red-500">** Just Edit What You Need to Edit Or Replace The Video **</h3>
            <br>
            <form method="POST" action="/project/preview/video/edit/{{ $sub_project_id }}" enctype="multipart/form-data" class="max-w-4xl" style="width: 100%;">
                @csrf
                <div class="mb-2">
                    <label class="text-primary font-bold">Video Title (example: Pre-Roll/Bumper Interstitial for Youtube)</label><br>
                    <input type='text' placeholder="Enter Video Title" name="title" value="{{ $sub_project_info['title'] }}"
                        class="w-full mt-2 mb-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                </div>
                
                <div class="mb-2">
                    <label class="text-primary font-bold">Advertising Format</label><br>
                    <select name="video_size_id"
                        class="w-full mt-2 mb-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" id="video_size_id" required>
                        <option value="" class="py-2">Select Size</option>
                        @foreach($size_list as $size)
                        <option value="{{ $size->id }}" @if($sub_project_info['size_id'] == $size->id) selected @else '' @endif) class="py-2">{{ $size->name }} (
                            {{ $size->width }}x{{ $size->height }} )</option>
                        @endforeach
                    </select>
                </div>
            
                <label class="text-primary font-bold block mb-2"> If the required size is not listed, Click <a href="/sizes" class="text-red-500" target="_blank">Here</a></label>

                <div class="flex space-x-2">
                    <input type='text' placeholder="Enter Codec" name="codec" value="{{ $sub_project_info['codec'] }}"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio" id="aspect_ratio" value="{{ $sub_project_info['aspect_ratio'] }}"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />

                    <input type='text' placeholder="Enter Frame Per Second" name="fps" value="{{ $sub_project_info['fps'] }}"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div
                    class="drop-zone border-2 mb-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Video File Here or Click to Upload</span>
                    <input type="file" name="video" class="drop-zone__input hidden">
                </div>
                <div
                    class="drop-zone border-2 mb-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Poster Image here or Click to Upload (Optional)</span>
                    <input type="file" name="poster" class="drop-zone__input hidden">
                </div>

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        SAVE
                    </button>
                    <button type="button" onclick="window.history.back()"
                        class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        BACK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
