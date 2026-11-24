@extends('layouts.private_coaching_auth_layout')
@section('content')

<style>
    .doc-upload-box {
        background: #ffffff;
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
        padding: 16px 20px;
        margin-bottom: 0;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .doc-upload-box:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .summary-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        padding: 10px 14px;
    }
    .rounded {
        border-radius: 6px !important;
    }
</style>

<div class="container-fluid pagecontentbody">
    <div class="pagebody removebg-color">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="pageheader d-flex justify-content-between align-items-center flex-wrap" id="menu-margin" style="padding: 14px 0; margin-bottom: 22px; border-bottom: 1px solid #e2e8f0;">
                    <div>
                        <h4 class="mb-1 text-dark fw-bold" style="font-size: 1.25rem;">
                            <i class="fa fa-users text-primary me-2"></i> Sports Association Registration / खेल संघ पंजीकरण
                        </h4>
                        <small class="text-muted">Fill out the affiliation form and upload required supporting documents.</small>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <a href="{{ route('private_coaching_dashboard') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm" style="font-weight: 600;">
                            <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <!-- Main Form Card Container -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: #ffffff;">
                    <div class="card-body p-4 p-md-5">

                        <form action="@if(isset($application)){{route('private_coaching_application_form_store',$application->id)}}@else {{route('private_coaching_application_form_store')}} @endif" method="post" class="needs-validation" id="submitform" novalidate enctype="multipart/form-data">
                            @csrf

                            <!-- Section A: Registration Details -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section A</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Registration Details / पंजीकरण के विवरण</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">1.) Full Name / पूरा नाम</small>
                                            <strong>{{Auth::guard('PrivateCoaching')->user()->name }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">2.) Designation / पदनाम</small>
                                            <strong>{{Auth::guard('PrivateCoaching')->user()->designation }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">3.) Email ID / ईमेल आईडी</small>
                                            <strong>{{Auth::guard('PrivateCoaching')->user()->email }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">4.) Mobile No. / मोबाइल नंबर</small>
                                            <strong>{{Auth::guard('PrivateCoaching')->user()->mobile }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section B: Address Details -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section B</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Address Details / पते का विवरण</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">1.) Office Address / कार्यालय का पता</small>
                                            <strong>{{$profile->office_address}}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">2.) State / राज्य</small>
                                            <strong>Uttar Pradesh</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">3.) City / शहर</small>
                                            <strong>{{districtName($profile->district)}}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">4.) Pincode / पिन कोड</small>
                                            <strong>{{$profile->pin}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section C: Sports -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section C</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Sports / खेल</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold small">5.) Sports Name / खेल का नाम <span class="text-danger">*</span></label>
                                            <select id="sportname" class="form-select form-control" name="sport" required>
                                                <option value="">Select Sport</option>
                                                @foreach ($sport as $item)
                                                    <option value="{{$item->id}}" {{isset($application->sport) && $application->sport == $item->id ? 'selected': (isset($profile->sport_id) && $profile->sport_id == $item->id ? 'selected' : '')}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section D: Institution -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section D</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Institution Details / संस्थान का विवरण</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">1.) Type of Institution / संस्था का प्रकार</small>
                                            <strong>{{$profile->type_institute ?? 'Sports Association'}}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="summary-info-box">
                                            <small class="text-muted d-block">2.) Institution Name / संस्था का नाम</small>
                                            <strong>{{$profile->institute_name}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section E: Association Members -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section E</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Association Members / संघ के सदस्य</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="dynamic_field">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name of Member / सदस्य का नाम <span class="text-danger">*</span></th>
                                                <th>Mobile No. / मोबाइल नंबर <span class="text-danger">*</span></th>
                                                <th>Email ID / ईमेल आईडी <span class="text-danger">*</span></th>
                                                <th>Designation / पदनाम <span class="text-danger">*</span></th>
                                                <th class="text-center" style="width: 10%;">Action / कार्रवाई</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!isset($associate_member) || count($associate_member) == 0)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="name_of_member[]" class="form-control" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' pattern="^[A-Za-z -]+$" maxlength="255" placeholder="Full Name" required/>
                                                    </td>
                                                    <td>
                                                        <input type="tel" name="mobile[]" maxlength="10" minlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit mobile" required class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="email" name="email[]" placeholder="email@domain.com" required class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="designation[]" required class="form-control" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' pattern="^[A-Za-z -]+$" maxlength="255" placeholder="Designation" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" name="add" id="add" title="Add More" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($associate_member as $key => $post)
                                                    <tr id="row{{$key}}">
                                                        <td>
                                                            <input type="text" name="name_of_member[]" required class="form-control" value="{{$post->name ?? ''}}" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' pattern="^[A-Za-z -]+$" maxlength="255" required/>
                                                        </td>
                                                        <td>
                                                            <input name="mobile[]" type="tel" maxlength="10" minlength="10" pattern="[6-9][0-9]{9}" required class="form-control" value="{{$post->mobile ?? ''}}" />
                                                        </td>
                                                        <td>
                                                            <input type="email" name="email[]" required class="form-control" value="{{$post->email ?? ''}}" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="designation[]" required class="form-control" value="{{$post->designation ?? ''}}" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' pattern="^[A-Za-z -]+$" maxlength="255" required/>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($key == 0)
                                                                <button type="button" name="add" id="add" title="Add More" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fa fa-plus"></i></button>
                                                            @else
                                                                <button type="button" name="remove" id="{{$key}}" class="btn btn-outline-danger btn-sm rounded-circle btn_remove"><i class="fa fa-trash"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Section F: Upload Document -->
                            <div class="form-section mb-4 pb-3">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size: 13px;">Section F</span>
                                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Upload Document / दस्तावेज़ अपलोड करें</h5>
                                </div>

                                <div class="row g-4">

                                    <!-- Doc 1 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                1.) Copy of the form regarding recognition of Sports Federation of India / Federation of the concerned sport by the Ministry of Sports, Government of India.
                                                <span class="d-block text-muted fw-normal">सम्बन्धित खेल के भारतीय खेल फेडरेशन/महासंघ का खेल मंत्रालय भारत सरकार द्वारा मान्यता प्रदान किये जाने सम्बन्धी प्रपत्र की प्रति</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,136)" id="File136" name="sport_federation" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->sport_federation)) required @endif>
                                                @if(isset($application->sport_federation))
                                                    <a href="{{ asset('public/private_coaching_storage/sport_federation/' . $application->sport_federation) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 2 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                2.) Copy of the form for granting recognition/affiliation to the State Sports Association of the respective sport by the Indian Federation/Federation and Uttar Pradesh Olympic Association.
                                                <span class="d-block text-muted fw-normal">सम्बन्धित खेल के प्रदेशीय क्रीड़ा संघ को भारतीय फेडरेशन/महासंघ एवं उत्तर प्रदेश ओलम्पिक संघ द्वारा मान्यता/सम्बद्धता प्रदान किये जाने सम्बन्धी प्रपत्र की प्रति</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,135)" id="File135" name="granting_recognition" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->granting_recognition)) required @endif>
                                                @if(isset($application->granting_recognition))
                                                    <a href="{{ asset('public/private_coaching_storage/granting_recognition/' . $application->granting_recognition) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 3 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                3.) Certified copy of recognition from the Indian Sports Association/Federation of the concerned sport.
                                                <span class="d-block text-muted fw-normal">सम्बंधित खेल के भारतीय खेल संघ/ फेडरेशन द्वारा प्रमाणित प्रति।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,134)" id="File134" name="certified_copy_of_recognition" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->certified_copy_of_recognition)) required @endif>
                                                @if(isset($application->certified_copy_of_recognition))
                                                    <a href="{{ asset('public/private_coaching_storage/certified_copy_of_recognition/' . $application->certified_copy_of_recognition) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 4 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                4.) Copy of the Registration Certificate of the concerned State Sports Association under the Society Registration Act.
                                                <span class="d-block text-muted fw-normal">सम्बन्धित प्रदेशीय क्रीड़ा संघ का सोसाइटी रजिस्ट्रेशन एक्ट के अन्तर्गत पंजीयन प्रमाण-पत्र की प्रति।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">Date of Registration / पंजीकरण तिथि <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="date_of_registration" required value="@if(isset($application->date_of_registration)){{ $application->date_of_registration }}@endif" />
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label text-muted small">Certificate File / प्रमाण-पत्र फ़ाइल <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,133)" id="File133" name="registration_certificate" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->registration_certificate)) required @endif>
                                                        @if(isset($application->registration_certificate))
                                                            <a href="{{ asset('public/private_coaching_storage/registration_certificate/' . $application->registration_certificate) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Doc 5 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                5.) Certified copy of the Constitution/Memorandum of the State Sports Association.
                                                <span class="d-block text-muted fw-normal">प्रदेशीय क्रीडा संघ के संविधान/ज्ञापन की प्रमाणित प्रति।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,132)" id="File132" name="certified_copy_of_the_constitution" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->certified_copy_of_the_constitution)) required @endif>
                                                @if(isset($application->certified_copy_of_the_constitution))
                                                    <a href="{{ asset('public/private_coaching_storage/certified_copy_of_the_constitution/' . $application->certified_copy_of_the_constitution) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 6 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                6.) Copy of the selection form of the officials of the State Sports Association and the list of the officials along with their mobile numbers and permanent addresses.
                                                <span class="d-block text-muted fw-normal">प्रदेशीय क्रीडा संघ के पदाधिकारियों के चयन सम्बन्धी प्रपत्र की प्रति एवं पदाधिकारियों के मोबाइल नम्बर एवं स्थायी पता सहित सूची।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,131)" id="File131" name="copy_of_the_selection" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->copy_of_the_selection)) required @endif>
                                                @if(isset($application->copy_of_the_selection))
                                                    <a href="{{ asset('public/private_coaching_storage/copy_of_the_selection/' . $application->copy_of_the_selection) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 7 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                7.) Copy of the CA - Audit Report of income and expenditure statement of the last three years of the concerned State Sports Association.
                                                <span class="d-block text-muted fw-normal">सम्बन्धित प्रदेशीय क्रीडा संघ के विगत तीन वर्षों का सम्परीक्षित आय-व्यय विवरण की प्रति।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">1st Year / प्रथम वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,130)" id="File130" name="audited_income_first" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->audited_income_first)) required @endif>
                                                        @if(isset($application->audited_income_first))
                                                            <a href="{{ asset('public/private_coaching_storage/audited_income_first/' . $application->audited_income_first) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">2nd Year / द्वितीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,129)" id="File129" name="audited_income_second" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->audited_income_second)) required @endif>
                                                        @if(isset($application->audited_income_second))
                                                            <a href="{{ asset('public/private_coaching_storage/audited_income_second/' . $application->audited_income_second) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">3rd Year / तृतीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,128)" id="File128" name="audited_income_third" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->audited_income_third)) required @endif>
                                                        @if(isset($application->audited_income_third))
                                                            <a href="{{ asset('public/private_coaching_storage/audited_income_third/' . $application->audited_income_third) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Doc 8 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                8.) Copy of the list including mobile/landline numbers and permanent addresses of 75 percent of the district units and their related officials related to the State Sports Association.
                                                <span class="d-block text-muted fw-normal">प्रदेशीय खेल संघ से सम्बन्धित 75 प्रतिशत जिला इकाईयों एवं उनसे सम्बन्धित पदाधिकारियों के मोबाइल / लैण्डलाइन नम्बर एवं स्थायी पता सहित सूची की प्रति।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" onchange="getfileext11(this,127)" id="File127" name="copy_of_the_list_including_mobile" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->copy_of_the_list_including_mobile)) required @endif>
                                                @if(isset($application->copy_of_the_list_including_mobile))
                                                    <a href="{{ asset('public/private_coaching_storage/copy_of_the_list_including_mobile/' . $application->copy_of_the_list_including_mobile) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View Current</a>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">(File Format: PDF, JPEG, JPG, PNG | Max File Size: 5 MB)</small>
                                        </div>
                                    </div>

                                    <!-- Doc 9 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                9.) Report of the activities of the concerned state sports for the last three years.
                                                <span class="d-block text-muted fw-normal">सम्बंधित प्रदेशीय खेल के विगत तीन वर्ष के कार्यकलापों की रिपोर्ट।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">1st Year / प्रथम वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,126)" id="File126" name="report_activity_first" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->report_activity_first)) required @endif>
                                                        @if(isset($application->report_activity_first))
                                                            <a href="{{ asset('public/private_coaching_storage/report_activity_first/' . $application->report_activity_first) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">2nd Year / द्वितीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,125)" id="File125" name="report_activity_second" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->report_activity_second)) required @endif>
                                                        @if(isset($application->report_activity_second))
                                                            <a href="{{ asset('public/private_coaching_storage/report_activity_second/' . $application->report_activity_second) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">3rd Year / तृतीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,124)" id="File124" name="report_activity_third" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->report_activity_third)) required @endif>
                                                        @if(isset($application->report_activity_third))
                                                            <a href="{{ asset('public/private_coaching_storage/report_activity_third/' . $application->report_activity_third) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Doc 10 -->
                                    <div class="col-md-12">
                                        <div class="form-group doc-upload-box">
                                            <label class="form-label fw-bold small">
                                                10.) Form of State Sports Association regarding organizing state level competitions of sub-junior/junior/senior category for the last three years.
                                                <span class="d-block text-muted fw-normal">प्रदेशीय खेल संघ का विगत तीन वर्षों तक सबजूनियर/जूनियर/सीनियर वर्ग की राज्यस्तरीय प्रतियोगिताओं के आयोजन सम्बंधी प्रपत्र।</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">1st Year / प्रथम वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,123)" id="File123" name="state_sports_association_first" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->state_sports_association_first)) required @endif>
                                                        @if(isset($application->state_sports_association_first))
                                                            <a href="{{ asset('public/private_coaching_storage/state_sports_association_first/' . $application->state_sports_association_first) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">2nd Year / द्वितीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,122)" id="File122" name="state_sports_association_second" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->state_sports_association_second)) required @endif>
                                                        @if(isset($application->state_sports_association_second))
                                                            <a href="{{ asset('public/private_coaching_storage/state_sports_association_second/' . $application->state_sports_association_second) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-muted small">3rd Year / तृतीय वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" onchange="getfileext11(this,121)" id="File121" name="state_sports_association_third" accept=".pdf,.jpg,.jpeg,.png" @if(!isset($application) || empty($application->state_sports_association_third)) required @endif>
                                                        @if(isset($application->state_sports_association_third))
                                                            <a href="{{ asset('public/private_coaching_storage/state_sports_association_third/' . $application->state_sports_association_third) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye me-1"></i> View</a>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted d-block mt-1">(PDF, JPEG, JPG, PNG - Max 5 MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-4 border-top mt-4 text-center">
                                <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm" style="min-width: 200px; font-weight: 600;">
                                    <i class="fa fa-check-circle me-1"></i> Save and Next
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom-scripts')
<script type="text/javascript">
$(document).ready(function() {
    var i = 100;
    $("#add").click(function() {
        $('#dynamic_field tbody').append(
            '<tr id="row' + i + '">' +
                '<td><input type="text" name="name_of_member[]" required class="form-control" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))" pattern="^[A-Za-z -]+$" maxlength="255" placeholder="Full Name" required/></td>' +
                '<td><input type="tel" name="mobile[]" maxlength="10" minlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit mobile" required class="form-control" /></td>' +
                '<td><input type="email" name="email[]" placeholder="email@domain.com" required class="form-control" /></td>' +
                '<td><input type="text" name="designation[]" required onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))" pattern="^[A-Za-z -]+$" maxlength="255" placeholder="Designation" class="form-control" /></td>' +
                '<td class="text-center"><button type="button" name="remove" id="' + i + '" class="btn btn-outline-danger btn-sm rounded-circle btn_remove"><i class="fa fa-trash"></i></button></td>' +
            '</tr>'
        );
        i++;

        $('input[name="mobile[]"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id).remove();
    });

    $('input[name="mobile[]"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Form submission
    $("#submitform").submit(function (e) {
        e.preventDefault();
        var form = this;
        if (form.checkValidity() === false) {
            e.stopPropagation();
            $(form).addClass("was-validated");
            return;
        }

        var submitBtn = $(form).find('button[type="submit"]');
        submitBtn.prop('disabled', true).prepend('<i class="fa fa-spinner fa-spin me-1"></i> ');

        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: new FormData(form),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                if (res.error == false) {
                    if (typeof success === 'function') {
                        success(res.msg);
                    } else {
                        alert(res.msg);
                    }
                    setTimeout(function() {
                        window.location.href = res.url;
                    }, 1000);
                } else {
                    if (typeof error === 'function') {
                        error(res.msg);
                    } else {
                        alert(res.msg);
                    }
                }
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                var msg = 'An error occurred while saving application.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.msg) {
                    msg = xhr.responseJSON.msg;
                }
                if (typeof error === 'function') {
                    error(msg);
                } else {
                    alert(msg);
                }
            }
        });
        $(form).addClass("was-validated");
    });
});

// File validation function: Allows PDF, JPEG, JPG, PNG and Max 5MB
function getfileext11(input, id) {
    if (!input || !input.files || !input.files[0]) return;
    var file = input.files[0];
    var allowedExtensions = ["pdf", "jpeg", "jpg", "png"];
    var ext = file.name.split('.').pop().toLowerCase();

    if ($.inArray(ext, allowedExtensions) === -1) {
        $(input).val("");
        var msg = "Please upload file in PDF, JPEG, or JPG format.";
        if (typeof error === 'function') {
            error(msg);
        } else {
            alert(msg);
        }
        return;
    }

    // 5MB = 5242880 bytes
    if (file.size > 5242880) {
        $(input).val("");
        var sizeMsg = "File size should not exceed 5MB.";
        if (typeof error === 'function') {
            error(sizeMsg);
        } else {
            alert(sizeMsg);
        }
        return;
    }
}
</script>
@endpush
