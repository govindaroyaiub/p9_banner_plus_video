@extends('layouts.app')


@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/5 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Add Video Project</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST" action="/project/video-showcase/add"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label class="text-primary font-light block">Project Name</label>
                    <input type='text' placeholder="Enter Project Name" name="project_name"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2">
                    <label class="text-primary font-light block">Client Name</label>
                    <input type='text' placeholder="Enter Client Name" name="client_name"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />

                </div>

                <div class="flex items-center mb-2">
                    <input type="checkbox" id="additional_info" class="h-4 w-4 text-gray-700 border rounded mr-2">
                    <label for="additional_info_text">Show Additional Info</label>
                </div>

                <div class="mb-2 hidden" id="feedback_round_title">
                    <label class="text-primary font-light block">Feedback Round Title</label>
                    <input type='text' placeholder="Feedback Round 1 (Master Development)" name="feedback_name" value="Feedback Round 1 (Master Development)"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2 hidden" id="feedback_description">
                    <label class="text-primary font-light block">Feedback Description</label>
                    <input type='text' placeholder="Master Development Started" name="feedback_description" value="Master Development Started"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2 hidden" id="category_name">
                    <label class="text-primary font-light block">Category Name</label>
                    <input type='text' placeholder="Default" name="category_name" value="Default"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                <div class="mb-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-primary font-light block">Select Logo/Company</label>
                            <small class="text-xs text-red-500">(Default selected: PlanetNine)</small>
                            <select name="logo_id" id="logo_id"
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                                <option value="0" class="py-2">Select Option</option>
                                @foreach($logo_list as $logo)
                                <option value="{{ $logo->id }}" @if(Auth::user()->company_id == $logo->id) selected
                                    @endif class="py-2">{{ $logo->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-primary font-light block">Show Footer?</label>
                            <small class="text-xs text-red-500">(Only for Planetnine Footer will show)</small>
                            <select name="is_footer" id="is_footer"
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                                <option value="1" class="py-2">YES</option>
                                <option value="2" class="py-2">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                    @else
                    <input type="hidden" name="logo_id" id="logo_id" value="{{ Auth::user()->company_id }}">
                    <input type="hidden" name="color" id="color" value="{{ $color }}">
                @endif

                <hr>
                <br>
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
    @section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#additional_info').change(function (){
                if($("#additional_info").is(':checked')){
                    // Code in the case checkbox is checked.
                    document.getElementById("category_name").style.display = 'block';
                    document.getElementById("feedback_round_title").style.display = 'block';
                    document.getElementById("feedback_description").style.display = 'block';
                } else {
                    // Code in the case checkbox is NOT checked.
                    document.getElementById("category_name").style.display = 'none';
                    document.getElementById("feedback_round_title").style.display = 'none';
                    document.getElementById("feedback_description").style.display = 'none';
                }
            });

            $("#logo_id").change(function() {
                let value = $('#logo_id').val();
                if(value != 1){
                    $("#is_footer").val('2');
                }
                else{
                    $("#is_footer").val('1');
                }
            });
        });
    </script>
    @endsection
