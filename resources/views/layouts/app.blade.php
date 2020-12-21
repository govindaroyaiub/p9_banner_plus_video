<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title>P9 Previewer</title>
    <link rel="shortcut icon" href="https://www.planetnine.com/wp-content/uploads/2020/06/cropped-favicon-32x32.png"
          type="image/x-icon">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <style>
        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568; /*text-gray-700*/
            padding-left: 1rem; /*pl-4*/
            padding-right: 1rem; /*pl-4*/
            padding-top: .5rem; /*pl-2*/
            padding-bottom: .5rem; /*pl-2*/
            line-height: 1.25; /*leading-tight*/
            border-width: 2px; /*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7; /*border-gray-200*/
            background-color: #edf2f7; /*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff; /*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-weight: 700; /*font-bold*/
            border-radius: .25rem; /*rounded*/
            border: 1px solid transparent; /*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important; /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06); /*shadow*/
            font-weight: 700; /*font-bold*/
            border-radius: .25rem; /*rounded*/
            background: #667eea !important; /*bg-indigo-500*/
            border: 1px solid transparent; /*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff !important; /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06); /*shadow*/
            font-weight: 700; /*font-bold*/
            border-radius: .25rem; /*rounded*/
            background: #667eea !important; /*bg-indigo-500*/
            border: 1px solid transparent; /*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0; /*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before, table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
            background-color: #667eea !important; /*bg-indigo-500*/
        }

    </style>

    @yield('styles')
</head>
<body class="bg-gray-100 min-h-screen font-body">
<div id="app">
    <nav class="bg-white">
        <div class="relative container mx-auto px-4 py-3 flex justify-between items-center">
            @if(Auth::user())
                <a class="text-xl font-semibold" href="{{ url('/') }}">
                    <img src="{{ asset('/images/logo.png') }}" style="max-width: 20.6%">
                </a>
            @endif

            <ul class="flex space-x-4">
                @guest

                @else
                    <div x-data="{ logout: false}">

                        <button @click="logout = true" class="focus:outline-none">{{ Auth::user()->name }}</button>

                        <div class="dropdown absolute bg-white shadow-md rounded-lg p-6" x-show="logout"
                             @click.away="logout = false">
                            <a href="/change-password">
                                Change Password
                            </a>
                            <hr>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        })
            .columns.adjust();
    });

    $(document).ready(function () {
        $('#banner_size_id').select2();
        $('#size_id').select2();
    });
    // DND
    var upload = document.querySelector('.drag-n-drop');

    if (upload) {
        function onFile() {
            var me = this,
                file = upload.files[0],
                name = file.name.replace(/\.[^/.]+$/, '');

            if (file.type === '' || file.type === 'video/mp4' || file.type === 'image/gif' || file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'application/zip') {
                if (file.size < (500000 * 1024)) {
                    upload.parentNode.className = 'drag-n-drop-area uploading';
                } else {
                    window.alert('File type ' + file.type + ' not supported');
                }
            }
        }

        upload.addEventListener('dragenter', function (e) {
            upload.parentNode.className = 'drag-n-drop-area dragging';
        }, false);

        upload.addEventListener('dragleave', function (e) {
            upload.parentNode.className = 'drag-n-drop-area';
        }, false);

        upload.addEventListener('dragdrop', function (e) {
            onFile();
        }, false);

        upload.addEventListener('change', function (e) {
            onFile();
        }, false);
    }
</script>
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

    $('.switch').change(function (e) {
        var id = $(this).attr("id");
        var _token = $('input[name="_token"]').val();
        var switch_button = document.getElementsByClassName("switch");

        if ($(this).is(":checked")) {
            var status = 1; //checked
        } else {
            var status = 0; //checked
        }
        $.ajax({
            url: "{{route('change_mail_status')}}",
            method: "POST",
            data:
                {
                    id: id,
                    status: status,
                    _token
                },
            success: function (result) {
                if (result == 'true') {
                    alert('Mail Feedback Enabled!');
                } else {
                    alert('Mail Feedback Disabled!')
                }
            }
        })
    });
</script>


@yield('script')
</body>
</html>
