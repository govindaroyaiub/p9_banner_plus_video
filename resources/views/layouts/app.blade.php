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
    <link href="{{ asset('/css/datatable.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    @yield('styles')
</head>
<body class="bg-gray-100 min-h-screen font-body">
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
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
</script>

<script>

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

    // Drag and drop
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");
        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });
        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });
        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });
        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });
        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").remove();
        }
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }
        thumbnailElement.dataset.label = file.name;
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }
</script>
@yield('script')
</body>
</html>
