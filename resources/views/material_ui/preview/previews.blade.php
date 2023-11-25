@extends('material_ui.app')

@section('content')

<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex py-2 justify-end">
        <div>
            <a href="/project/preview/add">
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
            <h3 class="card-title card-padding pb-2">Previews</h3>
            <div class="table-responsive">
                <table id="datatable" class="table table-hoverable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Client</th>
                            <th style="text-align: center;">Type</th>
                            <th style="text-align: center;">Uploader</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td style="text-align: center;">{{ $i++ }}</td>
                            <td style="text-align: center;">
                                {{ $row->name }}
                            </td>
                            <td style="text-align: center;">{{ $row->client_name }}</td>
                            <td style="text-align: center;">
                                <div style="display: flex; justify-content: space-evenly;">
                                    <?php
                                    $data = Helper::getProjectTags($row->id);
                                    foreach ($data as $key => $tag) {
                                            # code...
                                            if($tag == 'Banner'){
                                                echo '<div style="width: 60px; padding: 5px; border-radius: 5px; background-color: #1abc9c; color: white;">Banner</div>';
                                            }
                                            else if($tag == 'Video'){
                                                echo '<div style="width: 60px; padding: 5px; border-radius: 5px; background-color: #2ecc71; color: white;">Video</div>';
                                            }
                                            else if($tag == 'Gif'){
                                                echo '<div style="width: 60px; padding: 5px; border-radius: 5px; background-color: #3498db; color: white;">Gif</div>';
                                            }
                                            else if($tag == 'Social'){
                                                echo '<div style="width: 60px; padding: 5px; border-radius: 5px; background-color: #9b59b6; color: white;">Social</div>';
                                            }
                                            else{
                                                echo '<div style="width: 60px; padding: 5px; border-radius: 5px; background-color: #c0392b; color: white;">ERROR</div>';
                                            }
                                        }
                                    ?>
                                </div>
                                
                            </td>
                            @if(Auth::user()->company_id == 1)
                            <td style="text-align: center;">
                                <label class="text-red-500 font-semibold">{{ Helper::getUsername($row->uploaded_by_user_id) }}</label>
                                <hr>
                                <label class="text-red-500 font-semibold">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</label>
                            </td>
                            @endif
                            <td style="text-align: center;">
                                <a href="/project/preview/view/{{$row->id}}" target="_blank">
                                    <button type="button"
                                        class="bg-primary text-gray-200 rounded px-4 py-2 focus:outline-none">
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </a>
                            
                                <a href="/project/preview/edit/{{ $row->id }}">
                                    <button type="button"
                                        class="bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </a>
    
                                <a href="/project/preview/delete/{{$row->id}}" onclick="return confirm('Are you sure you want to delete this project?');">
                                    <button type="button"
                                        class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                        <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </a>
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