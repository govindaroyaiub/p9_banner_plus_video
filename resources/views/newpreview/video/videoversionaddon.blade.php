@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mt-2">Add Video To Version</h3>
            <br>

            <h3 class="text-xl font-semibold tracking-wide" style="color: red;">Inserting Banners into {{ $feedback['name'] }} > {{ $version['name'] }}</h3>
            <br>

            <form id="project-add-form" class="max-w-xl" method="POST"
                action="/project/preview/video/add/version/{{ $version_id }}" enctype="multipart/form-data">
                @csrf
                {{-- Drag and Drop --}}
                <div>
                    <label class="text-primary font-light block">Select Option to Upload</label>
                    <select name="version_request" id="version_request" required
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                        <option value="0" class="py-2">Select Option</option>
                        <option value="1" class="py-2">Upload to Existing</option>
                        <option value="2" class="py-2">Add as New version</option>
                    </select>
                </div>

                <input type='text' placeholder="Version {{ $versionCount++ }}" name="version_name" value="Version {{ $versionCount++ }}" id="version_name"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary hidden"
                required/>

                <span style="color: red;">Video Upload Area</span>
                <div class="mb-2">
                    <label class="text-primary font-light block">Video Title (example: Pre-Roll/Bumper Interstitial
                        for
                        Youtube)</label>
                    <input type='text' placeholder="Enter Video Title" name="video_title" value="Demo Video Title"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2">
                    <label class="text-primary font-light block">Advertising Format</label>
                    <select name="video_size_id" id="video_size_id" required
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                        <option value="">Select Option</option>
                        @foreach($video_sizes as $size)
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
                    <input type='text' placeholder="Enter Aspect Ratio" name="aspect_ratio" id="aspect_ratio" value="16:9"
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

                {{-- Drag and Drop --}}

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        ADD
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
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"
    integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    $(document).ready(function () {
        $('#version_request').change(function(){
            var value = $(this).val();
            if(value == 2){
                document.getElementById('version_name').style.display = "block";
            }
            else{
                document.getElementById('version_name').style.display = "none";
            }
        });
    });

</script>
