@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
        @include('alert')
            <h3 class="text-xl font-semibold tracking-wide">Change Password</h3>
            <br>
            <form method="POST" action="/change-password" enctype="multipart/form-data" class="max-w-4xl" style="width: 100%;">
            @csrf
            <input type='password' placeholder="Enter Current Password" name="current_password" id="current_password"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>

            <input type='password' placeholder="Enter New Password" name="new_password" id="new_password"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>

            <input type='password' placeholder="Repeat New Password" name="repeat_password" id="repeat_password"
                class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required/>
                
            <div class="flex items-center">
                <input type="checkbox" id="show_password" class="h-4 w-4 text-gray-700 border rounded mr-2">
                <label for="show_password">Show Passwords</label>
            </div>
            <br>
            <div class="flex space-x-4">
                <button type="submit"
                    class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-3 focus:outline-none">Update</button>
                <button type="button" onclick="window.location.href='/logo';"
                    class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-3 focus:outline-none">Back</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#show_password').click(function (e) {
            var current_password = $('#current_password').val().length;
            var repeat_password = $('#repeat_password').val().length;
            var new_password = $('#new_password').val().length;

            if (document.getElementById('show_password').checked) {
                if (current_password == 0) {
                    alert('Enter Current Password!');
                    e.preventDefault();
                }
                if (new_password == 0) {
                    alert('Enter New Password!');
                    e.preventDefault();
                }
                if (repeat_password == 0) {
                    alert('Enter Repeat Password!');
                    e.preventDefault();
                } else {
                    $('#current_password').get(0).type = 'text';
                    $('#new_password').get(0).type = 'text';
                    $('#repeat_password').get(0).type = 'text';
                }
            } else {
                $('#current_password').get(0).type = 'password';
                $('#new_password').get(0).type = 'password';
                $('#repeat_password').get(0).type = 'password';
            }
        });
</script>
@endsection
