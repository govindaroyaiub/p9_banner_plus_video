@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Edit Video</h3>
            <h3 class="text-xl font-semibold tracking-wide text-red-500">Just Edit What You Need to Edit Or Replace The Assets</h3>
            <br>
            <form method="POST" action="/video/edit/{{ $sub_project_id }}" enctype="multipart/form-data">
                @csrf
                <label class="text-primary font-light">Video Title (example: Pre-Roll/Bumper Interstitial for Youtube)</label><br>
                <input type='text' placeholder="Enter Video Title" name="title" value="{{ $sub_project_info['title'] }}"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                    <br>
                <label class="text-primary font-light">Advertising Format</label><br>
                <select name="size_id"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required>
                    <option value="0" class="py-2">Select Size</option>
                    @foreach($size_list as $size)
                    <option value="{{ $size->id }}" @if($sub_project_info['size_id'] == $size->id) selected @else '' @endif) class="py-2">{{ $size->name }} (
                        {{ $size->width }}x{{ $size->height }} )</option>
                    @endforeach
                </select>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Codec" name="codec" value="{{ $sub_project_info['codec'] }}"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio" value="{{ $sub_project_info['aspect_ratio'] }}"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                </div>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Frame Per Second" name="fps" value="{{ $sub_project_info['fps'] }}"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                </div>

                <div>
                        <label class="text-primary font-light block">Select Companion Banner Poster  (if any)</label>
                        <div class="drag-n-drop-area relative opacity-50 border border-dashed border-primary rounded-lg w-2/3">
                            <input type="file" name="poster" class="drag-n-drop absolute mx-auto text-center" id="upload"/>
                        </div>
                    </div>

                    <div>
                        <label class="text-primary font-light block">Select Banner Video</label>
                        <div class="drag-n-drop-area relative opacity-50 border border-dashed border-primary rounded-lg w-2/3">
                            <input type="file" name="video" class="drag-n-drop absolute mx-auto text-center" id="upload"/>
                        </div>
                    </div>

                <div class="flex mb-4">
                    <button type="submit"
                        class="w-1/3 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-3 focus:outline-none">Save</button>
                    <button type="button" onclick="window.location.href='/project/view/{{ $sub_project_info['project_id'] }}';"
                        class="w-1/3 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-3 focus:outline-none">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
