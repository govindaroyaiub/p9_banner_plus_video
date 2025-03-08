@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mt-2">Edit Social To Version</h3>
            <br>

            <h3 class="text-xl font-semibold tracking-wide" style="color: red;">Updating Socials into {{ $feedback['name'] }} > {{ $version['name'] }}</h3>
            <br>

            <form id="project-add-form" class="max-w-4xl" method="POST"
                action="/project/preview/social/edit/version/{{ $version['id'] }}" enctype="multipart/form-data" style="100%;">
                @csrf
                {{-- Drag and Drop --}}
                
                <input type='text' name="version_name" value="{{ $version['name'] }}" id="version_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>

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

        $("#socialupload").change(function() {
            var rows = '';
            var select = '';
            var rowNumber = 1;
            var files = $("#socialupload")[0].files;
            for (var i = 0; i < files.length; i++) {
                var fileName = files[i].name;

                document.getElementById('socialDisplaySection').style.display = 'block';

                rows = rows + '<tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">';
                rows = rows + '<td class="px-4 py-4">'+ rowNumber++ +'</td>';
                rows = rows + '<td class="px-4 py-4">'+ fileName +'</td>';
                rows = rows + '<td class="text-center py-4">';
                rows = rows + '<div class="mb-4">';
                rows = rows + '<select name="platform[]" class="w-full mt-4 mb px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary id="banner_size_id" required>';
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
