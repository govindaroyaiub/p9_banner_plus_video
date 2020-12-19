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
        <div class="w-3/4 mx-4">
            @include('alert')
            <br>
            <div class="flex justify-between w-full">
                <h3 class="text-xl font-semibold tracking-wide">Banner Sizes</h3>
                <a href="/banner_sizes/add">
                    <button type="button"
                        class="leading-tight bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white">Add
                        Size</Button>
                </a>
            </div>
            <br>
            <table id="datatable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th data-priority="1">No</th>
                        <th data-priority="2">Resolution</th>
                        <th data-priority="3">Actions</th>
                    </tr>
                </thead>
                <?php $i=1; ?>
                <tbody>
                    @foreach( $size_list as $size )
                    <tr style="text-align: center;">
                        <td class="border px-4 py-2">{{ $i++ }}</td>
                        <td class="border px-4 py-2">{{ $size->width }}x{{ $size->height }}</td>
                        <td class="border px-4 py-2">
                            <a href="/sizes/delete/{{$size->id}}">
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
@endsection
