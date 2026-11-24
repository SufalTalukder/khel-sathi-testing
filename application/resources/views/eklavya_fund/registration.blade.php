@extends( 'layouts\eklavya_fund_layout' )
@section('content')
<div class="col-md-6 bg-light1">
    <div class="pt-3 pb-5 login-form">
        <div class="text-center text-md-center mt-md-0">
            <h3 class="mb-2">Registration/पंजीकरण</h3>
            <div class="auth-login-callout my-2 text-center">
                <div class="d-inline-block p-2 px-3 rounded-3" style="background: #f0fdf4; border: 1.5px dashed #16a34a; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);">
                    <div style="font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 4px;">
                        Already Registered? / क्या पहले से पंजीकृत हैं?
                    </div>
                    <a href="{{url('eklavyaFund')}}" class="btn btn-sm btn-success rounded-pill px-4 py-1 fw-bold text-white shadow-sm" style="font-size: 0.88rem; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border: none;">
                        <i class="fas fa-sign-in-alt me-1"></i> Click Here to Login / अभी लॉगिन करें &rarr;
                    </a>
                </div>
            </div>
        </div>
        <form action="{{url('eklavyaFund/registration')}}" method="post" id="preregistration" class="needs-validation mt-4 pb-4" novalidate>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">1. Name of Sports Club/Academy<br />खेल क्लब/एकेडमी का नाम</label>
                        <input type="text" name="academy_name" required class="form-control" id="academy_name">
                        <div class="invalid-feedback"> Please Enter Name of Sports Club/Academy/कृपया खेल क्लब/एकेडमी का नाम भरें।</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">2. Name of the Sport<br />खेल का नाम</label>
                        <select class="form-select form-control" name="sport_name" id="sport_name" required>
                            <option value="">Select</option>
                            @foreach ($sports as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"> Please Enter  Name of the Sport /खेल का नाम</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">3. Mobile Number/मोबाइल नंबर</label>
                        <input type="text" name="mobile" class="form-control" pattern="[6-9][0-9]{9}$" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        <div class="invalid-feedback"> Please Enter Mobile No./कृपया मोबाइल नंबर भरें।</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">4. Email ID/ईमेल आईडी</label>
                        <input required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" class="form-control">
                        <div class="invalid-feedback">Please Enter Valid Email ID./कृपया सही ईमेल आईडी भरें।</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">5. Location of the Sports Club/Academy within the state boundary<br>खेल क्लब/अकादमी उत्तर प्रदेश राज्य के सीमा क्षेत्र में स्थापित एवं कार्यरत हो</label>
                        <div class="form-control">
                            <div class="form-check form-check-inline m-0">
                                <input onclick="getNativeOfup(this.value)" class="form-check-input native_check" type="radio" name="native_of_up" required id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input onclick="getNativeOfup(this.value)" class="form-check-input native_check" type="radio" name="native_of_up" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">6. TAN Number/PAN Number/TAN नंबर/PAN नंबर</label>
                        <input type="text"  pattern="[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}" style="text-transform:uppercase" name="pan" required class="form-control">
                        <div class="invalid-feedback"> Please Enter TAN Number/PAN Number/TAN नंबर/PAN नंबर</div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group row">
                        <div class="captcha">
                            <label > 7. Captcha/कैप्चा<span class="text-danger">*</span></label>
                            <span class="unselectable" id="cp_refresh">{{$Code1}}+{{$Code2}}</span>
                            <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="{{$Code1+$Code2}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 refresh">
                    <div class="form-group row">
                        <div class="cp_refresh"><a href="javascript:void(0)" title="Refresh Captcha"><span class="fas fa-redo"></span></a></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label>8. Enter Captcha/कैप्चा भरें</label>
                        <input name="captcha" id="captcha" type="text" required class="form-control">
                        <div class="invalid-feedback"> Please Enter Captcha./कृपया कैप्चा भरें।</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-grid">
                        <button type="submit" class="btn w-100 btn-info">Register/पंजीकरण करें<span class="fa fa-arrow-right"></span></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-grid">
                        <button type="reset" class="btn w-100 btn-outline-secondary ">Reset/रीसेट करें</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
@push('custom-scripts')
<script>

</script>
@endpush
