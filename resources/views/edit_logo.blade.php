@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex -mx-4">
            @include('sidebar')
            <div class="w-3/4 mx-4">
                <h3 class="text-xl font-semibold tracking-wide">Edit {{ $logo['name'] }}</h3>
                <br>
                @include('alert')
                <form class="max-w-lg" method="POST" action="/logo/edit/{{ $id }}" enctype="multipart/form-data">
                    @csrf
                    <br>
                    <label class="text-primary">Enter Company Name</label>
                    <input type='text' value="{{ $logo['name'] }}" name="company_name"
                           class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                           required/>

                    <label class="text-primary">Enter Preview URL <label class="text-red-500">(with http or https please)</label></label>
                    <input type='text' value="{{ $logo['website'] }}" name="website"
                           class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                           required/>

                    <label class="text-primary">Enter Company Website <label class="text-red-500">(with http or https please)</label></label>
                    <input type='text' value="{{ $logo['company_website'] }}" name="company_website"
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                            required/>

                    <label class="text-primary">Enter Favicon URL</label>
                    <input type='text' value="{{ $logo['favicon'] }}" name="favicon"
                           class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                           required/>

                    
                    <label class="text-primary">Select Default Color</label>
                    <input type='color' name="default_color" value="{{ $logo['default_color'] }}"
                           class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                           required/>
                    
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <span class="drop-zone__prompt">Drop Company Logo Here or Click to Upload</span>
                        <input type="file" name="logo_file" class="drop-zone__input hidden">
                    </div>
                    <br>

                    <div class="flex space-x-4">
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
