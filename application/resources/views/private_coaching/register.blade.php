@extends('layouts\private_coaching_layout')
@section('content')
    <div class="container-fluid">
        <a href="#" title="Instruction" class="help" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="item"> <img src="{{ url('RPCAA') }}/images/instruction.png" /> </span>
            <div class="circle" style="animation-delay: 0s"></div>
            <div class="circle" style="animation-delay: 1s"></div>
            <div class="circle" style="animation-delay: 2s"></div>
            <div class="circle" style="animation-delay: 3s"></div>
        </a>
        <div class="row">
            <div class="col-md-6 loginsidebar">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-2 text-center mb-3"> <img src="{{ url('RPCAA') }}/images/logo.png"
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
                            {{-- Registration of Pvt. Coaching Academies / Associations ,Gyms, Swimming Pools<br /> निजी कोचिंग
                            अकादमियों / संघों, जिम, और तरणताल का पंजीकरण --}}
                            Private Institutions Registration (Gyms & Swimming Pools)<br /> निजी संस्थान पंजीकरण (जिम एवं तरणताल)
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bg-light1">
                <div class="login-form">
                    <div class="text-center text-md-center mt-md-0">
                        <h3 class="mb-2">Registration/पंजीकरण</h3>
                        <div class="auth-login-callout my-2 text-center">
                            <div class="d-inline-block p-2 px-3 rounded-3" style="background: #f0fdf4; border: 1.5px dashed #16a34a; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);">
                                <div style="font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 4px;">
                                    Already Registered? / क्या पहले से पंजीकृत हैं?
                                </div>
                                <a href="{{ route('private_coaching_login') }}" class="btn btn-sm btn-success rounded-pill px-4 py-1 fw-bold text-white shadow-sm" style="font-size: 0.88rem; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border: none;">
                                    <i class="fas fa-sign-in-alt me-1"></i> Click Here to Login / अभी लॉगिन करें &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('private_coaching_register_store') }}" id="submitform"
                        class="mt-2 needs-validation" novalidate method="post">
                        @csrf
                        <div class="form-group">
                            <label>1. Full Name/पूरा नाम</label>
                            <input type="text" class="form-control" id="fname" name="name"
                                onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))'
                                pattern="^[A-Za-z -]+$" maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <label>2. Designation/पदनाम</label>
                            <input type="text" class="form-control" id="fname" name="designation"
                                onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))'
                                pattern="^[A-Za-z -]+$" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label>3. Email ID/ईमेल आईडी</label>
                            <input type="text" class="form-control" pattern="^[^ ]+@[^ ]+\.[a-z]{2,6}$" id="email"
                                name="email" placeholder="Email ID" oninput="this.value = this.value.toLowerCase();"
                                maxlength="50" required>
                        </div>
                        <div class="form-group row ">
                            <label>4. Mobile No./मोबाइल नंबर</label>
                            <div class="input-group">
                                <div class="input-group-prepend"> <span class="input-group-text"
                                        style="padding: 0.5rem 0.75rem;">+91</span> </div>
                                <input type="text" name="mobile" class="form-control" pattern="[6-9][0-9]{9}$"
                                    maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>5. Aadhar No./आधार नंबर</label>
                            <input type="text" name="aadhar_no" class="form-control" pattern="[2-9]{1}[0-9]{11}"
                                maxlength="12" minlength="12"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                required>

                        </div>
                        <div class="form-group">
                            <label>5. Captcha/कैप्चा</label>
                            <div class="row">
                                <div class="col-lg-5"> <span id="captchaDiv"> <span class="unselectable"
                                            id="p_refresh">{{ $Code1 }}+{{ $Code2 }}</span>

                                        <input name="captchacode" type="hidden"
                                            class="form-control captchacode unselectable h4" value="{{ $Code1 + $Code2 }}"
                                            readonly>
                                    </span> </div>
                                <div class="col-md-1 refresh">
                                    <div class="cp_refresh"><a href="javascript:void(0)" class="refresh4554554"
                                            title="Refresh Captcha"><span class="fas fa-redo"></span></a> </div>
                                </div>
                                <div class="col-lg-6">
                                    <input name="captcha" type="text" placeholder="Enter Captcha" class="form-control"
                                        required>
                                    <small class="text-muted"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <button type="submit" class="btn btn-outline-success "><i class="fa fa-user-plus"></i>
                                    Register <span class="fa fa-arrow-right"></span></button>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="reset" class="btn btn-outline-secondary "><i class="fa fa-undo"></i>
                                    Reset</button>
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
        $(".refresh4554554").on("click", function() {
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

        $('#email').on('input', function() {
            $(this).val($(this).val().toLowerCase());
        });
    </script>
@endpush
