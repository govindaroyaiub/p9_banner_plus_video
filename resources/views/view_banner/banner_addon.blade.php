@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Add Banner</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST"
                action="/project/banner/addon/{{ $main_project_id }}" enctype="multipart/form-data">
                @csrf
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
                rows = rows + '<option value=' + 1 + ' class="py-2">' + 120 + 'x' + 600 + '</option>';
                rows = rows + '<option value=' + 2 + ' class="py-2">' + 120 + 'x' + 240 + '</option>';
                rows = rows + '<option value=' + 3 + ' class="py-2">' + 160 + 'x' + 600 + '</option>';
                rows = rows + '<option value=' + 4 + ' class="py-2">' + 180 + 'x' + 150 + '</option>';
                rows = rows + '<option value=' + 5 + ' class="py-2">' + 234 + 'x' + 60 + '</option>';
                rows = rows + '<option value=' + 6 + ' class="py-2">' + 200 + 'x' + 200 + '</option>';
                rows = rows + '<option value=' + 7 + ' class="py-2">' + 250 + 'x' + 250 + '</option>';
                rows = rows + '<option value=' + 8 + ' class="py-2">' + 300 + 'x' + 120 + '</option>';
                rows = rows + '<option value=' + 9 + ' class="py-2">' + 300 + 'x' + 50 + '</option>';
                rows = rows + '<option value=' + 10 + ' class="py-2">' + 300 + 'x' + 250 + '</option>';
                rows = rows + '<option value=' + 11 + ' class="py-2">' + 300 + 'x' + 600 + '</option>';
                rows = rows + '<option value=' + 12 + ' class="py-2">' + 306 + 'x' + 230 + '</option>';
                rows = rows + '<option value=' + 13 + ' class="py-2">' + 320 + 'x' + 50 + '</option>';
                rows = rows + '<option value=' + 14 + ' class="py-2">' + 320 + 'x' + 100 + '</option>';
                rows = rows + '<option value=' + 15 + ' class="py-2">' + 320 + 'x' + 240 + '</option>';
                rows = rows + '<option value=' + 16 + ' class="py-2">' + 320 + 'x' + 480 + '</option>';
                rows = rows + '<option value=' + 17 + ' class="py-2">' + 336 + 'x' + 280 + '</option>';
                rows = rows + '<option value=' + 18 + ' class="py-2">' + 468 + 'x' + 60 + '</option>';
                rows = rows + '<option value=' + 19 + ' class="py-2">' + 500 + 'x' + 500 + '</option>';
                rows = rows + '<option value=' + 20 + ' class="py-2">' + 580 + 'x' + 400 + '</option>';
                rows = rows + '<option value=' + 21 + ' class="py-2">' + 580 + 'x' + 400 + '</option>';
                rows = rows + '<option value=' + 22 + ' class="py-2">' + 600 + 'x' + 100 + '</option>';
                rows = rows + '<option value=' + 23 + ' class="py-2">' + 600 + 'x' + 700 + '</option>';
                rows = rows + '<option value=' + 24 + ' class="py-2">' + 728 + 'x' + 90 + '</option>';
                rows = rows + '<option value=' + 25 + ' class="py-2">' + 960 + 'x' + 300 + '</option>';
                rows = rows + '<option value=' + 26 + ' class="py-2">' + 970 + 'x' + 90 + '</option>';
                rows = rows + '<option value=' + 27 + ' class="py-2">' + 970 + 'x' + 250 + '</option>';
                rows = rows + '<option value=' + 28 + ' class="py-2">' + 970 + 'x' + 500 + '</option>';
                rows = rows + '<option value=' + 29 + ' class="py-2">' + 1272 + 'x' + 328 + '</option>';
                rows = rows + '<option value=' + 30 + ' class="py-2">' + 1080 + 'x' + 1080 +
                '</option>';
                rows = rows + '<option value=' + 31 + ' class="py-2">' + 306 + 'x' + 325 + '</option>';
                rows = rows + '<option value=' + 32 + ' class="py-2">' + 1115 + 'x' + 300 + '</option>';
                rows = rows + '<option value=' + 33 + ' class="py-2">' + 300 + 'x' + 60 + '</option>';
                rows = rows + '<option value=' + 34 + ' class="py-2">' + 768 + 'x' + 1024 + '</option>';
                rows = rows + '<option value=' + 35 + ' class="py-2">' + 1024 + 'x' + 768 + '</option>';
                rows = rows + '<option value=' + 36 + ' class="py-2">' + 305 + 'x' + 325 + '</option>';
                rows = rows + '<option value=' + 37 + ' class="py-2">' + 212 + 'x' + 177 + '</option>';
                rows = rows + '<option value=' + 38 + ' class="py-2">' + 262 + 'x' + 184 + '</option>';
                rows = rows + '<option value=' + 39 + ' class="py-2">' + 375 + 'x' + 312 + '</option>';
                rows = rows + '<option value=' + 40 + ' class="py-2">' + 200 + 'x' + 600 + '</option>';
                rows = rows + '<option value=' + 41 + ' class="py-2">' + 600 + 'x' + 200 + '</option>';
                rows = rows + '<option value=' + 42 + ' class="py-2">' + 480 + 'x' + 320 + '</option>';
                rows = rows + '</select>';
                rows = rows + '</td>';
                rows = rows + '</tr>';
                $('#fileTable').html(rows);
            }
        });
    });

</script>
