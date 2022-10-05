@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h4 class="text-xl font-semibold tracking-wide py-2">Project: <label class="text-red-500">{{ $project_name }} - {{ $feedback_info['name'] }}</label></h4>
            <h3 class="text-xl font-semibold tracking-wide">Edit Feedback</h3>
            <span class="text-red-600">Note: If banners are uploaded then current banners will get updated as well!</span>
            <br>

            <form id="project-add-form" class="max-w-xl py-3" method="POST"
                action="/video/edit/feedback/{{$project_id}}/{{$feedback_id}}" enctype="multipart/form-data">
                @csrf
                {{-- Drag and Drop --}}
                <input type='text' placeholder="{{ $feedback_info['name'] }}" name="feedback_name" value="{{ $feedback_info['name'] }}" id="feedback_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>

                <textarea name="feedback_description" id="feedback_description" rows="6"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required>{{ $feedback_info['description'] }}</textarea>

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