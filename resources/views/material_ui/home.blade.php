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
    #datatable_wrapper{
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-2 mb-sm-0">DEMO DATA</h4>
                                        <div class="d-flex justtify-content-between align-items-center">
                                            <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">Goal reached</p>
                                            <i class="material-icons options-icon">more_vert</i>
                                        </div>
                                    </div>
                                    <div class="d-block d-sm-flex justify-content-between align-items-center">
                                        <h6 class="card-sub-title mb-0">Sales performance revenue based by country</h6>
                                        <div class="mdc-tab-wrapper revenue-tab mdc-tab--secondary">
                                            <div class="mdc-tab-bar" role="tablist">
                                                <div class="mdc-tab-scroller">
                                                    <div class="mdc-tab-scroller__scroll-area">
                                                        <div class="mdc-tab-scroller__scroll-content">
                                                            <button class="mdc-tab mdc-tab--active" role="tab"
                                                                aria-selected="true" tabindex="0">
                                                                <span class="mdc-tab__content">
                                                                    <span class="mdc-tab__text-label">1W</span>
                                                                </span>
                                                                <span
                                                                    class="mdc-tab-indicator mdc-tab-indicator--active">
                                                                    <span
                                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                                </span>
                                                                <span class="mdc-tab__ripple"></span>
                                                            </button>
                                                            <button class="mdc-tab mdc-tab" role="tab"
                                                                aria-selected="true" tabindex="0">
                                                                <span class="mdc-tab__content">
                                                                    <span class="mdc-tab__text-label">1M</span>
                                                                </span>
                                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                                    <span
                                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                                </span>
                                                                <span class="mdc-tab__ripple"></span>
                                                            </button>
                                                            <button class="mdc-tab mdc-tab" role="tab"
                                                                aria-selected="true" tabindex="0">
                                                                <span class="mdc-tab__content">
                                                                    <span class="mdc-tab__text-label">3M</span>
                                                                </span>
                                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                                    <span
                                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                                </span>
                                                                <span class="mdc-tab__ripple"></span>
                                                            </button>
                                                            <button class="mdc-tab mdc-tab" role="tab"
                                                                aria-selected="true" tabindex="0">
                                                                <span class="mdc-tab__content">
                                                                    <span class="mdc-tab__text-label">1Y</span>
                                                                </span>
                                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                                    <span
                                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                                </span>
                                                                <span class="mdc-tab__ripple"></span>
                                                            </button>
                                                            <button class="mdc-tab mdc-tab" role="tab"
                                                                aria-selected="true" tabindex="0">
                                                                <span class="mdc-tab__content">
                                                                    <span class="mdc-tab__text-label">ALL</span>
                                                                </span>
                                                                <span class="mdc-tab-indicator mdc-tab-indicator">
                                                                    <span
                                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                                </span>
                                                                <span class="mdc-tab__ripple"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content content--active">
                                            </div>
                                            <div class="content">
                                            </div>
                                            <div class="content">
                                            </div>
                                            <div class="content">
                                            </div>
                                            <div class="content">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-container mt-4">
                                        <canvas id="revenue-chart" height="260"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
                                <div class="mdc-card">
                                    <div class="d-flex d-lg-block d-xl-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">DEMO DATA</h4>
                                            <h6 class="card-sub-title">Customers 58.39k</h6>
                                        </div>
                                        <div id="sales-legend" class="d-flex flex-wrap"></div>
                                    </div>
                                    <div class="chart-container mt-4">
                                        <canvas id="chart-sales" height="260"></canvas>
                                    </div>
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
                                                    <button class="mdc-button mdc-button--raised filled-button--warning">
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
</body>

</html>
