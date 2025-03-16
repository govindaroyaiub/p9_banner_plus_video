@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Edit Transfer Link: {{ $transfer_name }}</h3>
            <br>
            <form id="project-add-form" class="max-w-4xl" action="{{ route('p9_transfer.update', $id) }}" method="POST"
                enctype="multipart/form-data" style="width: 100%;">
                @csrf

                @method('PUT')

                <div class="mb-4">
                    <label class="text-primary font-bold block">Name</label>
                    <input type='text' placeholder="Enter Name" name="name" value="{{ $transfer_name }}"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-2">
                    <label class="text-primary font-bold block">Client Name (Optional)</label>
                    <input type='text' placeholder="Enter Client Name" name="client_name"
                        value="{{ $transfer_client_name }}"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" />
                </div>

            <label class="text-red-500 font-semibold">*Uploading ZIP files will change the present files. So, upload the files accordingly.</label>
            <br>
            <br>
            <div
            x-data="{ files: null }"
            class="file-upload relative block w-full border-2 border-dashed rounded-sm border-gray-300 p-4 appearance-none hover:shadow-outline-gray"
            >
            <input
            @change="files = $event.target.files; console.log($event.target.files)"
            @dragover="$el.classList.add('active');"
            @drop="$el.classList.remove('active');"
            @dragleave="$el.classList.remove('active');"
            type="file"
            multiple
            name="upload[]"
            class="absolute inset-0 z-50 w-full h-full opacity-0" style="opacity: 0;"
            />
            
            <template x-if="files !== null">
                <div class="flex flex-col space-y-1">
                    <template x-for="(_,index) in Array.from({ length: files.length })">
                        <div class="flex flex-row items-center space-x-2">
                            <template x-if="files[index].type.includes('application/')"
                            ><i class="far fa-file-alt fa-fw"></i
                                ></template>
                                <span
                                class="font-medium text-gray-900"
                                x-text="files[index].name"
                                >Uploading</span
                                >
                                <span
                                class="text-xs self-end text-gray-500"
                                x-text="filesize(files[index].size)"
                                >...</span
                                >
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="files === null">
                    <p class="text-center">Drag your files here or click in this area.</p>
                </template>
            </div>

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        SAVE
                    </button>
                    <button type="button" onclick="window.location.href ='/p9_transfer'"
                        class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        BACK
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="https://cdn.filesizejs.com/filesize.min.js"></script>
    @endsection