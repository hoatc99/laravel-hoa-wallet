@extends('layouts.master')

@section('title', 'Chỉnh sửa ví')

@section('content')
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fs-5 fw-semibold">Chỉnh sửa ví</h5>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Nhập thông tin ví</h5>
                    <form class="form" action="{{ route('wallets.update', $wallet->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3 row">
                            <label for="input_name" class="col-md-2 col-form-label">Tên ví</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" id="input_name" maxlength="20"
                                    placeholder="Nhập tên ví" value="{{ $wallet->name }}" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="input_color" class="col-md-2 col-form-label">Chọn màu ví</label>
                            <div class="col-md-10">
                                <input type="color" id="input_color" name="color_hex" id="input_color"
                                    class="form-control" value="{{ $wallet->color_hex }}" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="input_icon" class="col-md-2 col-form-label">Biểu tượng</label>
                            <div class="col-md-10">
                                <select class="selectpicker w-100" name="icon_url" id="input_icon" data-live-search="true"
                                    required>
                                    @foreach ($icons as $icon)
                                        <option data-icon="{{ $icon }} me-2" value="{{ $icon }}"
                                            {{ $wallet->icon_url == $icon ? 'selected' : null }}>
                                            {{ $icon }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-md-flex align-items-center mt-3">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-send me-2 fs-4"></i>
                                            Cập nhật ví
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Xem trước</h5>
                    <div class="card card-hover border border-2" id="wallet_color">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="bg-light-warning text-warning d-inline-block px-4 py-3 rounded"
                                    id="wallet_icon"></div>
                            </div>
                            <div class="mt-4">
                                <h4 class="card-title" id="wallet_name"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {
            load_wallet_preview();
        });

        $('#input_icon').on('change', () => {
            load_wallet_preview();
        });

        $('#input_color').on('input', () => {
            load_wallet_preview();
        });

        $('#input_name').on('input', () => {
            load_wallet_preview();
        });

        const load_wallet_preview = () => {
            $('#wallet_color').attr('style', `border-color: ${$('#input_color').val()} !important;`);
            $('#wallet_icon').html(`<i class="${$('#input_icon').val()} display-6"></i>`);
            $('#wallet_name').text($('#input_name').val());
        }
    </script>
@endpush
