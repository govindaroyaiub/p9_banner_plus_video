@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Add Video</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST" action="/project/banner/addon/{{ $main_project_id }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-primary font-light block mb-3">Banner Width x Height</label>
                            <select name="banner_size_id"
                                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" id="banner_size_id">
                                <option value="0" class="py-2">Select Size</option>
                                @foreach($size_list as $size)
                                <option value="{{ $size->id }}" class="py-2">{{ $size->width }}x{{ $size->height }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-primary font-light block">Upload Banner (ZIP file)</label>
                    <div
                        class="drag-n-drop-area relative opacity-50 border border-dashed border-primary rounded-lg w-full">
                        <input type="file" name="upload" class="drag-n-drop absolute mx-auto text-center" required
                            id="upload" />
                    </div>
                </div>

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-indigo-700 text-gray-200 text-lg rounded hover:bg-indigo-500 px-6 py-2 focus:outline-none">
                        Create
                    </button>
                    <button type="button" onclick="window.location.href='/project';"
                        class="w-full mt-2 mb-6 bg-green-600 text-gray-100 text-lg rounded hover:bg-green-500 px-6 py-2 focus:outline-none">
                        Back
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
