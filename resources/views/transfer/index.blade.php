@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex -mx-4">
        @include('sidebar')
        <div class="md:w-3/4 mx-4">
            @include('alert')
            <br>
            <div class="flex justify-between w-full">
                <h3 class="text-xl font-semibold tracking-wide">Transfer Links</h3>
                <a href="{{ URL::to('p9_transfer/create') }}">
                    <button type="button"
                        class="leading-tight bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white">Add
                        Transfer Link</Button>
                </a>
            </div>
            <br>
            <table id="datatable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th data-priority="1">No</th>
                        <th data-priority="2">Name</th>
                        <th data-priority="3" width="140px" max-width="160px">Client Name</th>
                        <th data-priority="4" width="110px" max-width="135px">Uploader</th>
                        <th data-priority="5">Actions</th>
                    </tr>
                </thead>
                <?php $i=1; ?>
                <tbody>
                    @foreach ($transfers as $transfer)
                    <tr style="text-align: center;">
                        <td class="border px-4 py-2">{{ $i++ }}</td>
                        <td class="border px-4 py-2">
                            {{ $transfer->name }}
                        </td>
                        <td class="border px-4 py-2" width="140px" max-width="160px">
                            {{ $transfer->client_name }}
                        </td>
                        <td class="border px-4 py-2" width="110px" max-width="135px">
                            <label
                                class="text-red-500 font-semibold">{{ Helper::getUsername($transfer->uploader) }}</label>
                        </td>
                        <td class="">
                            <div class="flex justify-around items-center">
                                <a href="/p9_transfer/{{ $transfer->slug }}" target="_blank">
                                    <button type="button"
                                        class="bg-green-500 text-sm text-gray-200 rounded hover:bg-green-400 p-2 focus:outline-none">
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
                                        class="bg-blue-600 text-sm text-white rounded hover:bg-blue-500 p-2 focus:outline-none">
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
                                        class="bg-red-500 text-sm text-gray-200 rounded hover:bg-red-400 p-2 focus:outline-none">
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
@endsection
