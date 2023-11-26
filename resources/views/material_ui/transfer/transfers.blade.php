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
            <a href="{{ URL::to('p9_transfer/create') }}">
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
        <div class="mdc-card p-0 rounded-xl">
            <h3 class="card-title card-padding pb-2">Transfer Links</h3>
            <div class="table-responsive">
                <table id="datatable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="1" style="text-align: center">No</th>
                            <th data-priority="2" style="text-align: center">Name</th>
                            <th data-priority="3" style="text-align: center">Client Name</th>
                            <th data-priority="4" style="text-align: center">Uploader</th>
                            <th data-priority="5" style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                        @foreach ($transfers as $transfer)
                        <tr>
                            <td style="text-align: center">{{ $i++ }}</td>
                            <td style="text-align: center">
                                {{ $transfer->name }}
                            </td>
                            <td style="text-align: center">
                                {{ $transfer->client_name }}
                            </td>
                            <td style="text-align: center">
                                <label
                                    class="text-red-500 font-semibold">{{ Helper::getUsername($transfer->uploader) }}</label>
                                <hr>
                                <label class="text-red-500 font-semibold">{{ \Carbon\Carbon::parse($transfer->created_at)->format('F Y') }}</label>
                            </td>
                            <td style="text-align: center">
                                <div class="flex justify-around items-center">
                                    <a href="/p9_transfer/{{ $transfer->slug }}" target="_blank">
                                        <button type="button"
                                            class="bg-green-500 text-gray-200 rounded hover:bg-green-400 p-2 focus:outline-none">
                                            <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </a>
    
                                    <a href="/p9_transfer/{{ $transfer->id }}/edit">
                                        <button type="button"
                                            class="bg-blue-600 text-white rounded hover:bg-blue-500 p-2 focus:outline-none">
                                            <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </a>
    
                                    <form action="{{ route('p9_transfer.destroy', $transfer->id) }}" method="POST">
                                        @csrf
    
                                        @method('DELETE')
    
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this transfer?');"
                                            class="bg-red-500 text-gray-200 rounded hover:bg-red-400 p-2 focus:outline-none">
                                            <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
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