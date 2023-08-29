@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Ví Momo</h5>
                            <p class="card-subtitle mb-0">Biểu đồ thống kê</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fs-4">Tháng</div>
                            <select class="form-select w-auto" id="input_month">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8" selected>8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <div class="fs-4">năm</div>
                            <select class="form-select w-auto" id="input_year">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023" selected>2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div id="chart-line-basic"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            let chart_line = null;

            const renderChart = () => {
                if (chart_line !== null) {
                    chart_line.destroy();
                }
                let year = $('#input_year').val();
                let month = $('#input_month').val();
                $.get(`/api/chart/9?year=${year}&month=${month}`, function(data) {
                    let options_line = {
                        series: [{
                                name: "Tiết kiệm",
                                data: data.savings,
                            },
                            {
                                name: "Số dư",
                                data: data.balances,
                            },
                        ],
                        chart: {
                            height: 350,
                            type: "line",
                            dropShadow: {
                                enabled: true,
                                color: "#000",
                                top: 18,
                                left: 7,
                                blur: 10,
                                opacity: 0.2,
                            },
                            fontFamily: '"Nunito Sans",sans-serif',
                            zoom: {
                                enabled: true,
                            },
                            toolbar: {
                                show: true,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        colors: ["#fa896b", "#3dd9eb"],
                        stroke: {
                            curve: "smooth",
                        },
                        grid: {
                            borderColor: "rgba(0,0,0,0.3)",
                            strokeDashArray: 3,
                            xaxis: {
                                lines: {
                                    show: false,
                                },
                            },
                        },
                        xaxis: {
                            categories: data.days,
                            labels: {
                                style: {
                                    colors: "#a1aab2",
                                },
                            },
                            tickAmount: 7,
                        },
                        yaxis: {
                            labels: {
                                formatter: function(val) {
                                    val /= 1000
                                    return val.toLocaleString() + 'K'
                                },
                                style: {
                                    colors: "#a1aab2",
                                },
                            },
                        },
                        tooltip: {
                            theme: "dark",
                        },
                    };


                    chart_line = new ApexCharts(
                        document.querySelector("#chart-line-basic"),
                        options_line
                    );
                    chart_line.render();
                });
            }

            $('#input_year').on('change', () => {
                renderChart();
            });

            $('#input_month').on('change', () => {
                renderChart();
            });

            $(() => {
                renderChart();
            });
        </script>
    @endpush
