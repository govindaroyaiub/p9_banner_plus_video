@extends('material_ui.layouts.app')

@section('content')

<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex py-2 justify-end">
        <div>
            <a href="/logo/add">
                <button type="button"
                    class="leading-tight bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white float-right">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>
            </a>
        </div>
    </div>

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-0">
            <h3 class="card-title card-padding pb-2">Clients</h3>
            <div class="table-responsive">
                <table id="datatable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="1" style="text-align: center">No</th>
                            <th data-priority="2" style="text-align: center">Name</th>
                            <th data-priority="3" style="text-align: center">URLs</th>
                            <th data-priority="4" style="text-align: center">Favicon</th>
                            <th data-priority="6" style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                    @foreach($logo_list as $logo)
                        <tr>
                            <td style="text-align: center">{{ $i++ }}</td>
                            <td style="text-align: center">
                                {{ $logo->name }}
                                <hr>
                                <div class="flex align-middle justify-center">
                                    <img src="{{url('/logo_images/').'/'.$logo->path}}" style="width: 160px;">
                                </div>
                            </td>
                            <td style="text-align: center">
                                Preview: <a href="{{ $logo->website }}" target="_blank" style="color:#4299e1; text-decoration: underline;">{{ $logo->website }}</a>
                                <hr>
                                Website: <a href="{{ $logo->company_website }}" target="_blank" style="color:#4299e1; text-decoration: underline;">{{ $logo->company_website }}</a>
                                <hr>
                                Color Code: <span>{{ $logo->default_color }}</span>
                            </td>
                            <td style="text-align: center">
                                <div class="flex align-middle justify-center">
                                    <img src="{{ Helper::getFavicon($logo->id) }}">
                                </div>
                            </td>
                            <td style="text-align: center">
                                <div style="display: flex; width: 135px; margin: 0 auto;">
                                    <a href="/logo/edit/{{$logo->id}}">
                                        <button type="button"
                                            class="bg-blue-600 text-gray-900 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                            <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </a>
                                    <br>
                                    <a href="/logo/delete/{{$logo->id}}" onclick="return confirm('Are you sure you want to delete this logo?');" class="px-4">
                                        <button type="button"
                                            class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                            <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection