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
                        <div class="d-flex align-items-center gap-2">
                            <select id="select_statistic_type" class="form-select w-auto">
                                <option value="0">Thống kê theo tháng</option>
                                <option value="1">Thống kê theo năm</option>
                            </select>
                            <div id="year_month"></div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div id="chart-line-basic"></div>
                        </div>
                    </div>
                    <div class="row">
                        <table id="table1" class="table table-striped border table-bordered table-hover w-100"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const statisticType = ['year-month-picker', 'year-picker'];

        let lineChart = null;
        let dataTable = null;

        const renderChart = (year, month) => {
            let chartId = document.querySelector('#chart-line-basic');

            $.get(`/api/wallets/{{ $wallet->id }}/getDataChart?year=${year}&month=${month}`,
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

                    lineChart = renderLineChart(chartId, lineChart, series, xcategories, $("#select_statistic_type").val());
                });
        }

        const renderTable = (year, month) => {
            let dataTableId = $('#table1');

            dataTable = renderDataTable(dataTableId, dataTable,
                `/api/wallets/{{ $wallet->id }}/getDataHistory?year=${year}&month=${month}`
                );
        }

        const renderStatisticData = () => {
            year = $("#input_year_month").val().split('/')[0] ?? '';
            month = $("#input_year_month").val().split('/')[1] ?? '';
            renderChart(year, month);
            renderTable(year, month);
        }

        const createDatePickerEle = (e) => {
            return input = $("<input>", {
                id: "input_year_month",
                class: "form-select w-auto " + statisticType[e.target.value],
                readOnly: true,
                required: true,
            }).on("change", () => {
                renderStatisticData();
            });
        }

        $(() => {
            $("#select_statistic_type").trigger("change");
        });

        $("#select_statistic_type").on("change", (e) => {
            $("#year_month").html(createDatePickerEle(e));
            loadDatePicker();
        });
    </script>
@endpush
