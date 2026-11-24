@extends('layouts.private_coaching_auth_layout')
@section('content')

<div class="container-fluid pagecontentbody">
    <div class="pagebody removebg-color">
        <div class="row">
            <div class="col-12">
                <div class="pageheader" id="menu-margin">
                    <div class="row align-items-center">
                        <div class="col-md-8 col-7">
                            <h4 class="mb-0">Profile Details / प्रोफाइल विवरण</h4>
                        </div>
                        <div class="col-md-4 col-5 text-end">
                            <a href="{{ route('private_coaching_profile') }}" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fa fa-pencil me-1"></i> Edit Profile
                            </a>
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
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle mb-0">
                                                <tbody>
                                                    <tr style="background-color: #eee;">
                                                        <td colspan="4"><strong>A. Registration Details / पंजीकरण के विवरण</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%"><strong>1.) Full Name / पूरा नाम:</strong></td>
                                                        <td width="30%">{{ Auth::guard('PrivateCoaching')->user()->name }}</td>
                                                        <td width="20%"><strong>2.) Designation / पदनाम:</strong></td>
                                                        <td width="30%">{{ Auth::guard('PrivateCoaching')->user()->designation }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>3.) Email ID / ईमेल आईडी:</strong></td>
                                                        <td>{{ Auth::guard('PrivateCoaching')->user()->email }}</td>
                                                        <td><strong>4.) Mobile No. / मोबाइल नंबर:</strong></td>
                                                        <td>{{ Auth::guard('PrivateCoaching')->user()->mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>5.) Photo / फोटो:</strong></td>
                                                        <td colspan="3">
                                                            @if(!empty($profile->photo_upload))
                                                                <a href="{{ asset('public/private_coaching_storage/photo_upload/' . $profile->photo_upload) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                                    <i class="fa fa-eye me-1"></i> View / Download Photo
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Not uploaded</span>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #eee;">
                                                        <td colspan="4"><strong>B. Address Details / पते का विवरण</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>1.) Office Address / कार्यालय का पता:</strong></td>
                                                        <td>{{ $profile->office_address }}</td>
                                                        <td><strong>2.) State / राज्य:</strong></td>
                                                        <td>{{ $profile->state ?? 'Uttar Pradesh' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>3.) City/District / शहर:</strong></td>
                                                        <td>{{ districtName($profile->district) }}</td>
                                                        <td><strong>4.) Pincode / पिन कोड:</strong></td>
                                                        <td>{{ $profile->pin }}</td>
                                                    </tr>

                                                    <tr style="background-color: #eee;">
                                                        <td colspan="4"><strong>C. Institution Details / संस्थान का विवरण</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>1.) Institution Name / संस्था का नाम:</strong></td>
                                                        <td colspan="3"><strong>{{ $profile->institute_name }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</div>

@endsection
