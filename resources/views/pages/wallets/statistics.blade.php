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
                            <input type="text" name="year_month" id="input_year_month"
                                class="form-control year-month-picker" readonly="readonly" required />
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
            let year = $("#input_year_month").val().split('/')[1];
            let month = $("#input_year_month").val().split('/')[0];
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

        $("#input_year_month").on("change", () => {
            renderChart();
        });

        $(() => {
            renderChart();
        });
    </script>
@endpush
