@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/4 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Edit Banner Project</h3>
            <br>
            <form method="POST" action="/project/banner/edit/{{$id}}" enctype="multipart/form-data">
                @csrf
                <label class="text-primary font-light">Project Name</label><br>
                <input type='text' placeholder="Enter Project Name" name="project_name" value="{{ $project_info['name'] }}"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                <br>

                <label class="text-primary font-light">Client Name</label><br>
                <input type='text' placeholder="Enter Client Name" name="client_name" value="{{ $project_info['client_name'] }}"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                <br>

                @if(url('/') == 'http://localhost:8000')
                <label class="text-primary font-light">Select Logo</label><br>
                <select name="logo_id"
                    class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required>
                    <option value="0" class="py-2">Select Logo</option>
                    @foreach($logo_list as $logo)
                    <option value="{{ $logo->id }}" @if($project_info['logo_id'] == $logo->id) selected @endif class="py-2">{{ $logo->name }}</option>
                    @endforeach
                </select>
                <br>
                @else
                <input type="hidden" name="logo_id" value="{{ Auth::user()->company_id }}">
                @endif
            
                <label class="text-primary font-light">Show Logo?</label><br>
                <select class="w-2/3 border bg-white rounded px-3 py-2 outline-none" name="is_logo">
                    <option value="0" class="py-2">Select Option</option>
                    <option value="1" class="py-1" @if($project_info['is_footer'] == 1) selected @endif>Yes</option>
                    <option value="2" class="py-1" @if($project_info['is_footer'] == 2) selected @endif>No</option>
                </select>
                <br>
                <br>

                <label class="text-primary font-light">Show Footer?</label><br>
                <select class="w-2/3 border bg-white rounded px-3 py-2 outline-none" name="is_footer">
                    <option value="0" class="py-2">Select Option</option>
                    <option value="1" class="py-1" @if($project_info['is_logo'] == 1) selected @endif>Yes</option>
                    <option value="2" class="py-1" @if($project_info['is_logo'] == 2) selected @endif>No</option>
                </select>
                <br>
                <br>

                <label class="text-primary font-light">Select Color (Default Selcted Color is PlanetNine Logo
                    Color)</label><br>
                <input type='color' name="color" value="{{ $project_info['color'] }}" class="w-2/3 mt-2 mb-6 px-4 py-2 border rounded-lg" />
                <br>

                <div class="flex mb-4">
                    <button type="submit"
                        class="w-1/3 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-3 focus:outline-none">SAVE</button>
                    <button type="button" onclick="window.location.href='/project';"
                        class="w-1/3 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-3 focus:outline-none">BACK</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
