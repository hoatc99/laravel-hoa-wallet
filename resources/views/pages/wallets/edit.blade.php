@extends('layouts.master')

@section('title', 'Chỉnh sửa ví')

@section('content')
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fs-5 fw-semibold">Chỉnh sửa ví</h5>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Nhập thông tin ví</h5>
                    <form class="form" action="{{ route('wallets.update', $wallet->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3 row">
                            <label for="input_name" class="col-md-2 col-form-label">Tên ví</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" id="input_name"
                                    placeholder="Nhập tên ví" value="{{ $wallet->name }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="input_color" class="col-md-2 col-form-label">Chọn màu ví</label>
                            <div class="col-md-10">
                                <input type="color" id="input_color" name="color_hex" class="form-control"
                                    data-control="hue" value="{{ $wallet->color_hex }}" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="input_icon" class="col-md-2 col-form-label">Biểu tượng</label>
                            <div class="col-md-10">
                                <select class="selectpicker w-100" name="icon_url" data-live-search="true">
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
    </div>
@endsection

@push('scripts')
    <script>
        $(".color").each(function() {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr("data-control") || "hue",
                defaultValue: $(this).attr("data-defaultValue") || "",
                format: $(this).attr("data-format") || "hex",
                keywords: $(this).attr("data-keywords") || "",
                inline: $(this).attr("data-inline") === "true",
                letterCase: $(this).attr("data-letterCase") || "lowercase",
                opacity: $(this).attr("data-opacity"),
                position: $(this).attr("data-position") || "bottom left",
                swatches: $(this).attr("data-swatches") ?
                    $(this).attr("data-swatches").split("|") : [],
                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ", " + opacity;
                    if (typeof console === "object") {
                        console.log(value);
                    }
                },
                theme: "bootstrap",
            });
        });
    </script>
@endpush
