@extends('layouts.master')

@section('title', 'Tạo ví')

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Nhập thông tin tiết kiệm</h5>
                        <form action="{{ route('wallets.savings.store', $wallet->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="input_date" class="col-md-2 col-form-label">Ngày</label>
                                        <div class="col-md-10">
                                            <input type="text" name="date" id="input_date"
                                                class="form-control singledate" readonly="readonly" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="input_type" class="col-md-2 col-form-label">Loại</label>
                                        <div class="col-md-10">
                                            <div class="bt-switch">
                                                <input type="checkbox" name="type" id="input_type"
                                                    data-on-color="warning" data-off-color="success" data-on-text="Tiền ra"
                                                    data-off-text="Tiền vào" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="input_amount" class="col-md-2 col-form-label">Số tiền</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control text-end" name="amount"
                                                id="input_amount" placeholder="Nhập số tiền" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="textarea_note" class="col-md-2 col-form-label">Ghi chú</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="note" id="textarea_note"
                                                placeholder="Nhập ghi chú">
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
    <script>
        $(
            ".bt-switch input[type='checkbox'], .bt-switch input[type='radio']"
        ).bootstrapSwitch();
        let radioswitch = (() => {
            return {
                init: () => {
                    $(".radio-switch").on("switch-change", () => {
                        $(".radio-switch").bootstrapSwitch("toggleRadioState");
                    });
                    $(".radio-switch").on("switch-change", () => {
                        $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck");
                    });
                    $(".radio-switch").on("switch-change", () => {
                        $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1);
                    });
                },
            };
        })();

        $(() => {
            radioswitch.init();
        });
    </script>
@endpush
