@extends('material_ui.layouts.app')

@section('content')

<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Edit Preview Project</h3>
            <br>
                <form class="max-w-4xl" method="POST" action="/project/preview/edit/{{$project_id}}"
                    enctype="multipart/form-data" style="width: 100%;">
                    @csrf
                    <div class="mb-4">
                        <label class="text-primary font-bold block">Project Name</label>
                        <small class="text-x text-red-500">(Please refrain from using special type characters: * / ? ~ ! %
                            etc)</small>
                        <input type='text' placeholder="Enter Project Name" name="project_name"
                            value="{{ $project_info['name'] }}"
                            class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                            required />
                    </div>
    
                    <div class="flex flex-col md:flex-row gap-4 mb-4">
                        <!-- Client Name -->
                        <div class="w-full md:w-1/2">
                            <label class="text-primary font-bold">Client Name</label>
                            <input type="text" placeholder="Enter Client Name" name="client_name"
                                value="{{ $project_info['client_name'] }}"
                                class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary h-12"
                                required />
                        </div>
                    
                        <!-- Select Logo -->
                        <div class="w-full md:w-1/2">
                            @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                                <label class="text-primary font-bold">Select Logo</label>
                                <select name="logo_id"
                                    class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary h-12"
                                    required>
                                    <option value="0" class="py-2">Select Logo</option>
                                    @foreach($logo_list as $logo)
                                        <option value="{{ $logo->id }}" @if($project_info['logo_id'] == $logo->id) selected @endif
                                            class="py-2">
                                            {{ $logo->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" name="logo_id" value="{{ Auth::user()->company_id }}">
                            @endif
                        </div>
                    </div>
    
                    <div class="mb-4">
                        <label class="text-teal-600 font-bold">Naming Convention</label><br>
                        <div class="flex">
                            <input type='text' value="{{ $naming_convention }}_" id="naming_convention"
                                class="w-full mr-4 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                                readonly />
                            <button type="button" onclick="copy_text()"
                                class="bg-green-500 text-gray-200 rounded hover:bg-green-400w-1/3 px-2 focus:outline-none"
                                style="height: 2.5rem; width: 9rem;">
                                <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="margin: 0 auto;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>
    
                    <div class="flex flex-wrap gap-4">
                        <!-- Show Logo -->
                        <div class="w-full md:w-1/2">
                            <label class="text-primary font-bold">Show Logo?</label>
                            <select class="w-full mt-2 border bg-white rounded px-3 py-2 outline-none h-12" name="is_logo">
                                <option value="0" class="py-2">Select Option</option>
                                <option value="1" class="py-1" @if($project_info['is_logo'] == 1) selected @endif>Yes</option>
                                <option value="2" class="py-1" @if($project_info['is_logo'] == 2) selected @endif>No</option>
                            </select>
                        </div>
                    
                        <!-- Show Footer -->
                        <div class="w-full md:w-1/2">
                            <label class="text-primary font-bold">Show Footer?</label>
                            <select class="w-full mt-2 border bg-white rounded px-3 py-2 outline-none h-12" name="is_footer">
                                <option value="0" class="py-2">Select Option</option>
                                <option value="1" class="py-1" @if($project_info['is_footer'] == 1) selected @endif>Yes</option>
                                <option value="2" class="py-1" @if($project_info['is_footer'] == 2) selected @endif>No</option>
                            </select>
                        </div>
    
                        <!-- Color Picker -->
                        <div class="w-full md:w-1/3">
                            <label class="text-primary font-bold">Pick Color</label>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="color" name="color" value="{{ $project_info['color'] }}"
                                    class="w-12 h-12 border rounded-md cursor-pointer appearance-none"
                                    oninput="document.getElementById('colorPreview').value = this.value" />
                                
                                <input type="text" id="colorPreview" name="color_hex" 
                                    value="{{ $project_info['color'] }}" 
                                    class="px-3 py-2 border rounded-md w-24 text-gray-700 focus:outline-none focus:border-primary" />
                            </div>
                        </div>
                    </div>
    
                    <div class="flex space-x-4 mt-4">
                        <button type="submit"
                            class="w-1/2 mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-3 focus:outline-none">SAVE</button>
                        <button type="button" onclick="window.location.href ='/view-previews'"
                            class="w-1/2 mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-3 focus:outline-none">BACK</button>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection