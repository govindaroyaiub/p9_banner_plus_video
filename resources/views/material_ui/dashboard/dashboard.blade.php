@extends('material_ui.layouts.app')

@section('content')

<div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner" style="padding-top: 6rem; padding-bottom: 6rem;">
        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
            <div class="mdc-card">
                <h6 class="card-title">Creatives Per Month</h6>
                <canvas id="areaChart"></canvas>
            </div>
        </div>
        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
            <div class="mdc-card">
                <h6 class="card-title">Total Creatives</h6>
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var multiAreaData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                    label: 'Banner',
                    data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
                    borderColor: ['rgba(255, 66, 15, 0.5)'],
                    backgroundColor: ['rgba(255, 66, 15, 0.5)'],
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Video',
                    data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
                    borderColor: ['rgba(0, 187, 221, 0.5)'],
                    backgroundColor: ['rgba(0, 187, 221, 0.5)'],
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Social',
                    data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
                    borderColor: ['rgba(255, 193, 7, 0.5)'],
                    backgroundColor: ['rgba(255, 193, 7, 0.5)'],
                    borderWidth: 1,
                    fill: true
                }
            ]
        };
        var multiAreaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            },
            elements: {
                point: {
                    radius: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        }

        var areaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            }
        }

        var doughnutPieData = {
            datasets: [{
                data: [30, 40, 30],
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
                'Red',
                'Blue',
                'Yellow',
            ]
        };
        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };

        if ($("#areaChart").length) {
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: multiAreaData,
                options: areaOptions
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
