@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/5 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Edit Transfer Link: {{ $transfer_name }}</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" action="{{ route('p9_transfer.update', $id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @method('PUT')

                <div class="mb-4">
                    <label class="text-primary font-light block">Name</label>
                    <input type='text' placeholder="Enter Name" name="name" value="{{ $transfer_name }}"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4">
                    <label class="text-primary font-light block">Client Name (Optional)</label>
                    <input type='text' placeholder="Enter Client Name" name="client_name"
                        value="{{ $transfer_client_name }}"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" />
                </div>

                {{-- <div class="mb-2">
                    <label class="text-red-500 font-semibold">* Upload only if the previous assets need to be
                        changed</label>
                    <div
                        class="drop-zone border-2 border-dotted border-indigo-400 rounded-lg p-6 cursor-pointer flex justify-center items-center font-2xl font-semibold text-indigo-400">
                        <span class="drop-zone__prompt">Drop Zip File Here or Click to Upload</span>
                        <input type="file" name="upload[]" class="drop-zone__input hidden">
                    </div>
                </div> --}}

                <div class="flex flex-col flex-grow mb-3">
                    <label class="text-red-500 font-semibold">* Note: Uploading new ZIP files will replace the present files.</label>
                    <br>
                    <div x-data="{ files: null }" id="FileUpload"
                        class="block w-full py-2 px-3 relative bg-white appearance-none border-2 border-gray-300 border-dashed rounded-md hover:shadow-outline-gray rounded-lg">
                        <input type="file" multiple name="upload[]"
                            class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                            x-on:change="files = $event.target.files; console.log($event.target.files);"
                            x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')"
                            x-on:drop="$el.classList.remove('active')" />
                        <template x-if="files !== null">
                            <div class="flex flex-col space-y-1">
                                <template x-for="(_,index) in Array.from({ length: files.length })">
                                    <div class="flex flex-row items-center space-x-2">
                                        <template x-if="files[index].type.includes('audio/')"></template>
                                        <template x-if="files[index].type.includes('application/')"></template>
                                        <template x-if="files[index].type.includes('image/')"></template>
                                        <template x-if="files[index].type.includes('video/')"></template>
                                        <span class="font-medium text-gray-900"
                                            x-text="files[index].name">Uploading</span>
                                        <span class="text-xs self-end text-gray-500"
                                            x-text="filesize(files[index].size)">...</span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="files === null">
                            <div class="flex flex-col space-y-2 items-center justify-center">
                                <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                                <p class="text-primary font-semibold">
                                    Drag your ZIP files here or click in this area.
                                </p>
                                <a href="javascript:void(0)"
                                    class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-lg outline-none bg-blue-400">Select
                                    a file</a>
                            </div>
                        </template>
                    </div>
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

    @section('script')
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script> --}}
    <script src="https://cdn.filesizejs.com/filesize.min.js"></script>
    @endsection
