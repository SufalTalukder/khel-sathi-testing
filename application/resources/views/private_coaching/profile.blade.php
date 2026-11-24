@extends('layouts.private_coaching_auth_layout')
@section('content')
<div class="container-fluid pagecontentbody">
    <div class="pagebody removebg-color">
        <div class="row">
            <div class="col-12">
                <div class="pageheader" id="menu-margin">
                    <div class="row align-items-center">
                        <div class="col-md-9 col-8">
                            <h4 class="mb-0">Profile Detail Form / प्रोफाइल विवरण प्रपत्र</h4>
                        </div>
                        <div class="col-md-3 col-4 text-end">
                            <a href="{{ route('private_coaching_dashboard') }}" class="btn btn-outline-success btn-sm">
                                <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="bhoechie-tab-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab">
                            <div class="bhoechie-tab-content active">
                                <div class="form-scroll">
                                    <div class="nano-content">
                                        <form action="{{ route('private_coaching_profile') }}" method="post" class="needs-validation" id="submitform" novalidate enctype="multipart/form-data">
                                            @csrf

                                            <!-- A. Registration Details -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="subheading">A. Registration Details / पंजीकरण के विवरण</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">1.) Full Name / पूरा नाम <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" value="{{ Auth::guard('PrivateCoaching')->user()->name }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">2.) Designation / पदनाम <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" value="{{ Auth::guard('PrivateCoaching')->user()->designation }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">3.) Email ID / ईमेल आईडी <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" value="{{ Auth::guard('PrivateCoaching')->user()->email }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">4.) Mobile No. / मोबाइल नंबर <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" value="{{ Auth::guard('PrivateCoaching')->user()->mobile }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">5.) Photo Upload / फोटो अपलोड <span class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" onchange="getfileext11(this,122)" id="File122" name="photo_upload" @if(!isset($profile->photo_upload)) required @endif accept=".jpg,.jpeg">
                                                        <small class="text-muted d-block mt-1">(File Format: JPG, JPEG | Max File Size: 5 MB)</small>
                                                        @if(isset($profile->photo_upload) && $profile->photo_upload)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('public/private_coaching_storage/photo_upload/' . $profile->photo_upload) }}" target="_blank" class="btn btn-secondary btn-sm">
                                                                <i class="fa fa-eye me-1"></i> View Current Photo
                                                            </a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- B. Address Details -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="subheading">B. Address Details / पते का विवरण</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">1.) Office Address / कार्यालय का पता <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="office_address" required value="{{ isset($profile->office_address) ? $profile->office_address : old('office_address') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">2.) State / राज्य <span class="text-danger">*</span></label>
                                                        <select class="form-select form-control" name="state" required>
                                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">3.) City / शहर <span class="text-danger">*</span></label>
                                                        <select class="form-control form-select" name="district" required>
                                                            <option value="">Select City / District</option>
                                                            @foreach ($district as $item)
                                                            <option value="{{ $item->id }}" @if(isset($profile->district) && $profile->district == $item->id) selected @endif>{{ $item->city }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">4.) Pincode / पिन कोड <span class="text-danger">*</span></label>
                                                        <input type="text" maxlength="6" minlength="6" pattern="^[1-9][0-9]{5}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="pin" required value="{{ isset($profile->pin) ? $profile->pin : old('pin') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- C. Institution Details -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="subheading">C. Institution / संस्थान</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label class="placeholder">1.) Institution Name / संस्था का नाम <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="institute_name" required value="{{ isset($profile->institute_name) ? $profile->institute_name : old('institute_name') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bhoechie Footer -->
                                            <div class="bhoechie-footer mt-4 pt-3 border-top">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-2 col-6 d-grid">
                                                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                                    </div>
                                                    <div class="col-md-2 col-6 d-grid">
                                                        <button type="submit" class="btn btn-outline-success">Save and Next</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    $("#submitform").submit(function(e) {
        e.preventDefault();
        if ($("#submitform")[0].checkValidity() === false) {
            e.stopPropagation();
        } else {
            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).prepend('<i class="fa fa-spinner fa-spin me-1"></i> ');
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(res) {
                    submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                    if (res.error == false) {
                        success(res.msg);
                        setTimeout(function() {
                            window.location.href = res.url;
                        }, 1500);
                    } else {
                        error(res.msg);
                    }
                },
                error: function() {
                    submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                    error("An unexpected error occurred. Please try again.");
                }
            });
        }
        $("#submitform").addClass("was-validated");
    });

    function getfileext11(value, id) {
        if (!value.files || !value.files[0]) return;
        var fileExtension = ["jpg", "jpeg"];
        var file_size = value.files[0].size;
        var filevalue = value.value;
        var ext = filevalue.split(".").pop().toLowerCase();

        if ($.inArray(ext, fileExtension) == -1) {
            $("#File" + id).val("");
            error("Please upload file in JPG or JPEG format.");
        } else if (file_size > 5242880) { // 5MB
            $("#File" + id).val("");
            error("File size should not exceed 5MB.");
        }
    }
</script>
@endpush