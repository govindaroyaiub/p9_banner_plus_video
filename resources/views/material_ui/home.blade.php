@extends('material_ui.layouts.app')

@section('content')

<div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8">
            <div class="mdc-card rounded-lg">
                <h6 class="card-title">Banner Projects Per Month</h6>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        
        <div
            class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
            <div class="mdc-card rounded-xl">
                <h6 class="card-title">Total Creative Projects</h6>
                <canvas id="doughnutChart" style="position: relative;
                top: 50%;
                transform: translateY(-50%);"></canvas>
            </div>
        </div>
    </div>
</div>


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
@endsection