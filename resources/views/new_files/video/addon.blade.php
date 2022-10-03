@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Add Video</h3>
            <br>
            <form method="POST" action="/project/video-showcase/addon/{{ $main_project_id }}"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="text-primary font-light block">Select Option to Upload</label>
                    <select name="feedback_request" id="feedback_request" required
                        class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                        <option value="0" class="py-2">Select Option</option>
                        @if($feedbackCount <= 1) 
                        <option value="1" class="py-2">Upload to Existing Preview</option>
                        @endif
                        @if($feedbackCount >= 1)
                        <option value="2" class="py-2">Create New Feedback</option>
                        @endif
                    </select>
                </div>

                <input type='text' placeholder="Feedback Round {{ $feedbackCount++ }}" name="feedback_name"
                    value="Feedback Round {{ $feedbackCount++ }}" id="feedback_name"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary hidden"
                    required />

                <textarea placeholder="new feedbacks implemented" name="feedback_description" id="feedback_description"
                    rows="4"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary hidden"
                    required>The following feedbacks are implemented:</textarea>

                <label class="text-primary font-light">Video Title (example: Pre-Roll/Bumper Interstitial for
                    Youtube)</label><br>
                <input type='text' placeholder="Enter Video Title" name="title"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                    required />
                <br>
                <label class="text-primary font-light">Advertising Format</label><br>
                <select name="size_id"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                    id="size_id" required>
                    <option value="0" class="py-2">Select Size</option>
                    @foreach($size_list as $size)
                    <option value="{{ $size->id }}" class="py-2">{{ $size->name }} (
                        {{ $size->width }}x{{ $size->height }} )</option>
                    @endforeach
                </select>
                <br>
                <label class="text-primary font-light block mb-3"> If the required size is not listed, Click <a
                        href="/sizes" class="text-red-500" target="_blank">Here</a></label>
                <br>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Codec" name="codec" value="H264"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="flex mb-4">
                    <input type='text' placeholder="Enter Frame Per Second" name="fps" value="30 FPS"
                        class="w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>
                <div
                    class="w-2/3 drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <span class="drop-zone__prompt">Drop Video File Here or Click to Upload</span>
                    <input type="file" name="video" class="drop-zone__input hidden">
                </div>
                <br>
                <div
                    class="w-2/3 drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
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
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#feedback_request').change(function(){
            var value = $(this).val();
            if(value == 2){
                document.getElementById('feedback_name').style.display = "block";
                document.getElementById('feedback_description').style.display = "block";
            }
            else{
                document.getElementById('feedback_name').style.display = "none";
                document.getElementById('feedback_description').style.display = "none";
            }
        });
    });
</script>