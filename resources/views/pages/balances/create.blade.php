@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Nhập thông tin số dư</h5>
                        <form action="{{ route('wallets.balances.store', $wallet->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="input_amount" class="col-md-2 col-form-label">Số tiền</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control input-money" name="amount"
                                                id="input_amount" placeholder="Nhập số tiền" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-md-flex align-items-center mt-3">
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-send me-2 fs-4"></i>
                                                    Xác nhận
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
