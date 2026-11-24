@extends( 'layouts\gymnasium_swimming_layout' )
@section('content')

<div class="col-md-6 bg-light1">
    <div class="pt-4 pb-5 login-form">
        <div class="text-center text-md-center mt-md-0">
            <h3 class="mb-2">Registration / पंजीकरण</h3>
            <div class="auth-login-callout my-2 text-center">
                <div class="d-inline-block p-2 px-3 rounded-3" style="background: #f0fdf4; border: 1.5px dashed #16a34a; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);">
                    <div style="font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 4px;">
                        Already Registered? / क्या पहले से पंजीकृत हैं?
                    </div>
                    <a href="{{ route('gymnasium_swimming_login') }}" class="btn btn-sm btn-success rounded-pill px-4 py-1 fw-bold text-white shadow-sm" style="font-size: 0.88rem; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border: none;">
                        <i class="fas fa-sign-in-alt me-1"></i> Click Here to Login / अभी लॉगिन करें &rarr;
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ route('gymnasium_swimmingregistration_store') }}" method="post" class="mt-2 needs-validation" novalidate id="gymsubmit">
            @csrf
            <div class="alert alert-success bg-transparent fade show p-2 mb-2" role="alert">
                <ul class="mb-0">
                    <li>यहां दर्ज की गई जानकारी को सबमिट करने के बाद संशोधित नहीं किया जा सकता / Information entered here can not be modified after submitting.</li>
                </ul>
            </div>
            <div id="ageLimitError" class="d-none">
                <div class="alert alert-danger fade show fs-14" role="alert">
                    Kindly note that the minimum age for admission to Std 6 and above is minimum admissible age is 8 to 12 years as on 01-04-2023.
                </div>
            </div>
            <div id="formError" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                Invalid Captcha Code. Please try again.
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group row required radio-group mb-2" aria-required="true">
                        <label class="col-form-label col-lg-5">पंजीकरण श्रेणी / Registering for</label>
                        <div class="col-lg-7 pt-2 ptn">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="gymRadio" value="1" required>
                                <label class="form-check-label" for="gymRadio">Gymnasium</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="swimmingPoolRadio" value="2" required>
                                <label class="form-check-label" for="swimmingPoolRadio">Swimming Pool</label>
                            </div>
                        </div>
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group row required mb-2" aria-required="true">
                        <label class="col-form-label col-lg-5" for="firstName">पूरा नाम / Full Name</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" value="{{old('name')}}" id="firstName" required name="name" placeholder="Full Name"  onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' pattern="^[A-Za-z -]+$" maxlength="255">
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group row required mb-1" aria-required="true">
                        <label class="col-form-label col-lg-5" for="dateOfBirth">जन्म तिथि / Date of Birth</label>
                        <div class="col-lg-7">
                            <input type="date" class="form-control" required  data-language="en" name="dob"  min="<?=  date('Y', strtotime('-20 years')); ?>-04-01" max="<?=  date('Y'); ?>-03-31" placeholder="DD-MM-YYYY">
                        </div>
                        @error('dob')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group row required mb-2" aria-required="true">
                        <label class="col-form-label col-lg-5">लिंग / Gender</label>
                        <div class="col-lg-7 pt-2 ptn">
                            <select class="form-control form-select" name="gender" required>
                                <option value="">Select</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group row required mb-2" aria-required="true">
                        <label class="col-form-label col-lg-5" for="email">ईमेल पता / Email ID</label>
                        <div class="col-lg-7">
                            <input type="email" class="form-control" id="email" required pattern="^[^ ]+@[^ ]+\.[a-z]{2,6}$"  name="email" placeholder="Email ID" maxlength="255">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group row required  mb-2" aria-required="true">
                        <label class="col-form-label col-lg-5" for="mobileNumber">मोबाइल नंबर / Mobile Number</label>
                        <div class="col-lg-7">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="input-group-text">+91</span>
                                </div> --}}
                                <input type="text" class="form-control" id="mobileNumber" name="mobile" pattern="[6-9][0-9]{9}$"  required maxlength="10" minlength="10"  placeholder="Enter Mobile Number "maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" data-toggle="tooltip" data-placement="bottom" title="">
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted"><strong>This number will be used for all communication.</strong></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="captcha">

                                        <label class="btn-block">4. Captcha/कैप्चा</label>
                                        <span class="unselectable" id="p_refresh">{{$Code1}}+{{$Code2}}</span>
                                       <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="{{$Code1+$Code2}}" readonly>
                                    </div>
                            </div>
                            <div class="col-md-1">
                                <div class="refresh"><a href="javascript:void(0)" title="Refresh Captcha"><span class="fas fa-redo"></span></a></div>
                            </div>

                            <div class="col-md-7">
                                <label>4. Enter Captcha/कैप्चा भरें</label>
                                <input name="captcha" type="text" class="form-control "  value="{{old('captcha')}}" required>
                                @error('captcha')
                                 <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            <div class="form-group mb-2">
                <div class="row">
                    <div class="col-md-6 d-grid">
                        <button type="submit" class="btn btn-outline-danger rounded-pill"><i class="fa fa-user-plus"></i> Register <span class="fa fa-arrow-right"></span></button>
                    </div>
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('gymnasium_swimmingregistration') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa fa-undo"></i> Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('custom-scripts')
<script>
$(".refresh").on("click", function () {
    $.ajax({
        type: "GET",
        url: ajaxUrl + "/gymnasium_swimming/cp_refresh/",
        dataType: "json",
        success: function (res) {
            console.log(res)
            $("#p_refresh").html(res.Code1 +'+'+ res.Code2);
            $(".captchacode").val(res.Code1 + res.Code2);
            // $(".refreshc").val(res.capchaCode);
        },
    });
});



$("#gymsubmit").submit(function (e) {

    e.preventDefault();
    if ($("#gymsubmit")[0].checkValidity() === false) {
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
            success: function (res) {
                if (res.error == false) {
                    success(res.msg);

                    window.location.href = res.url;


                } else {
                    error(res.msg);
                }
            },
        });
    }
    $("#gymsubmit").addClass("was-validated");
});




</script>

@endpush
