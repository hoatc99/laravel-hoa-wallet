@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">{{ $wallet->name }}</h5>
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
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/apexcharts.js') }}"></script>
    <script>
        let lineChart = null;

        const renderChart = () => {
            let year = $("#input_year").val();
            let month = $("#input_month").val();
            let chartId = document.querySelector('#chart-line-basic');

            $.get(`/api/chart/{{ $wallet->id }}?year=${year}&month=${month}`,
                (data) => {
                    let series = [{
                            name: "Tiết kiệm",
                            data: data.savings,
                        },
                        {
                            name: "Số dư",
                            data: data.balances,
                        },
                    ];

                    let xcategories = data.days;

                    lineChart = renderLineChart(chartId, lineChart, series, xcategories);
                });
        }

        $("#input_year").on("change", () => {
            renderChart();
        });

        $("#input_month").on("change", () => {
            renderChart();
        });

        $(() => {
            renderChart();
        });
    </script>
@endpush
