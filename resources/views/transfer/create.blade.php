@extends('layouts.app')

@section('styles')
<style>
     .file-upload.active {
        border-color: #4b4e6d;
      }
</style>
@endsection

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
                required />
            </div>
            
            <div class="mb-4">
                <label class="text-primary font-light block">Client Name (Optional)</label>
                <input type='text' placeholder="Enter Client Name" name="client_name"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" />
            </div>
            
            
            
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

@section('script')
<script src="https://cdn.filesizejs.com/filesize.min.js"></script>
@endsection
