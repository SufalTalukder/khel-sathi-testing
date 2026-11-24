@extends('layouts\eklavya_fund_layout')
@section('content')
    <div class="col-md-6">
        <div class="p-4 p-lg-4 login-form">
            <div class="text-center text-md-center mb-3 mt-md-0">
                <h3 class="mb-2">Applicant's Login/आवेदक का लॉगिन</h3>
                <div class="auth-register-callout my-2 text-center">
                    <div class="d-inline-block p-2 px-3 rounded-3" style="background: #f0f7ff; border: 1.5px dashed #0284c7; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.1);">
                        <div style="font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 4px;">
                            Don’t have an account? / क्या आपका अकाउंट नहीं है?
                        </div>
                        <a href="{{ url('eklavyaFund/registration') }}" class="btn btn-sm btn-primary rounded-pill px-4 py-1 fw-bold text-white shadow-sm" style="font-size: 0.88rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                            <i class="fas fa-user-plus me-1"></i> Register Here / अभी पंजीकरण करें &rarr;
                        </a>
                    </div>
                </div>
            </div>
            <form action="{{ url('eklavyaFund') }}" method="post" id="adminlogin" class="mt-4 row g-3 required" novalidate>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">1. Registered Email ID/पंजीकृत ईमेल आईडी</label>
                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control"
                                id="email" name="email" required>
                            <div class="invalid-feedback">
                                Please Enter Registered Email ID./कृपया पंजीकृत ईमेल आईडी भरें।
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group password" id="hidepwd">
                            <label for="password-field">2. Password/पासवर्ड</label>
                            <input type="password" class="form-control" id="password-field" name="password"
                                autocomplete="current-password" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <div class="invalid-feedback">
                                Please Enter Password./कृपया पासवर्ड भरें।
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <p>
                            <a href="forgot-password.html" class="small float-end">Forgot Password/पासवर्ड भूल गए?</a>
                        </p>
                    </div>
                </div>
                <!--<div class="form-group enterotp">
                    <label>2.Enter OTP <strong class="text-danger">*</strong></label>
                    <div class="input-group">
                        <input type="text" id="otp_data" name="otp_data" class="form-control form-control-user" placeholder="Enter OTP">
                        <div class="input-group-append">
                            <a href="javascript://" class="btn btn-info btn-lg resendotpLogin" type="submit">Resend OTP</a>
                        </div>
                    </div>
                    <span class="err_otp" style="color:red; display:none;"></span>
                </div>-->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="captcha">
                                <label> 3. Captcha/कैप्चा<span class="text-danger">*</span></label>
                                <span class="unselectable" id="cp_refresh">{{ $Code1 }}+{{ $Code2 }}</span>
                                <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4"
                                    value="{{ $Code1 + $Code2 }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 refresh">
                        <div class="form-group">
                            <div class="cp_refresh">
                                <a href="javascript:void(0)" title="Refresh Captcha"><span class="fas fa-redo"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="captcha">4. Enter Captcha/कैप्चा भरें</label>
                            <input name="captcha" id="captcha" type="text" required class="form-control">
                            <div class="invalid-feedback">
                                Please Enter Captcha./कृपया कैप्चा भरें।
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-center row">
                    <div class="col-md-6">
                        <button type="submit" class="btn w-100 btn-info">Login/लॉगिन करें<span
                                class="fa fa-arrow-right"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('custom-scripts')
    <script></script>
@endpush
