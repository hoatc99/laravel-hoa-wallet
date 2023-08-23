@extends('layouts.auth')

@section('title', 'Tạo ví')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="./index.html" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                        <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                    </a>
                    <div class="position-relative text-center my-4">
                        <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative fw-semibold">Đăng nhập</p>
                        <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                    </div>
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="input_email" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="input_email" name="email" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="input_password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="input_password" name="password" required>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a class="text-primary fw-medium" href="./authentication-forgot-password.html">Quên mật khẩu</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Đăng nhập</button>
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="fs-4 mb-0 fw-medium">New to Modernize?</p>
                            <a class="text-primary fw-medium ms-2" href="./authentication-register.html">Create an
                                account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
