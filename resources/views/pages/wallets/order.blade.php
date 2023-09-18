@extends('layouts.master')

@section('title', 'Sắp xếp ví')

@section('content')
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fs-5 fw-semibold">Sắp xếp ví</h5>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-nowrap mb-0 text-center">
            <thead>
                <tr class="text-muted fw-semibold">
                    <th scope="col" class="col-1"></th>
                    <th scope="col" class="col-1">#</th>
                    <th scope="col" class="col-3">Thông tin ví</th>
                    <th scope="col" class="col-3">Số dư / Tiết kiệm</th>
                    <th scope="col" class="col-2">Tỷ lệ</th>
                    <th scope="col" class="col-2">Ngày tạo</th>
                    <th scope="col" class="col-2">Ẩn / Hiện</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="sorting">
                @foreach ($wallets as $wallet)
                    <tr data-id="{{ $wallet->id }}">
                        <td>
                            <i class="ti ti-menu-order order-icon h4" style="cursor: grab"></i>
                        </td>
                        <th scope="row">{{ $wallet->id }}</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2 pe-1 rounded-circle">
                                    <i class="{{ $wallet->icon_url }} display-6"
                                        style="color: {{ $wallet->color_hex }}"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $wallet->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>{{ formatNumber($wallet->current_balance) }} / {{ formatNumber($wallet->total_saving) }}</td>
                        <td>
                            <div class="mb-1 fw-semibold">{{ round($wallet->progress) }}%</div>
                            <div class="progress bg-light w-100 flex-1">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $wallet->progress }}%; height: 10px; background-color: {{ $wallet->color_hex }}">
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="fs-3 text-dark mb-0">{{ $wallet->created_at->format('d/m/Y') }}</p>
                        </td>
                        <td>
                            @if ($wallet->pivot->is_hidden)
                                <button class="btn"
                                    onclick="confirmUnhide({{ $wallet->id }}, '{{ $wallet->name }}')"><i
                                        class="ti ti-eye-off order-icon h4"></i></button>
                            @else
                                <button class="btn"
                                    onclick="confirmHide({{ $wallet->id }}, '{{ $wallet->name }}')"><i
                                        class="ti ti-eye order-icon h4"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form id="frm_set_visible" method="post">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        const confirmHide = (wallet_id, wallet_name) => {
            Swal.fire({
                title: 'Ẩn ví "' + wallet_name + '"?',
                text: "Ví đã ẩn không xuất hiện trong mục Danh sách ví.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Không',
                confirmButtonText: 'Tôi đồng ý'
            }).then((result) => {
                if (result.isConfirmed) {
                    let actionUrl = "{{ route('wallets.hide', ':wallet_id') }}";
                    actionUrl = actionUrl.replace(':wallet_id', wallet_id);
                    $('#frm_set_visible').attr('action', actionUrl).submit();
                }
            })
        }

        const confirmUnhide = (wallet_id, wallet_name) => {
            Swal.fire({
                title: 'Hiện ví "' + wallet_name + '"?',
                text: "Ví sẽ xuất hiện trong mục Danh sách ví.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Không',
                confirmButtonText: 'Tôi đồng ý'
            }).then((result) => {
                if (result.isConfirmed) {
                    let actionUrl = "{{ route('wallets.unhide', ':wallet_id') }}";
                    actionUrl = actionUrl.replace(':wallet_id', wallet_id);
                    $('#frm_set_visible').attr('action', actionUrl).submit();
                }
            })
        }

        let initialOrder = [];
        const sortable = new Sortable(sorting, {
            handle: '.order-icon',
            animation: 150,
            ghostClass: 'blue-background-class',
            onStart: (evt) => {
                initialOrder = sortable.toArray();
            },
            onEnd: (evt) => {
                let newOrder = [];
                $('#sorting > tr').each(function() {
                    let id = $(this).data('id');
                    newOrder.push(id);
                });
                updateOrder(newOrder);
            }
        });

        const updateOrder = (ids) => {
            $.post(`/api/wallets/update-order`, {
                _token: '{{ csrf_token() }}',
                ids: ids
            }, ).done(() => {
                renderToastr('success', 'Cập nhật thứ tự ví thành công!', 'Thành công');
            }).fail(() => {
                restoreOrder();
                renderToastr('error', 'Cập nhật thứ tự ví thất bại!', 'Lỗi');
            });
        }

        const restoreOrder = () => {
            sortable.sort(initialOrder);
        }
    </script>
@endpush
