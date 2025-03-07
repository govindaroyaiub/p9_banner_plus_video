@extends('material_ui.layouts.app')
<style>
    .file-upload.active {
            border-color: #3182ce;
            background-color: #ebf8ff;
        }
</style>
@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
    <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Add Transfer Link</h3>
            <br>
            <form id="project-add-form" class="max-w-4xl" method="POST" action="/p9_transfer"
            enctype="multipart/form-data" style="width: 100%;">
            @csrf
            
            <div class="mb-4">
                <label class="text-primary font-bold block">Name</label>
                <input type='text' placeholder="Enter Name" name="name"
                class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                required />
            </div>
            
            <div class="mb-4">
                <label class="text-primary font-bold block">Client Name (Optional)</label>
                <input type='text' placeholder="Enter Client Name" name="client_name"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" />
            </div>
            
            
            <label class="text-red-500 font-semibold">*Upload ZIP files here:</label>
            <div x-data="fileUpload()" 
         class="file-upload relative block w-full border-2 border-dashed rounded-sm border-gray-300 p-4 hover:shadow-outline-gray"
         @dragover.prevent="$el.classList.add('active')"
         @dragleave.prevent="$el.classList.remove('active')"
         @drop.prevent="handleDrop"
    >
        <input type="file" multiple name="upload[]"
               class="absolute inset-0 z-50 w-full h-full opacity-0 cursor-pointer"
               @change="handleFileSelect"
        />

        <!-- File List -->
        <template x-if="files.length > 0">
            <div class="flex flex-col space-y-2 mt-2">
                <template x-for="(file, index) in files" :key="index">
                    <div class="flex flex-row items-center space-x-2 bg-gray-100 p-2 rounded-md">
                        <i class="far fa-file-alt fa-fw"></i>
                        <span class="font-medium text-gray-900" x-text="file.name"></span>
                        <span class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Default Upload Message -->
        <template x-if="files.length === 0">
            <p class="text-center text-gray-600">Drag your files here or click to upload.</p>
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
</div>

@endsection

@section('script')
<script>
        function fileUpload() {
            return {
                files: [],
                handleFileSelect(event) {
                    this.files = Array.from(event.target.files);
                },
                handleDrop(event) {
                    this.files = Array.from(event.dataTransfer.files);
                },
                formatFileSize(size) {
                    return window.filesize ? window.filesize(size) : `${(size / 1024).toFixed(2)} KB`; // Fallback if filesize.js fails
                }
            };
        }
    </script>
@endsection
