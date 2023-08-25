@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fs-5 fw-semibold">Danh sách ví</h5>
        <a href="{{ route('wallets.create') }}" class="btn btn-primary">Tạo ví mới</a>
    </div>

    <div class="row">
        @foreach ($wallets as $wallet)
            <div class="col-md-6 col-lg-4">
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
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('wallets.savings.create', $wallet->id) }}">Cập nhật tiết
                                                kiệm</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('wallets.balances.create', $wallet->id) }}">Cập nhật số
                                                dư</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Xem lịch sử tiết kiệm</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Xem thống kê số dư</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('wallets.edit', $wallet->id) }}">Sửa
                                                thông tin ví</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#">Xóa ví</a>
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
                                    style="width: {{ $wallet->progress }}%; height: 6px; background-color: {{ $wallet->color_hex }}"
                                    role="progressbar">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <div>
                                    <span class="fs-5 fw-semibold">{{ number_format($wallet->current_balance) }}</span>
                                    <h6 class="text-muted fs-2">Số dư</h6>
                                </div>
                                <div class="ms-auto">
                                    <span class="fs-5 fw-semibold">{{ number_format($wallet->total_saving) }}</span>
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
