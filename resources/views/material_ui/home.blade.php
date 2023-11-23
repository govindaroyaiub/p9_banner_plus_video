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
        <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
            <div class="mdc-drawer__header">
                <a href="index.html" class="brand-logo">
                    <img src="{{ asset('logo_images/planetnine.gif') }}" alt="logo" style="width: 93%;">
                </a>
            </div>
            <div class="mdc-drawer__content">
                <div class="user-info">
                    <p class="name">{{ $name }}</p>
                    <p class="email">{{ $email }}</p>
                </div>
                @include('material_ui.sidebar')
            </div>
        </aside>
        <!-- partial -->
        <div class="main-wrapper mdc-drawer-app-content">
            <!-- partial:partials/_navbar.html -->
            <header class="mdc-top-app-bar">
                <div class="mdc-top-app-bar__row">
                    <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                        <button
                            class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
                        <span class="mdc-top-app-bar__title">Greetings {{ $name }}!</span>
                    </div>
                    <div
                        class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
                        <div class="menu-button-container menu-profile d-none d-md-block">
                            <button class="mdc-button mdc-menu-button">
                                <span class="d-flex align-items-center">
                                    <span class="user-name">{{ $name }}</span>
                                </span>
                            </button>
                            <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                                    <li class="mdc-list-item" role="menuitem">
                                        <div class="item-thumbnail item-thumbnail-icon-only">
                                            <i class="mdi mdi-account-edit-outline text-primary"></i>
                                        </div>
                                        <div
                                            class="item-content d-flex align-items-start flex-column justify-content-center">
                                            <h6 class="item-subject font-weight-normal">
                                                <a href="/change-password">
                                                    Change Password
                                                </a>
                                            </h6>
                                        </div>
                                    </li>
                                    <li class="mdc-list-item" role="menuitem">
                                        <div class="item-thumbnail item-thumbnail-icon-only">
                                            <i class="mdi mdi-logout text-primary"></i>
                                        </div>
                                        <div
                                            class="item-content d-flex align-items-start flex-column justify-content-center">
                                            <h6 class="item-subject font-weight-normal">
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                            document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="hidden">
                                                    @csrf
                                                </form>
                                            </h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="divider d-none d-md-block"></div>
                    </div>
                </div>
            </header>
            <!-- partial -->
            <div class="page-wrapper mdc-toolbar-fixed-adjust">
                <main class="content-wrapper">
                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">
                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
                                <div class="mdc-card">
                                    <h6 class="card-title">Banner Projects Per Month</h6>
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                            
                            <div
                                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
                                <div class="mdc-card">
                                    <h6 class="card-title">Total Creative Projects</h6>
                                    <canvas id="doughnutChart" style="position: relative;
                                    top: 50%;
                                    transform: translateY(-50%);"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card p-0">
                            <h6 class="card-title card-padding pb-0">Users</h6>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hoverable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">Name</th>
                                            <th style="text-align: center;">Email</th>
                                            <th style="text-align: center;">Coompany</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i=1; ?>
                                    <tbody>
                                        @foreach($user_list as $user)
                                        <tr>
                                            <td style="text-align: center;">{{$i++}}</td>
                                            <td style="text-align: center;">{{ $user->username }}</td>
                                            <td style="text-align: center;">{{ $user->email }}</td>
                                            @if(url('/') == 'http://localhost:8000' || url('/') ==
                                            'https://creative.planetnine.com')
                                            <td style="text-align: center;">{{ $user->logoname }}</td>
                                            @endif
                                            @if(Auth::user()->is_admin == 1)
                                            @if($user->is_admin == 1)
                                            <td style="text-align: center;">
                                                <span class="mdc-button mdc-button--raised filled-button--secondary">
                                                    Admin
                                                </span>
                                            </td>
                                            @else
                                            <td style="text-align: center;">
                                                <span class="mdc-button mdc-button--raised filled-button--success">
                                                    User
                                                </span>
                                            </td>
                                            @endif
                                            <td style="text-align: center;">
                                                <a href="/user/edit/{{$user->id}}">
                                                    <button class="mdc-button mdc-button--raised filled-button--info">
                                                        Edit
                                                    </button>
                                                </a>
                                                <a href="/user/delete/{{$user->id}}"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <button
                                                        class="mdc-button mdc-button--raised filled-button--warning">
                                                        Delete
                                                    </button>
                                                </a>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <!-- partial:partials/_footer.html -->
                @include('material_ui.footer')
                <!-- partial -->
            </div>
        </div>
    </div>
    <!-- plugins:js -->
    <script src="{{ asset('material_ui/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{ asset('material_ui/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('material_ui/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('material_ui/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('material_ui/assets/js/material.js') }}"></script>
    <script src="{{ asset('material_ui/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('material_ui/assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
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

    </script>

    <script>
        $(function () {
            var data = {
                labels: ["Jan", "Feb", "March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: 'Amount',
                    data: [{{$jan}}, {{$feb}}, {{$mar}}, {{$apr}}, {{$may}}, {{$jun}}, {{$jul}}, {{$aug}}, {{$sep}}, {{$oct}}, {{$nov}}, {{$dec}}],
                    backgroundColor: [
                        'rgba(255, 66, 15, 0.7)',
                        'rgba(0, 187, 221, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(0, 182, 122, 0.7)',
                        'rgba(255, 66, 15, 0.7)',
                        'rgba(0, 187, 221, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(0, 182, 122, 0.7)',
                        'rgba(255, 66, 15, 0.7)',
                        'rgba(0, 187, 221, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(0, 182, 122, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 66, 15, 1)',
                        'rgba(0, 187, 221, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 182, 122, 1)',
                        'rgba(255, 66, 15, 1)',
                        'rgba(0, 187, 221, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 182, 122, 1)',
                        'rgba(255, 66, 15, 1)',
                        'rgba(0, 187, 221, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 182, 122, 1)',
                    ],
                    borderWidth: 1,
                    fill: false
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }

            };
            var doughnutPieData = {
                datasets: [{
                    data: [{{ $total_banner_projects_count }}, {{ $total_video_projects }}, {{ $total_gif_projects }}, {{ $total_social_projects }}],
                    backgroundColor: [
                        'rgba(255, 66, 15, 0.8)',
                        'rgba(0, 187, 221, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(0, 182, 122, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 66, 15,1)',
                        'rgba(0, 187, 221, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 182, 122, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Banners',
                    'Videos',
                    'Gifs',
                    'Socials'
                ]
            };
            var doughnutPieOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };
            if ($("#barChart").length) {
                var barChartCanvas = $("#barChart").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var barChart = new Chart(barChartCanvas, {
                    type: 'bar',
                    data: data,
                    options: options
                });
            }
            if ($("#doughnutChart").length) {
                var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
                var doughnutChart = new Chart(doughnutChartCanvas, {
                    type: 'doughnut',
                    data: doughnutPieData,
                    options: doughnutPieOptions
                });
            }
        });

    </script>
</body>

</html>
