@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/5 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Add Preview Project</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST" action="/project/preview/add"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="text-primary font-bold block">Project Name</label>
                    <small class="text-x text-red-500">(Please refrain from using special type characters: * / ? ~ ! % etc)</small>
                    <input type='text' placeholder="Enter Project Name" name="project_name"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4">
                    <label class="text-primary font-bold block">Client Name</label>
                    <input type='text' placeholder="Enter Client Name" name="client_name"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4">
                    <div>
                        <label class="text-primary font-bold block">Select Project Type</label>
                        <select name="project_type" id="project_type" required
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                            <option value="">Select Option</option>
                            <option value="1">Banner</option>
                            <option value="2">Video</option>
                            <option value="3">Gif</option>
                            <option value="4">Social Image</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center mb-4">
                    <input type="checkbox" id="additional_info" class="h-4 w-4 text-gray-700 border rounded mr-2">
                    <label for="additional_info_text">Show Additional Info</label>
                </div>

                <div class="mb-4 hidden" id="feedback_round_title">
                    <label class="text-primary font-bold block">Feedback Round Title</label>
                    <input type='text' placeholder="Master Creative" name="feedback_name" value="Master Creative"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4 hidden" id="feedback_description">
                    <label class="text-primary font-bold block">Feedback Description</label>
                    <input type='text' placeholder="Master Development Started" name="feedback_description" value="Master Development Started"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4 hidden" id="version_name">
                    <label class="text-primary font-bold block">Version Name</label>
                    <input type='text' placeholder="Default" name="version_name" value="Default"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                <div class="mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-primary font-bold block">Select Logo/Company</label>
                            <small class="text-xs text-red-500">(Default selected: PlanetNine)</small>
                            <select name="logo_id" id="logo_id"
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                                <option value="0">Select Option</option>
                                @foreach($logo_list as $logo)
                                <option value="{{ $logo->id }}" @if(Auth::user()->company_id == $logo->id) selected
                                    @endif class="py-2">{{ $logo->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-primary font-bold block">Show Footer?</label>
                            <small class="text-xs text-red-500">(Only for Planetnine Footer will show)</small>
                            <select name="is_footer" id="is_footer" required
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                                <option value="0">Select Option</option>
                                <option value="1" selected>YES</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                @else
                    <input type="hidden" name="logo_id" id="logo_id" value="{{ Auth::user()->company_id }}">
                    <input type="hidden" name="color" id="color" value="{{ $color }}">
                @endif

                <div id="banner-upload-area" class="hidden">
                    <span style="color: red;">Banner Upload Area</span>
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <input name="bannerupload[]" id="bannerupload" type="file" multiple="multiple" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">
                    </div>

                    <div id="fileDisplaySection" style="display: none;">
                        <br>
                        <div class="bg-white rounded-lg shadow-lg py-6">
                            <div class="block overflow-x-auto mx-6">
                                <table class="w-full text-center rounded-lg">
                                    <thead>
                                        <tr class="text-gray-800 border border-b-0">
                                            <th class="px-4 py-3">#</th>
                                            <th class="px-4 py-3">File Name</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;" id="fileTable">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="video-upload-area" class="hidden">
                    <span style="color: red;">Video Upload Area</span>
                    <div class="mb-2">
                        <label class="text-primary font-bold block">Video Title (example: Pre-Roll/Bumper Interstitial
                            for
                            Youtube)</label>
                        <input type='text' placeholder="Enter Video Title" name="video_title" value="Demo Video Title"
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                            required />
                    </div>
    
                    <div class="mb-2">
                        <label class="text-primary font-bold block">Advertising Format</label>
                        <select name="video_size_id" id="video_size_id" required
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                            <option value="0">Select Option</option>
                            @foreach($video_sizes as $size)
                            <option value="{{ $size->id }}" class="py-2">{{ $size->name }} - {{ $size->width }}x{{ $size->height }}
                            </option>
                            @endforeach
                        </select>
                        <br>
                            <label class="text-primary font-bold block mb-3"> If the required size is not listed, Click <a href="/sizes" class="text-red-500" target="_blank">Here</a></label>
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
                </div>

                <div id="gif-upload-area" class="hidden">
                    <span style="color: red;">Gif Upload Area</span>
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <input name="gifupload[]" id="gifupload" type="file" multiple="multiple" accept="gif">
                    </div>

                    <div id="gifDisplaySection" style="display: none;">
                        <br>
                        <div class="bg-white rounded-lg shadow-lg py-6">
                            <div class="block overflow-x-auto mx-6">
                                <table class="w-full text-left rounded-lg">
                                    <thead>
                                        <tr class="text-gray-800 border border-b-0">
                                            <th class="px-4 py-3">#</th>
                                            <th class="px-4 py-3">File Name</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;" id="gifFileTable">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="social-upload-area" class="hidden">
                    <span style="color: red;">Social Upload Area</span>
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <input name="socialupload[]" id="socialupload" type="file" multiple="multiple" accept="image/*">
                    </div>

                    <div id="socialDisplaySection" style="display: none;">
                        <br>
                        <div class="bg-white rounded-lg shadow-lg py-6">
                            <div class="block overflow-x-auto mx-6">
                                <table class="w-full text-left rounded-lg">
                                    <thead>
                                        <tr class="text-gray-800 border border-b-0">
                                            <th class="px-4 py-3">#</th>
                                            <th class="px-4 py-3">File Name</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;" id="socialFileTable">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


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



    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"
        integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            $('#additional_info').change(function (){
                if($("#additional_info").is(':checked')){
                    // Code in the case checkbox is checked.
                    document.getElementById("version_name").style.display = 'block';
                    document.getElementById("feedback_round_title").style.display = 'block';
                    document.getElementById("feedback_description").style.display = 'block';
                } else {
                    // Code in the case checkbox is NOT checked.
                    document.getElementById("version_name").style.display = 'none';
                    document.getElementById("feedback_round_title").style.display = 'none';
                    document.getElementById("feedback_description").style.display = 'none';
                }
            });

            $('#project_type').change(function (){
                let value = $('#project_type').val();
                if(value == 1){
                    document.getElementById('banner-upload-area').style.display = 'block';
                    document.getElementById('video-upload-area').style.display = 'none';
                    document.getElementById('gif-upload-area').style.display = 'none';
                    document.getElementById('social-upload-area').style.display = 'none';
                }
                else if(value == 2){
                    document.getElementById('banner-upload-area').style.display = 'none';
                    document.getElementById('video-upload-area').style.display = 'block';
                    document.getElementById('gif-upload-area').style.display = 'none';
                    document.getElementById('social-upload-area').style.display = 'none';
                }
                else if(value == 3){
                    document.getElementById('banner-upload-area').style.display = 'none';
                    document.getElementById('video-upload-area').style.display = 'none';
                    document.getElementById('gif-upload-area').style.display = 'block';
                    document.getElementById('social-upload-area').style.display = 'none';
                }
                else if(value == 4){
                    document.getElementById('banner-upload-area').style.display = 'none';
                    document.getElementById('video-upload-area').style.display = 'none';
                    document.getElementById('gif-upload-area').style.display = 'none';
                    document.getElementById('social-upload-area').style.display = 'block';
                }
                else{
                    document.getElementById('banner-upload-area').style.display = 'none';
                    document.getElementById('video-upload-area').style.display = 'none';
                    document.getElementById('gif-upload-area').style.display = 'none';
                    document.getElementById('social-upload-area').style.display = 'none';
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

            $("#bannerupload").change(function() {
                var rows = '';
                var select = '';
                var rowNumber = 1;
                var files = $("#bannerupload")[0].files;
                for (var i = 0; i < files.length; i++) {
                    var fileName = files[i].name;

                    document.getElementById('fileDisplaySection').style.display = 'block';

                    rows = rows + '<tr class="w-full font-bold text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">';
                    rows = rows + '<td class="px-4 py-4">'+ rowNumber++ +'</td>';
                    rows = rows + '<td class="px-4 py-4">'+ fileName +'</td>';
                    rows = rows + '<td class="text-center py-4">';
                    rows = rows + '<div class="mb-4">';
                    rows = rows + '<select name="banner_size_id[]" class="w-full mt-4 mb px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary id="banner_size_id" required>';
                    rows = rows + '<option value="0">Select Option</option>';
                    @foreach ($size_list as $size)
                        rows = rows + '<option value='+ {{$size->width}} + 'x' + {{$size->height}} +' class="py-2">'+ {{$size->width}} + 'x' + {{$size->height}} +'</option>';
                    @endforeach
                    rows = rows + '</select>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                    $('#fileTable').html(rows);
                }
            });

            $("#gifupload").change(function() {
                var rows = '';
                var select = '';
                var rowNumber = 1;
                var files = $("#gifupload")[0].files;
                console.log(files);
                for (var i = 0; i < files.length; i++) {
                    var fileName = files[i].name;

                    document.getElementById('gifDisplaySection').style.display = 'block';

                    rows = rows + '<tr class="w-full font-bold text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">';
                    rows = rows + '<td class="px-4 py-4">'+ rowNumber++ +'</td>';
                    rows = rows + '<td class="px-4 py-4">'+ fileName +'</td>';
                    rows = rows + '<td class="text-center py-4">';
                    rows = rows + '<div class="mb-4">';
                    rows = rows + '<select name="gif_size_id[]" class="w-full mt-4 mb px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary id="gif_size_id" required>';
                    rows = rows + '<option value="0">Select Option</option>';
                    @foreach ($size_list as $size)
                        rows = rows + '<option value='+ {{$size->width}} + 'x' + {{$size->height}} +' class="py-2">'+ {{$size->width}} + 'x' + {{$size->height}} +'</option>';
                    @endforeach
                    rows = rows + '</select>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                    $('#gifFileTable').html(rows);
                }
            });

            $("#socialupload").change(function() {
                var rows = '';
                var select = '';
                var rowNumber = 1;
                var files = $("#socialupload")[0].files;
                for (var i = 0; i < files.length; i++) {
                    var fileName = files[i].name;

                    document.getElementById('socialDisplaySection').style.display = 'block';

                    rows = rows + '<tr class="w-full font-bold text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">';
                    rows = rows + '<td class="px-4 py-4">'+ rowNumber++ +'</td>';
                    rows = rows + '<td class="px-4 py-4">'+ fileName +'</td>';
                    rows = rows + '<td class="text-center py-4">';
                    rows = rows + '<div class="mb-4">';
                    rows = rows + '<select name="platform[]" class="w-full mt-4 mb px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary id="social_id" required>';
                    rows = rows + '<option value="0" class="py-2">Select Option</option>';
                    rows = rows + '<option value='+ 'Social' +' class="py-2">'+ 'Social (Standard)' +'</option>';
                    rows = rows + '<option value='+ 'Facebook' +' class="py-2">'+ 'Facebook' +'</option>';
                    rows = rows + '<option value='+ 'Youtube' +' class="py-2">'+ 'Youtube' +'</option>';
                    rows = rows + '<option value='+ 'Whatsapp' +' class="py-2">'+ 'Whatsapp' +'</option>';
                    rows = rows + '<option value='+ 'Instagram' +' class="py-2">'+ 'Instagram' +'</option>';
                    rows = rows + '<option value='+ 'Facebook-Messenger' +' class="py-2">'+ 'Facebook Messenger' +'</option>';
                    rows = rows + '<option value='+ 'WeChat' +' class="py-2">'+ 'WeChat' +'</option>';
                    rows = rows + '<option value='+ 'Tiktok' +' class="py-2">'+ 'Tiktok' +'</option>';
                    rows = rows + '<option value='+ 'LinkedIn' +' class="py-2">'+ 'LinkedIn' +'</option>';
                    rows = rows + '<option value='+ 'Snapchat' +' class="py-2">'+ 'Snapchat' +'</option>';
                    rows = rows + '<option value='+ 'Twitter' +' class="py-2">'+ 'Twitter' +'</option>';
                    rows = rows + '</select>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                    $('#socialFileTable').html(rows);
                }
            });
        });
    </script>