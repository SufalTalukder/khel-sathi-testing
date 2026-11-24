@extends('layouts/admin_layout')
@section('content')
<div class="pageheader" id="menu-margin">
    <h4 class="mb-0 font-weight-bold">Change Password</h4>
</div>

<style>
    .change-pwd-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        background: #fff;
        margin-bottom: 24px;
    }

    .change-pwd-card-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .change-pwd-card-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .pwd-input-group .input-group-text {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #64748b;
    }

    .pwd-input-group .form-control {
        border-color: #cbd5e1;
        font-size: 13.5px;
    }

    .pwd-input-group .form-control:focus {
        border-color: #0dcaf0;
        box-shadow: 0 0 0 3px rgba(13, 202, 240, 0.25);
    }

    .toggle-password {
        cursor: pointer;
        user-select: none;
    }

    .toggle-password:hover {
        color: #0f172a;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="change-pwd-card">
            <div class="change-pwd-card-header">
                <h5>Update Password :-</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('adminupdatePassword') }}" method="post" id="ajxReload" class="needs-validation" novalidate>
                    @csrf
                    <div class="row align-items-end">
                        <!-- Current Password -->
                        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                            <label for="password-field1" class="form-label font-weight-bold text-secondary mb-1" style="font-size: 13px;">
                                Current Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group pwd-input-group">
                                <span class="input-group-text"><span class="icons icon-lock-open"></span></span>
                                <input required type="password" name="old_password" placeholder="Current password"
                                    class="form-control" id="password-field1" autocomplete="current-password">
                                <span toggle="#password-field1" class="input-group-text toggle-password fa fa-fw fa-eye"></span>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                            <label for="password-field" class="form-label font-weight-bold text-secondary mb-1" style="font-size: 13px;">
                                New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group pwd-input-group">
                                <span class="input-group-text"><span class="icons icon-lock-open"></span></span>
                                <input required type="password" name="password"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                    placeholder="New password (min 8 chars)" class="form-control" id="password-field"
                                    autocomplete="new-password">
                                <span toggle="#password-field" class="input-group-text toggle-password fa fa-fw fa-eye"></span>
                                <div class="invalid-feedback">
                                    Min 8 chars, 1 uppercase, 1 lowercase & 1 number.
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                            <label for="password-field2" class="form-label font-weight-bold text-secondary mb-1" style="font-size: 13px;">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group pwd-input-group">
                                <span class="input-group-text"><span class="icons icon-lock-open"></span></span>
                                <input required type="password" name="password_confirmation"
                                    placeholder="Confirm new password" class="form-control" id="password-field2"
                                    autocomplete="new-password">
                                <span toggle="#password-field2" class="input-group-text toggle-password fa fa-fw fa-eye"></span>
                            </div>
                        </div>

                        <!-- Submit Button (inline on desktop) -->
                        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                            <button type="submit" class="btn btn-info w-100 font-weight-bold text-white" style="height: 38px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 13.5px;">
                                Change Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.toggle-password', function() {
            $(this).toggleClass('fa-eye fa-eye-slash');
            var input = $($(this).attr('toggle'));
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>
@endsection
