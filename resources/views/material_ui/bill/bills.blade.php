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
            <a href="/bills/add">
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
            <h3 class="card-title card-padding pb-2">Bills</h3>
            <div class="table-responsive">
                <table id="datatable" class="table table-hoverable">
                    <thead>
                        <tr>
                            <th data-priority="1" style="text-align: center;">No</th>
                            <th data-priority="2" style="text-align: center;">Title</th>
                            <th data-priority="3" style="text-align: center;">Client Name</th>
                            <th data-priority="4" style="text-align: center;">Uploader</th>
                            <th data-priority="5" style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                        @foreach($bills as $bill)
                        <tr>
                            <td style="text-align: center">{{ $i++ }}</td>
                            <td style="text-align: center">
                                {{ $bill->name }}
                            </td>
                            <td style="text-align: center">{{ $bill->client_name }}</td>
                            <td style="text-align: center">
                                <label class="text-red-500 font-semibold">{{ Helper::getUsername($bill->uploaded_by_user_id) }}</label>
                                <hr>
                                <label class="text-red-500 font-semibold">{{ \Carbon\Carbon::parse($bill->created_at)->format('d F Y') }}</label>
                            </td>
                            <td style="text-align: center">
                                <a href="/bills/view/{{$bill->id}}">
                                    <button type="button"
                                        class="bg-green-500 text-gray-200 rounded hover:bg-green-400 px-4 py-2 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                          </svg>
                                    </button>
                                </a>
    
                                <a href="/bills/delete/{{$bill->id}}" onclick="return confirm('Are you sure you want to delete this project?');">
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