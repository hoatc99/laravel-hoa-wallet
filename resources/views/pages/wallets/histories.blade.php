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
        let dataTable = null;

        const renderTable = () => {
            let dataTableId = $('#table1');

            dataTable = renderDataTable(dataTableId, dataTable, `/api/wallets/{{ $wallet->id }}/getDataHistory`);
        }

        $(() => {
            renderTable();
        });
    </script>
@endpush
