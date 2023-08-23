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
                                    <div class="mb-3">
                                        <label for="input_amount" class="form-label">Số tiền</label>
                                        <input type="text" class="form-control text-end" name="amount" id="input_amount"
                                            placeholder="Nhập số tiền" />
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
        var radioswitch = (function() {
            var bt = function() {
                $(".radio-switch").on("switch-change", function() {
                        $(".radio-switch").bootstrapSwitch("toggleRadioState");
                    }),
                    $(".radio-switch").on("switch-change", function() {
                        $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck");
                    }),
                    $(".radio-switch").on("switch-change", function() {
                        $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1);
                    });
            };
            return {
                init: function() {
                    bt();
                },
            };
        })();
        $(document).ready(function() {
            radioswitch.init();
        });

        $(function(e) {
            "use strict";
            $("#input_amount").inputmask("currency", {
                radixPoint: ".",
                groupSeparator: ",",
                digits: 0,
                autoGroup: true,
                suffix: ',000',
            });

            $('#input_amount').on('click focus', function() {
                let newPosition = $('#input_amount').val().length - 3;
                $(this)[0].setSelectionRange(newPosition, newPosition);
            });
        });
    </script>
@endpush
