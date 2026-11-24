@extends('layouts\private_coaching_layout')
@section('content')
    <style>
        .cp_refresh {
            padding: 38px 0px 0px 0px;
        }
    </style>

    <div class="container-fluid">
        <a href="#" title="Instruction" class="help" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="item">
                <img src="{{ asset('facility_booking') }}/images/instruction.png" />
            </span>
            <div class="circle" style="animation-delay: 0s"></div>
            <div class="circle" style="animation-delay: 1s"></div>
            <div class="circle" style="animation-delay: 2s"></div>
            <div class="circle" style="animation-delay: 3s"></div>
        </a>
        <div class="row">
            <div class="col-md-6 loginsidebar">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-2 text-center mb-3"> <img src="{{ asset('RPCAA') }}/images/logo.png"
                            class="img-fluid"> </div>
                    <div class="col-md-12 col-12 deptname">
                        <h3 class="hd-org">Khel Sathi Portal/खेल साथी पोर्टल</h3>
                        <h5>
                            Department of Sports, Government of Uttar Pradesh<br>
                            खेल विभाग, उत्तर प्रदेश सरकार
                        </h5>
                    </div>
                    <div class="col-md-12 col-12 deptname">
                        <h5 class="text-danger">
                            {{-- Registration of Pvt. Coaching Academies / Associations ,Gyms, Swimming Pools<br />
                            निजी कोचिंग अकादमियों / संघों, जिम, और तरणताल का पंजीकरण --}}
                            Private Institutions Registration (Gyms & Swimming Pools)<br />
                            निजी संस्थान पंजीकरण (जिम एवं तरणताल)
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bg-light1">
                <div class="p-4 p-lg-5 login-form">
                    <div class="text-center text-md-center mb-3 mt-md-0">
                        <h3 class="mb-2">Applicant's Login/आवेदक का लॉगिन</h3>
                        <div class="auth-register-callout my-2 text-center">
                            <div class="d-inline-block p-2 px-3 rounded-3" style="background: #f0f7ff; border: 1.5px dashed #0284c7; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.1);">
                                <div style="font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 4px;">
                                    Don’t have an account? / क्या आपका अकाउंट नहीं है?
                                </div>
                                <a href="{{ route('private_coaching_register') }}" class="btn btn-sm btn-primary rounded-pill px-4 py-1 fw-bold text-white shadow-sm" style="font-size: 0.88rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                                    <i class="fas fa-user-plus me-1"></i> Create Account / खाता बनाएं &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('private_coaching_login_store') }}" id="submitform" class="mt-2 needs-validation"
                        novalidate method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">1. Registered Email ID/पंजीकृत ईमेल आईडी</label>
                            <input type="text" class="form-control" id="email" name="email"
                                oninput="this.value = this.value.toLowerCase();" maxlength="50" required>
                            {{-- <input type="email" class="form-control" id="email" pattern="^[^ ]+@[^ ]+\.[a-z]{2,6}$" name="email" placeholder="Email ID" maxlength="255" required> --}}
                        </div>
                        <div class="form-group mb-3">
                            <label for="password-field">2. Password/पासवर्ड</label>
                            <input type="password" name="password" class="form-control" id="password-field"
                                placeholder="Password" autocomplete="current-password" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="d-flex justify-content-end mb-3 align-items-top text-end">
                            <a href="{{ route('private_coaching_forgot_password') }}" class="small text-right">
                                <b>
                                    Forgot Password/पासवर्ड भूल गए?
                                </b>
                            </a>

                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-5">
                                <div class="captcha">
                                    <label class="btn-block">3. Captcha/कैप्चा</label>
                                    <!-- <img src="https://khelsathi.in/application/public/aplicant_template/images/captcha.jpg" alt="Captcha" title="Captcha"> -->
                                    <span class="unselectable" id="p_refresh">{{ $Code1 }}+{{ $Code2 }}</span>
                                    <input name="captchacode" type="hidden"
                                        class="form-control captchacode unselectable h4" value="{{ $Code1 + $Code2 }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-1 refresh">
                                <div class="cp_refresh">
                                    <a href="javascript:void(0)" title="Refresh Captcha" class="refresh343334"><span
                                            class="fas fa-redo"></span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>4. Enter Captcha/कैप्चा भरें</label>
                                <input name="captcha" type="text" class="form-control " placeholder="Captcha"
                                    value="{{ old('captcha') }}" required>
                                <div class="invalid-feedback">
                                    Please Enter Captcha.
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="justify-content-center row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-outline-success w-100"
                                    onclick="validateandcheck()">Login/लॉगिन करें</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(".refresh343334").on("click", function() {
            $.ajax({
                type: "GET",
                url: ajaxUrl + "/private_coaching/cp_refresh/",
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    $("#p_refresh").html(res.Code1 + '+' + res.Code2);
                    $(".captchacode").val(res.Code1 + res.Code2);
                    // $(".refreshc").val(res.capchaCode);
                },
            });
        });

        $("#submitform").submit(function(e) {
            e.preventDefault();
            if ($("#submitform")[0].checkValidity() === false) {
                e.stopPropagation();
            } else {
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {
                        if (res.error == false) {
                            success(res.msg);
                            window.location.href = res.url;
                        } else {
                            error(res.msg);
                        }
                    },
                });
            }
            $("#submitform").addClass("was-validated");
        });
    </script>
@endpush
@push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script type="text/javascript">
        function validateandcheck() {
            // alert(1)
            if ($("#password-field").val() != '') {
                var dataToEncrypt = $("#password-field").val();
                var encryptionKey = "2b7e151628aed2a6abf7158809cf4f3c";
                var keyHex = CryptoJS.enc.Hex.parse(encryptionKey);
                var encrypted = CryptoJS.AES.encrypt(dataToEncrypt, keyHex, {
                    mode: CryptoJS.mode.ECB
                });
                $("#password-field").val(encrypted.toString());

                var mdataToEncrypt = $("#email").val();
                var mencryptionKey = "2b7e151628aed2a6abf7158809cf4f3c";
                var mkeyHex = CryptoJS.enc.Hex.parse(mencryptionKey);
                var mencrypted = CryptoJS.AES.encrypt(mdataToEncrypt, mkeyHex, {
                    mode: CryptoJS.mode.ECB
                });
                $("#email").val(mencrypted.toString());

            };
        }

        $('#email').on('input', function() {
            $(this).val($(this).val().toLowerCase());
        });
    </script>
@endpush
