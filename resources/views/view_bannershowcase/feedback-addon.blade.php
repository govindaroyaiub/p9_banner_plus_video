@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h4 class="text-xl font-semibold tracking-wide py-2">Project: <label class="text-red-500">{{ $project_name }} - {{ $feedback_name }}</label></h4>
            <h3 class="text-xl font-semibold tracking-wide">Add Banners to Feedback</h3>
            <br>

            <form id="project-add-form" class="max-w-xl" method="POST"
                action="/banner/add/feedback/{{$project_id}}/{{$feedback_id}}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="text-primary font-light block">Select Option to Upload</label>
                    <select name="feedback_request" id="feedback_request" required
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary">
                        <option value="0" class="py-2">Select Option</option>
                        @if($category_count <= 1)
                            <option value="1" class="py-2">Upload to Existing Feedback</option>
                        @endif
                        @if($category_count >= 1)
                            <option value="2" class="py-2">Create New Category</option>
                        @endif
                    </select>
                </div>
                <input type='text' placeholder="Default" name="category_name" value="Default" id="category_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary hidden"
                               required/>
                {{-- Drag and Drop --}}
                <div
                    class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                    <input name="upload[]" id="upload" type="file" multiple="multiple" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">
                </div>

                <div id="fileDisplaySection" style="display: none;">
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
                                <tbody style="text-align: center;" id="fileTable">

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
        $('#feedback_request').change(function(){
            var value = $(this).val();
            if(value == 2){
                document.getElementById('category_name').style.display = "block";
            }
            else{
                document.getElementById('category_name').style.display = "none";
            }
        });

        $("#upload").change(function () {
            var rows = '';
            var select = '';
            var rowNumber = 1;
            var files = $("#upload")[0].files;
            for (var i = 0; i < files.length; i++) {
                var fileName = files[i].name;

                document.getElementById('fileDisplaySection').style.display = 'block';

                rows = rows +
                    '<tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">';
                rows = rows + '<td class="px-4 py-4">' + rowNumber++ + '</td>';
                rows = rows + '<td class="px-4 py-4">' + fileName + '</td>';
                rows = rows + '<td class="text-center py-4">';
                rows = rows + '<div class="mb-4">';
                rows = rows +
                    '<select name="banner_size_id[]" class="w-full mt-4 mb px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary id="banner_size_id" required>';
                rows = rows + '<option value="0" class="py-2">Select Option</option>';
                @foreach ($size_list as $size)
                        rows = rows + '<option value='+ {{$size->width}} + 'x' + {{$size->height}} +' class="py-2">'+ {{$size->width}} + 'x' + {{$size->height}} +'</option>';
                @endforeach
                rows = rows + '</select>';
                rows = rows + '</td>';
                rows = rows + '</tr>';
                $('#fileTable').html(rows);
            }
        });
    });

</script>
