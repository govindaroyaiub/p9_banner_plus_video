@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Edit Social</h3>
            <br>
            <form id="project-add-form" class="max-w-4xl" method="POST" action="/project/preview/social/edit/{{ $sub_project_id }}"
                enctype="multipart/form-data" style="width: 100%;">
                @csrf
                <div class="mb-2">
                    <label class="text-primary font-bold block">Select Format</label>
                    <select name="platform" class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" id="social_id" required>
                        <option value="">Select Option</option>
                        <option value="Social">Social (Standard)</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Youtube">Youtube</option>
                        <option value="Whatsapp">Whatsapp</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Facebook-Messenger">Facebook Messenger</option>
                        <option value="WeChat">WeChat</option>
                        <option value="Tiktok">Tiktok</option>
                        <option value="LinkedIn">LinkedIn</option>
                        <option value="Snapchat">Snapchat</option>
                        <option value="Twitter">Twitter</option>
                    </select>
                </div>
                <br>
                
                {{-- Drag and Drop --}}
                <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <span class="drop-zone__prompt">Drop Video File Here or Click to Upload</span>
                        <input type="file" name="socialupload" class="drop-zone__input hidden">
                    </div>
                <br>
                {{-- Drag and Drop --}}

                <div class="flex space-x-4">
                    <button type="submit"
                        class="w-1/2 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        SAVE
                    </button>
                    <button type="button" onclick="window.history.back()"
                        class="w-1/2 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        BACK
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
