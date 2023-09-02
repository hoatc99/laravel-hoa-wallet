@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fs-5 fw-semibold">Danh sách ví</h5>
        <div>
            <button class="btn btn-warning">Sắp xếp thứ tự ví</button>
            <a href="{{ route('wallets.create') }}" class="btn btn-primary">Tạo ví mới</a>
        </div>
    </div>

    <div class="row" id="sortable">
        @foreach ($wallets as $wallet)
            <div class="col-md-6 col-lg-4" data-id="{{ $wallet->id }}">
                <div class="card card-hover border border-2" style="border-color: {{ $wallet->color_hex }} !important">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="bg-light-warning text-warning d-inline-block px-4 py-3 rounded">
                                <i class="{{ $wallet->icon_url }} display-6"></i>
                            </div>
                            <div class="ms-auto">
                                <div class="dropdown dropstart">
                                    <a href="#" class="link text-dark" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots fs-7"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Chọn hành động</h6>
                                        </li>
                                        @if ($wallet->total_saving > 0)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('wallets.balances.create', $wallet->id) }}">Cập nhật số
                                                    dư</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('wallets.savings.create', $wallet->id) }}">Cập nhật tiết
                                                kiệm</a>
                                        </li>
                                        @if ($wallet->total_saving > 0)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('wallets.statistics', $wallet->id) }}">Xem thống kê</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('wallets.histories', $wallet->id) }}">Xem lịch sử tiết
                                                    kiệm</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('wallets.edit', $wallet->id) }}">Sửa
                                                thông tin ví</a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger"
                                                onclick="confirmDelete('{{ $wallet->name }}')">Xóa
                                                ví</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="card-title">{{ $wallet->name }}</h4>
                            <h6 class="card-subtitle mb-1 text-muted">{{ round($wallet->progress) }}%</h6>
                            <div class="progress mt-4 bg-light">
                                <div class="progress-bar"
                                    style="width: {{ $wallet->progress }}%; height: 10px; background-color: {{ $wallet->color_hex }}"
                                    role="progressbar">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <div class="cursor-pointer" data-bs-toggle="popover" data-bs-placement="top"
                                    data-bs-container="body" data-bs-html="true" data-bs-trigger="hover click"
                                    data-bs-content="<strong class='fs-3'>{{ number_format($wallet->current_balance) }}</strong>">
                                    <span class="fs-5 fw-semibold">{{ formatNumber($wallet->current_balance) }}</span>
                                    <h6 class="text-muted fs-2">Số dư</h6>
                                </div>
                                <div class="ms-auto cursor-pointer" data-bs-toggle="popover" data-bs-placement="top"
                                    data-bs-container="body" data-bs-html="true" data-bs-trigger="hover click"
                                    data-bs-content="<strong class='fs-3'>{{ number_format($wallet->total_saving) }}</strong>">
                                    <span class="fs-5 fw-semibold">{{ formatNumber($wallet->total_saving) }}</span>
                                    <h6 class="text-muted fs-2 text-end">Tiết kiệm</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        const confirmDelete = (wname) => {
            Swal.fire({
                title: 'Xóa ví "' + wname + '"?',
                text: "Ví đã xóa không thể khôi phục.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tôi đồng ý'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }

        new Sortable(sortable, {
            animation: 150,
            ghostClass: 'blue-background-class',
            onEnd: function(evt) {
                var newOrder = [];
                $('#sortable > div').each(function() {
                    var id = $(this).data('id');
                    newOrder.push(id);
                });

                // newOrder bây giờ chứa danh sách thứ tự mới của các phần tử
                console.log(newOrder);
            }
        });
    </script>
@endpush