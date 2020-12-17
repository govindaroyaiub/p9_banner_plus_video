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
                <h3 class="text-xl font-semibold tracking-wide">Add Sizes</h3>

                <form class="max-w-lg" method="POST" action="/banner_sizes/add" enctype="multipart/form-data">
                    @csrf

                    <div class="flex space-x-4">
                        <input type='number' placeholder="Enter Width" name="width"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>
                        <input type='number' placeholder="Enter Height" name="height"
                               class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                               required/>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                                class="w-1/2 mt-2 mb-6 bg-indigo-600 text-gray-200 text-lg rounded hover:bg-indigo-500 px-6 py-2 focus:outline-none">
                            Create
                        </button>
                        <button type="button" onclick="window.location.href='/sizes';"
                                class="w-1/2 mt-2 mb-6 bg-green-600 text-gray-100 text-lg rounded hover:bg-green-500 px-6 py-2 focus:outline-none">
                            Back
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
