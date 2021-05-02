@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex -mx-4">
            @include('sidebar')
            <div class="w-3/5 mx-4">
                @include('alert')
                <h3 class="text-xl font-semibold tracking-wide mb-4">Add Transfer Link</h3>
                <br>
                <form id="project-add-form" class="max-w-xl" method="POST" action="/p9_transfer"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="text-primary font-light block">Name</label>
                        <input type='text' placeholder="Enter Name" name="name"
                               class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>
                    </div>

                    <div class="mb-4">
                        <label class="text-primary font-light block">Client Name (Optional)</label>
                        <input type='text' placeholder="Enter Client Name" name="client_name"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"/>
                    </div>

                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <span class="drop-zone__prompt">Drop Zip File Here or Click to Upload</span>
                        <input type="file" name="upload[]" class="drop-zone__input hidden">
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



