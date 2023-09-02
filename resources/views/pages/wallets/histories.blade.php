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
                            <p class="card-subtitle mb-0">Lịch sử tiết kiệm</p>
                        </div>
                    </div>
                    <table id="table1" class="table table-striped border table-bordered table-hover w-100"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {
            const table = $('#table1').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json'
                },
                processing: true,
                serverSide: false,
                ordering: true,
                lengthChange: true,
                pageLength: 10,
                ajax: {
                    url: `/api/table/{{ $wallet->id }}`,
                    dataSrc: 'data',
                },
                columns: [{
                        title: '#',
                        data: 'id',
                    },
                    {
                        title: 'Loại',
                        data: 'type',
                        render: function(data, type, full, meta) {
                            let text = data ? 'Tiền ra' : 'Tiền vào';
                            let color = data ? 'danger' : 'success';
                            return `<span class="mb-1 badge rounded-pill font-medium bg-light-${color} text-${color}">${text}</span>`;
                        },
                    },
                    {
                        title: 'Số tiền',
                        data: 'amount',
                        render: function(data, type, full, meta) {
                            return data.toLocaleString();
                        },
                    },
                    {
                        title: 'Ghi chú',
                        data: 'note',
                    },
                ],
                order: [
                    [0, 'desc'],
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === "string" ?
                            i.replace(/[\$,]/g, "") * 1 :
                            typeof i === "number" ?
                            i :
                            0;
                    };

                    // Total over all pages
                    total = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(2, {
                            page: "current"
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(2).footer()).html(
                        "$" + pageTotal + " ( $" + total + " total)"
                    );
                },
            });
        });
    </script>
@endpush
