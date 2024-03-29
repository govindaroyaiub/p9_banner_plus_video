@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        @if (session('status'))
            <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="md:flex mx-4">
            @include('sidebar')
            <div class="flex-1 mx-4">
                @include('alert')
                <h3 class="text-2xl underline font-semibold tracking-wide text-center">Statistical Overview</h3>
                <div id="donutchart" style="height: 350px;" class="mt-4"></div>
                <div id="monthly_chart" style="height: 350px;" class="mt-4"></div>

                <div class="flex justify-between w-full mt-4">
                    <h3 class="text-2xl underline font-semibold tracking-wide">Users</h3>
                    @if(Auth::user()->is_admin == 1 && Auth::user()->company_id == 1)
                    <a href="/user/add">
                        <button 
                          type="button"
                          class="leading-tight mb-4 md:mb-0 bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white">
                          Add User
                        </button>
                    </a>
                    @endif
                </div>
                <table id="datatable" class="stripe hover table w-full mt-4" style="width:100%; padding-top: 1rem;  padding-bottom: 1rem;">
                    <thead>
                    <tr>
                        <th class="bg-gray-200 px-4 py-2">No.</th>
                        <th class="bg-gray-200 px-4 py-2">Name</th>
                        <th class="bg-gray-200 px-4 py-2">Email</th>
                        @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                        <th class="bg-gray-200 px-4 py-2">Company</th>
                        @endif
                        @if(Auth::user()->is_admin == 1)
                        <th class="bg-gray-200 px-4 py-2">Status</th>
                        <th class="bg-gray-200 px-4 py-2">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                    @foreach($user_list as $user)
                        <tr style="text-align: center;">
                            <td class="border px-4 py-2">{{$i++}}</td>
                            <td class="border px-4 py-2">{{ $user->username }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            @if(url('/') == 'http://localhost:8000' || url('/') == 'https://creative.planetnine.com')
                            <td class="border px-4 py-2">{{ $user->logoname }}</td>
                            @endif
                            @if(Auth::user()->is_admin == 1)
                            @if($user->is_admin == 1)
                            <td class="border px-4 py-2">
                                <span class="text-sm bg-red-500 text-white rounded-full px-2 py-1">Admin</span>
                            </td>
                            @else
                            <td class="border px-4 py-2">
                                <span class="text-sm bg-green-500 text-white rounded-full px-2 py-1">User</span>
                            </td>
                            @endif
                            <td class="border px-4 py-2">
                            <a href="/user/edit/{{$user->id}}">
                                <button type="button"
                                    class="bg-blue-600 text-gray-900 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="/user/delete/{{$user->id}}" onclick="return confirm('Are you sure you want to delete this user?');">
                                <button type="button"
                                    class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">
                                    <svg class="w-6 h-6 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Creatives', 'Count'],
          ['Banner: {{ $total_banner_projects_count }}', {{ $total_banner_projects_count }}],
          ['Video: {{ $total_video_projects }}', {{ $total_video_projects }}],
          ['Gif: {{ $total_gif_projects }}', {{ $total_gif_projects }}],
          ['Social Image: {{ $total_social_projects }}', {{ $total_social_projects }}]
        ]);

        var options = {
          title: 'Creative Projects',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Banner Upload Per Month (Total: {{ $total_banners }})', 'Count'],
            ['Jan', {{ $jan }}],
            ['Feb', {{ $feb }}],
            ['Mar', {{ $mar }}],
            ['Apr', {{ $apr }}],
            ['May', {{ $may }}],
            ['Jun', {{ $jun }}],
            ['Jul', {{ $jul }}],
            ['Aug', {{ $aug }}],
            ['Sep', {{ $sep }}],
            ['Oct', {{ $oct }}],
            ['Nov', {{ $nov }}],
            ['Dec', {{ $dec }}]

          ]);

        var options = {
          legend: { position: "none" }
        };

        var chart = new google.charts.Bar(document.getElementById('monthly_chart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
      
@endsection
