<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planet Nine</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('material_ui/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('material_ui/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('material_ui/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('material_ui/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('material_ui/assets/css/demo/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="https://www.planetnine.com/logo/new_favicon.png" />
    <link href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('/css/datatable.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <!-- plugins:js -->
    <script src="{{ asset('material_ui/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{ asset('material_ui/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('material_ui/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('material_ui/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('material_ui/assets/js/material.js') }}" defer></script>
    <script src="{{ asset('material_ui/assets/js/misc.js') }}" defer></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('material_ui/assets/js/dashboard.js') }}" defer></script>
    <!-- End custom js for this page-->
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/filesize/10.0.0/filesize.min.js"></script>

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

        function copy_text() {
            var copyText = document.getElementById("naming_convention");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Copied the text: " + copyText.value);
        }
    
    </script>
</head>
<style>
    #datatable_wrapper {
        padding: 30px;
    }

</style>
<?php 
    if(Auth::check()){
        $name = Auth::user()->name;
        $email = Auth::user()->email;
    }  
?>

<body>
    <script src="{{ asset('material_ui/assets/js/preloader.js') }}"></script>
    <div class="body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('material_ui.layouts.sidebar2')
        <!-- partial -->
        <div class="main-wrapper mdc-drawer-app-content">
            <!-- partial:partials/_navbar.html -->
            @include('material_ui.layouts.header')
            <!-- partial -->
            <div class="page-wrapper mdc-toolbar-fixed-adjust">
                <main class="content-wrapper">
                    @yield('content')
                </main>
                <!-- partial:partials/_footer.html -->
                @include('material_ui.layouts.footer')
                <!-- partial -->
            </div>
        </div>
    </div>
    @yield('script')
</body>
</html>
