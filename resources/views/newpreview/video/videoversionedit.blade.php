@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mt-2">Edit Banner To Version</h3>
            <br>

            <h3 class="text-xl font-semibold tracking-wide" style="color: red;">Updating Banners into {{ $feedback['name'] }} > {{ $version['name'] }}</h3>
            <br>

            <form id="project-add-form" class="max-w-xl" method="POST"
                action="/project/preview/video/edit/version/{{ $version['id'] }}" enctype="multipart/form-data">
                @csrf
                {{-- Drag and Drop --}}
                
                <input type='text' name="version_name" value="{{ $version['name'] }}" id="version_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>

                
                {{-- Drag and Drop --}}

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
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"
    integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
