@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4 mt-2">Edit Feedback</h3>
            <h3 class="text-xl font-semibold tracking-wide mb-4 mt-2">Editing To Feedback: <label style="color: red;">{{ $feedback['name'] }}</label></h3>
            <form id="project-add-form" class="max-w-4xl" method="POST" action="/project/preview/edit/feedback/{{ $id }}"
                enctype="multipart/form-data" style="width: 100%;">
                @csrf


                <div class="mb-4" id="feedback_round_title">
                    <label class="text-primary font-bold block">Feedback Name</label>
                    <input type='text' name="feedback_name" value="{{ $feedback['name'] }}"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4" id="feedback_description">
                    <label class="text-primary font-bold block">Feedback Description</label>
                    <textarea type='text' name="feedback_description"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required>{{ $feedback['description'] }}</textarea>
                </div>

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
    @endsection