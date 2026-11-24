@extends('layouts/admin_layout')
@section('content')

<div class="pageheader" id="menu-margin">
    <h4 class="mb-0 font-weight-bold">{{ in_array((int)$admin->admin_role, [2, 9]) ? 'Profile & Settings' : 'Profile' }}</h4>
</div>

<style>
    #createStadiumModal {
        z-index: 99999 !important;
    }

    #createStadiumModal .modal-dialog {
        z-index: 100000 !important;
        position: relative;
    }

    .modal-backdrop {
        z-index: 99990 !important;
    }

    /* Custom Dropdown Chevron Icon Styling */
    select.form-select,
    select.custom-select-icon {
        display: block;
        width: 100%;
        padding: 0.5rem 2.25rem 0.5rem 0.75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #1e293b;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.75rem center !important;
        background-size: 16px 12px !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        cursor: pointer;
    }

    select.form-select:focus,
    select.custom-select-icon:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }

    .profile-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        background: #fff;
        margin-bottom: 24px;
    }

    .profile-card-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .profile-card-header h5 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
    }

    .avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 12px;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        overflow: hidden;
        background: #f1f5f9;
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nav-tabs-custom {
        border-bottom: 2px solid #e2e8f0;
    }

    .nav-tabs-custom .nav-link {
        font-weight: 600;
        color: #64748b;
        padding: 10px 22px;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        transition: all 0.2s;
    }

    .nav-tabs-custom .nav-link.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: transparent;
    }

    .action-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s;
    }

    .action-icon-btn.edit-btn:hover {
        color: #2563eb;
        border-color: #2563eb;
        background: #eff6ff;
    }

    .action-icon-btn.delete-btn:hover {
        color: #dc2626;
        border-color: #dc2626;
        background: #fef2f2;
    }

    .action-icon-btn:disabled,
    .action-icon-btn[disabled] {
        opacity: 0.45;
        cursor: not-allowed !important;
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        box-shadow: none !important;
    }

    .action-icon-btn.delete-btn:disabled:hover,
    .action-icon-btn.delete-btn[disabled]:hover {
        color: #94a3b8 !important;
        border-color: #e2e8f0 !important;
        background: #f8fafc !important;
    }

    .infra-table th {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-top: none;
        vertical-align: middle;
    }

    .infra-table td {
        vertical-align: middle !important;
        background: #fff;
    }

    .infra-table .form-control,
    .infra-table .form-select {
        font-size: 13.5px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
    }

    .infra-table .form-control:focus,
    .infra-table .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
    }

    .infra-table textarea.form-control {
        resize: vertical;
        min-height: 48px;
    }

    .infra-table .form-control.is-invalid,
    .infra-table .form-select.is-invalid {
        border-color: #dc2626 !important;
        background-color: #fff5f5 !important;
    }

    .row-highlight-duplicate {
        background-color: #fef3c7 !important;
        transition: background-color 0.3s ease;
    }

    .empty-state-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #eff6ff;
        border: 2px dashed #93c5fd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
    }
</style>

<!-- SECTION 1: OFFICER'S DETAILS -->
<div class="profile-card">
    <div class="profile-card-header">
        <h5>Officer's Details :-</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('adminUpdateOfficerProfile') }}" method="POST" enctype="multipart/form-data" id="officerForm" autocomplete="off">
            @csrf
            <div class="row align-items-center">
                <!-- Left: Profile Photo / Logo -->
                <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0">
                    @php
                    $hasCustomImage = !empty($admin->profile_image) && file_exists(public_path($admin->profile_image));
                    @endphp
                    <div class="avatar-wrapper mb-2">
                        <img id="avatar_preview" src="{{ $hasCustomImage ? asset($admin->profile_image) : asset('assets_admin/images/logo.png') }}" alt="{{ $hasCustomImage ? 'Officer Photo' : 'Default UP Logo' }}">
                    </div>

                    <input type="file" id="profile_image_input" name="profile_image" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                    <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">

                    <small class="text-muted d-block font-weight-bold mb-2" id="avatar_label_text">
                        {{ $hasCustomImage ? 'Officer Photo' : 'Default UP Logo' }}
                    </small>

                    <!-- Side-by-side Action Buttons Below Photo -->
                    <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 8px;">
                        <label for="profile_image_input" class="btn btn-sm btn-outline-primary py-1 px-2 font-weight-bold mb-0" id="avatar_change_btn" title="Change Photo" style="font-size: 11px; cursor: pointer; border-radius: 6px;">
                            <i class="fa fa-camera mr-1"></i> Edit Photo
                        </label>

                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 font-weight-bold mb-0" id="avatar_remove_btn" title="Remove Photo" onclick="removeAvatar()" style="{{ $hasCustomImage ? '' : 'display: none;' }}; font-size: 11px; border-radius: 6px;">
                            <i class="fa fa-trash mr-1"></i> Remove
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2" style="font-size: 10px;">(Max file size: 2 MB)</small>
                </div>

                <!-- Right: Form Fields -->
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 form-group">
                            <label class="font-weight-bold text-secondary">Salutation</label>
                            <select name="salutation" class="form-select custom-select-icon">
                                <option value="">Select</option>
                                <option value="Mr." {{ old('salutation', $admin->salutation ?? '') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                <option value="Mrs." {{ old('salutation', $admin->salutation ?? '') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                <option value="Ms." {{ old('salutation', $admin->salutation ?? '') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                <option value="Dr." {{ old('salutation', $admin->salutation ?? '') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                <option value="Prof." {{ old('salutation', $admin->salutation ?? '') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                <option value="Shri" {{ old('salutation', $admin->salutation ?? '') == 'Shri' ? 'selected' : '' }}>Shri</option>
                                <option value="Smt." {{ old('salutation', $admin->salutation ?? '') == 'Smt.' ? 'selected' : '' }}>Smt.</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-8 form-group">
                            <label class="font-weight-bold text-secondary">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $admin->name) }}" required placeholder="Enter full name">
                        </div>

                        @php
                        $displayDesignation = $admin->designation ?? '';
                        if ($displayDesignation === '12345678' || $displayDesignation === ($admin->user_password ?? '')) {
                        $displayDesignation = '';
                        }

                        $designationList = [
                        'Regional Sports Officer',
                        'Sports Officer',
                        'Deputy Sports Officer',
                        'Assistant Coach',
                        ];

                        $currentVal = old('designation', $displayDesignation);
                        $normalizedCurrent = trim(strtolower($currentVal));

                        // Smart pre-selection based on fetched data
                        $selectedDesignation = '';
                        if (in_array($currentVal, $designationList)) {
                        $selectedDesignation = $currentVal;
                        } elseif ($normalizedCurrent === 'rso' || str_contains($normalizedCurrent, 'regional')) {
                        $selectedDesignation = 'Regional Sports Officer';
                        } elseif ($normalizedCurrent === 'so' || $normalizedCurrent === 'sports officer') {
                        $selectedDesignation = 'Sports Officer';
                        } elseif ($normalizedCurrent === 'dso' || str_contains($normalizedCurrent, 'deputy') || str_contains($normalizedCurrent, 'district')) {
                        $selectedDesignation = 'Deputy Sports Officer';
                        } elseif (str_contains($normalizedCurrent, 'coach') || str_contains($normalizedCurrent, 'assistant')) {
                        $selectedDesignation = 'Assistant Coach';
                        } elseif ((int)$admin->admin_role === 2) {
                        $selectedDesignation = 'Regional Sports Officer';
                        } elseif ((int)$admin->admin_role === 9) {
                        $selectedDesignation = 'Deputy Sports Officer';
                        }
                        @endphp

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-secondary">Designation <span class="text-danger">*</span></label>
                            @if(in_array((int)$admin->admin_role, [2, 9]))
                            <select name="designation" id="officer_designation" class="form-select custom-select-icon" required>
                                <option value="" disabled {{ empty($selectedDesignation) ? 'selected' : '' }}>Select Designation</option>
                                @foreach($designationList as $desig)
                                <option value="{{ $desig }}" {{ $selectedDesignation === $desig ? 'selected' : '' }}>
                                    {{ $desig }}
                                </option>
                                @endforeach
                                @if(!empty($currentVal) && !in_array($currentVal, $designationList) && empty($selectedDesignation))
                                <option value="{{ $currentVal }}" selected>{{ $currentVal }}</option>
                                @endif
                            </select>
                            @else
                            <input type="text" class="form-control" name="designation" id="officer_designation" autocomplete="off" value="{{ old('designation', $displayDesignation) }}" required placeholder="e.g. Officer Designation">
                            @endif
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-secondary">Mobile <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mobile" maxlength="10" value="{{ old('mobile', $admin->mobile) }}" required placeholder="10-digit mobile number">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-secondary">Email (Office)</label>
                            <input type="email" class="form-control bg-light" name="email" value="{{ $admin->email }}" readonly style="cursor: not-allowed;" title="Official email is read-only">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-secondary">Admin Role</label>
                            <input type="text" class="form-control bg-light" style="cursor: not-allowed;" value="{{ $roleName }}" readonly>
                        </div>

                        @if(!empty($assignedDivision) || !empty($assignedDistrict))
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-secondary">
                                {{ !empty($assignedDivision) ? 'Division' : 'District' }}
                            </label>
                            <input type="text" class="form-control bg-light" style="cursor: not-allowed;" value="{{ $assignedDivision ? $assignedDivision . ' Division' : ($assignedDistrict ? $assignedDistrict . ' District' : '') }}" readonly>
                        </div>
                        @endif

                        <div class="col-12 text-right d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                                <i class="fa fa-save mr-1"></i> UPDATE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@if(in_array((int)$admin->admin_role, [2, 9]))
<!-- SECTION 2: TABS (STADIUMS & INFRASTRUCTURES) -->
<div class="profile-card">
    <div class="p-3 bg-light border-bottom">
        <ul class="nav nav-tabs nav-tabs-custom" id="profileTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-stadiums-btn" data-toggle="tab" href="#tab-stadiums" role="tab" aria-controls="tab-stadiums" aria-selected="true">
                    <i class="fa fa-pencil mr-1"></i> Stadiums
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-infrastructures-btn" data-toggle="tab" href="#tab-infrastructures" role="tab" aria-controls="tab-infrastructures" aria-selected="false">
                    <i class="fa fa-cubes mr-1"></i> Infrastructures
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content p-4" id="profileTabsContent">

        <!-- TAB 1: STADIUMS -->
        <div class="tab-pane fade show active" id="tab-stadiums" role="tabpanel" aria-labelledby="tab-stadiums-btn">
            <form action="{{ route('adminUpdateStadiumDetails') }}" method="POST" id="stadiumUpdateForm">
                @csrf
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4" style="gap: 15px;">
                    <div class="d-flex align-items-center flex-wrap" style="gap: 12px; flex: 1; max-width: 680px;">
                        <label class="font-weight-bold text-primary mb-0" style="white-space: nowrap; font-size: 15px;">
                            Select Stadium :-
                        </label>
                        <div style="flex: 1; min-width: 260px;">
                            <select id="stadium_select_tab1" name="stadium_id" class="form-select custom-select-icon stadium-sync-dropdown mb-0" required onchange="handleStadiumChange(this.value)">
                                @forelse($stadiums as $stadium)
                                <option value="{{ $stadium->id }}" {{ (isset($firstStadium) && $firstStadium->id == $stadium->id) ? 'selected' : '' }}>
                                    {{ $stadium->studium_name }} @if(!empty($stadium->district_name)) ({{ $stadium->district_name }}) @endif
                                </option>
                                @empty
                                <option value="">No stadiums found under jurisdiction</option>
                                @endforelse
                                <option value="__create_new__" style="color: #059669; font-weight: 600;">+ Add New Stadium</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-success font-weight-bold px-3 py-2 shadow-sm" onclick="openCreateStadiumModal()" style="border-radius: 6px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa fa-plus-circle" style="font-size: 14px;"></i> Add New Stadium
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold text-secondary">Address</label>
                        <input type="text" class="form-control" id="tab1_address" name="address" value="{{ $firstStadium->address ?? '' }}" placeholder="Enter stadium complete address">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold text-secondary">Stadium Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tab1_stadium_name" name="studium_name" value="{{ $firstStadium->studium_name ?? '' }}" required placeholder="Enter stadium name">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold text-secondary">Longitude</label>
                        <input type="text" class="form-control" id="tab1_longitude" name="longitude" value="{{ $firstStadium->longitude ?? '' }}" placeholder="e.g. 78.008681">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold text-secondary">Latitude</label>
                        <input type="text" class="form-control" id="tab1_latitude" name="latitude" value="{{ $firstStadium->latitude ?? '' }}" placeholder="e.g. 27.1609">
                    </div>

                    <div class="col-12 text-right d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                            <i class="fa fa-save mr-1"></i> UPDATE
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TAB 2: INFRASTRUCTURES -->
        <div class="tab-pane fade" id="tab-infrastructures" role="tabpanel" aria-labelledby="tab-infrastructures-btn">
            <!-- Filter Bar: Active Filter Badge (Left) + Stadium Dropdown (Right) -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2" style="gap: 15px;">
                <div class="d-flex align-items-center">
                    <span class="badge badge-light border px-3 py-2 text-dark font-weight-normal shadow-sm" style="font-size: 13.5px; border-radius: 6px; background: #f8fafc;">
                        <i class="fa fa-filter text-primary mr-1"></i> Filter View: <strong id="filter_active_label" class="text-dark">All Stadiums</strong>
                    </span>
                </div>
                <div style="min-width: 280px; max-width: 420px;">
                    <select id="stadium_filter_tab2" class="form-select custom-select-icon mb-0" onchange="filterInfraByStadium(this.value)">
                        <option value="all">-- All Stadiums ({{ count($stadiums) }}) --</option>
                        @foreach($stadiums as $stadium)
                        <option value="{{ $stadium->id }}">
                            {{ $stadium->studium_name }} @if(!empty($stadium->district_name)) ({{ $stadium->district_name }}) @endif
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Infrastructures Table (Inline Editable) -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover infra-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th style="width: 28%;">Stadium <span class="text-danger">*</span></th>
                            <th style="width: 33%;">Infrastructure <span class="text-danger">*</span></th>
                            <th>Available Games</th>
                            <th style="width: 70px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="infra_table_body">
                        @forelse($infrastructures as $infra)
                        <tr class="infra-row" data-id="{{ $infra->id }}" data-stadium="{{ $infra->stadium_id }}">
                            <td class="text-center infra-row-index align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <select class="form-select custom-select-icon infra-row-stadium" required onchange="onStadiumSelectChange(this)">
                                    <option value="">Select Stadium</option>
                                    @foreach($stadiums as $st)
                                    <option value="{{ $st->id }}" {{ $st->id == $infra->stadium_id ? 'selected' : '' }}>
                                        {{ $st->studium_name }} @if(!empty($st->district_name)) ({{ $st->district_name }}) @endif
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="align-middle">
                                <textarea class="form-control infra-row-name" rows="2" placeholder="e.g. Badminton Hall, Synthetic Track" required>{{ $infra->infrastructure_name }}</textarea>
                            </td>
                            <td class="align-middle">
                                <textarea class="form-control infra-row-games" rows="2" placeholder="e.g. Badminton, Table Tennis, Squash">{{ $infra->available_games }}</textarea>
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" class="action-icon-btn delete-btn" title="{{ count($infrastructures) <= 1 ? 'Cannot delete the only row' : 'Delete Infrastructure' }}" onclick="deleteInfraRow(this, {{ $infra->id }})" {{ count($infrastructures) <= 1 ? 'disabled' : '' }}>
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="no_infra_row">
                            <td colspan="5" class="text-center py-5 border-0 bg-white">
                                <div class="empty-filter-state d-flex flex-column align-items-center justify-content-center py-3">
                                    <div class="empty-state-icon-wrapper mb-3" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;">
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <h5 class="font-weight-bold text-dark mb-2" style="font-size: 16px;">
                                        No Stadium Infrastructures Added Yet
                                    </h5>
                                    <p class="text-muted mb-3" style="max-width: 460px; font-size: 13.5px; line-height: 1.6;">
                                        Add infrastructure details such as badminton halls, synthetic tracks, gymnasiums, and available games for stadiums in your jurisdiction.
                                    </p>
                                    <button type="button" class="btn btn-outline-success px-4 py-2 font-weight-bold" onclick="addNewInfraRow()" style="border-radius: 6px; font-size: 13.5px;">
                                        <i class="fa fa-plus-circle mr-1"></i> Add Infrastructure
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bottom Actions: Add Another Row + SAVE ALL -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top" style="gap: 15px;">
                <div>
                    <button type="button" class="btn btn-outline-success font-weight-bold px-3 py-2" onclick="addNewInfraRow()" style="border-radius: 6px;">
                        <i class="fa fa-plus-circle mr-1"></i> Add Row
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-success px-4 py-2 font-weight-bold shadow-sm" id="btn_save_all_infra" onclick="saveAllInfrastructures()" style="border-radius: 6px; font-size: 15px;">
                        <i class="fa fa-save mr-1"></i> SAVE ALL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: CREATE NEW STADIUM (RSO / SO / DSO) -->
<div class="modal fade" id="createStadiumModal" tabindex="-1" role="dialog" aria-labelledby="createStadiumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 580px;">
        <div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #ffffff; border-bottom: 1px solid #e5e7eb;">
                <h5 class="modal-title font-weight-bold d-flex align-items-center text-dark" id="createStadiumModalLabel" style="font-size: 16px; margin: 0;">
                    <i class="fa fa-university text-primary" style="margin-right: 10px; font-size: 18px;"></i>
                    <span>Add New Stadium</span>
                </h5>
                <button type="button" class="close btn-close" onclick="closeCreateStadiumModal()" aria-label="Close" style="font-size: 22px; color: #64748b; opacity: 0.8; background: transparent; border: none; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createStadiumForm" autocomplete="off">
                @csrf
                <div class="modal-body p-4" style="background: #ffffff;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-secondary" style="font-size: 13px;">
                            Stadium Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="studium_name" id="new_studium_name" required placeholder="e.g. Dr. B.R. Ambedkar Sports Stadium" style="border-radius: 6px; font-size: 13.5px;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-secondary" style="font-size: 13px;">
                            District <span class="text-danger">*</span>
                        </label>
                        <select class="form-select custom-select-icon" name="district_id" id="new_district_id" required style="font-size: 13.5px;">
                            @if(isset($officerDistricts) && count($officerDistricts) > 1)
                            <option value="" disabled selected>Select District</option>
                            @foreach($officerDistricts as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->city }}</option>
                            @endforeach
                            @elseif(isset($officerDistricts) && count($officerDistricts) === 1)
                            @foreach($officerDistricts as $dist)
                            <option value="{{ $dist->id }}" selected>{{ $dist->city }}</option>
                            @endforeach
                            @else
                            <option value="">No district assigned</option>
                            @endif
                        </select>
                        @if(isset($assignedDivision))
                        <small class="text-muted mt-1 d-block" style="font-size: 11px;">
                            <i class="fa fa-info-circle mr-1"></i> Under your jurisdiction: {{ $assignedDivision }} Division
                        </small>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-secondary" style="font-size: 13px;">Address</label>
                        <input type="text" class="form-control" name="address" id="new_address" placeholder="Complete address / locality" style="border-radius: 6px; font-size: 13.5px;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary" style="font-size: 13px;">Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="new_latitude" placeholder="e.g. 27.8974" style="border-radius: 6px; font-size: 13.5px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary" style="font-size: 13px;">Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="new_longitude" placeholder="e.g. 78.0880" style="border-radius: 6px; font-size: 13.5px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2 px-4" style="background: #f8fafc; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-secondary px-3 py-1 font-weight-bold" onclick="closeCreateStadiumModal()" style="border-radius: 6px; font-size: 13px;">Cancel</button>
                    <button type="submit" id="saveNewStadiumBtn" class="btn btn-primary px-4 py-1 font-weight-bold" style="border-radius: 6px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa fa-save"></i> Save Stadium
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- JAVASCRIPT LOGIC -->
<script>
    // Ensure toastr options are configured
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 8000,
            "extendedTimeOut": 4000
        };
    }



    // AJAX Submission for Officer Details Form
    $('#officerForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var fileInput = document.getElementById('profile_image_input');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            if (fileInput.files[0].size > 2 * 1024 * 1024) {
                toastr.error("The profile image must not be greater than 2 MB.");
                return false;
            }
        }

        var submitBtn = $(form).find('button[type="submit"]');
        var originalBtnHtml = submitBtn.html();

        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> UPDATING');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (!res.error) {
                    toastr.success(res.msg || "Officer details updated successfully.");
                    if (res.image) {
                        $('#avatar_preview').attr('src', res.image);
                        $('.topbar-user-avatar, #topbar_user_avatar').attr('src', res.image);
                    }
                    if (res.name) {
                        $('.topbar-user-name').text(res.name);
                    }
                    if (res.has_custom_image) {
                        $('#avatar_remove_btn').show();
                        $('#avatar_label_text').text('Officer Photo');
                    } else {
                        $('#avatar_remove_btn').hide();
                        $('#avatar_label_text').text('Default UP Logo');
                    }
                    $('#remove_profile_image').val('0');
                    $('#profile_image_input').val('');
                } else {
                    toastr.error(res.msg || "Failed to update officer details.");
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(field, msgs) {
                        $.each(msgs, function(i, msg) {
                            toastr.error(msg);
                        });
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("An error occurred while updating officer details.");
                }
            }
        });
    });

    // AJAX Submission for Stadium Update Form
    $('#stadiumUpdateForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var submitBtn = $(form).find('button[type="submit"]');
        var originalBtnHtml = submitBtn.html();

        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> UPDATING');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (!res.error) {
                    toastr.success(res.msg || "Stadium details updated successfully.");
                    if (res.stadium_id && res.studium_name) {
                        $('.stadium-sync-dropdown option[value="' + res.stadium_id + '"]').text(res.studium_name);
                    }
                } else {
                    toastr.error(res.msg || "Failed to update stadium details.");
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(field, msgs) {
                        $.each(msgs, function(i, msg) {
                            toastr.error(msg);
                        });
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("An error occurred while updating stadium details.");
                }
            }
        });
    });

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var maxSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxSize) {
                if (typeof toastr !== 'undefined') {
                    toastr.error("The profile image must not be greater than 2 MB.");
                } else {
                    alert("The profile image must not be greater than 2 MB.");
                }
                $(input).val('');
                return false;
            }
            $('#remove_profile_image').val('0');
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar_preview').attr('src', e.target.result);
                $('.topbar-user-avatar, #topbar_user_avatar').attr('src', e.target.result);
                $('#avatar_label_text').text('Selected Photo');
                $('#avatar_remove_btn').show();
            }
            reader.readAsDataURL(file);
        }
    }

    function removeAvatar() {
        $('#remove_profile_image').val('1');
        $('#profile_image_input').val('');
        $('#avatar_preview').attr('src', "{{ asset('assets_admin/images/logo.png') }}");
        $('.topbar-user-avatar, #topbar_user_avatar').attr('src', "{{ asset('assets_admin/images/logo.png') }}");
        $('#avatar_label_text').text('Default UP Logo (Pending Save)');
        $('#avatar_remove_btn').hide();
        if (typeof toastr !== 'undefined') {
            toastr.info("Photo removed. Click UPDATE to save changes.");
        }
    }

    var currentActiveStadiumId = "{{ $firstStadium->id ?? '' }}";

    function openCreateStadiumModal() {
        if ($('#createStadiumModal').length) {
            if ($('#createStadiumModal').parent().prop('tagName') !== 'BODY') {
                $('#createStadiumModal').appendTo('body');
            }
        }
        // Force cleanup any pre-existing stuck backdrops or locked body styles
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });

        $('#createStadiumModal').modal({
            backdrop: 'static',
            keyboard: true
        });
        $('#createStadiumModal').modal('show');
    }

    function closeCreateStadiumModal() {
        $('#createStadiumModal').modal('hide');
        setTimeout(function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        }, 150);
    }

    function handleStadiumChange(stadiumId) {
        if (!stadiumId) return;

        if (stadiumId === '__create_new__') {
            openCreateStadiumModal();
            // Revert dropdown to previous active stadium
            if (currentActiveStadiumId) {
                $('#stadium_select_tab1').val(currentActiveStadiumId);
            }
            return;
        }

        currentActiveStadiumId = stadiumId;

        // Fetch stadium details via AJAX for Tab 1
        $.ajax({
            url: "{{ route('adminGetStadiumDetails') }}",
            type: "GET",
            data: {
                stadium_id: stadiumId
            },
            dataType: "json",
            success: function(response) {
                if (!response.error) {
                    var st = response.stadium;
                    // Update Tab 1 inputs
                    $('#tab1_stadium_name').val(st.studium_name || '');
                    $('#tab1_address').val(st.address || '');
                    $('#tab1_latitude').val(st.latitude || '');
                    $('#tab1_longitude').val(st.longitude || '');
                }
            },
            error: function() {
                toastr.error("Could not fetch stadium details.");
            }
        });
    }

    var allStadiumsList = @json($stadiums);

    // AJAX Submission to Create New Stadium by Officer (RSO / SO / DSO)
    $('#createStadiumForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var submitBtn = $('#saveNewStadiumBtn');
        var originalBtnHtml = submitBtn.html();

        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving...');

        $.ajax({
            url: "{{ route('adminCreateStadiumByOfficer') }}",
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (!res.error && res.stadium) {
                    var stadium = res.stadium;
                    toastr.success(res.msg || "New stadium created successfully.");

                    // 1. Add to allStadiumsList array for future dynamic rows
                    allStadiumsList.push(stadium);

                    var displayName = stadium.studium_name + (stadium.district_name ? ' (' + stadium.district_name + ')' : '');

                    // 2. Remove "No stadiums found" option if it exists
                    $('#stadium_select_tab1 option[value=""]').remove();

                    // 3. Add to Tab 1 dropdown before the "+ Add New Stadium..." option
                    var newOptionHtml = '<option value="' + stadium.id + '">' + $('<div>').text(displayName).html() + '</option>';
                    var $createOpt = $('#stadium_select_tab1 option[value="__create_new__"]');
                    if ($createOpt.length) {
                        $(newOptionHtml).insertBefore($createOpt);
                    } else {
                        $('#stadium_select_tab1').append(newOptionHtml);
                    }

                    // Select the newly created stadium in Tab 1
                    currentActiveStadiumId = stadium.id;
                    $('#stadium_select_tab1').val(stadium.id);

                    // 4. Update Tab 1 inputs with new stadium data
                    $('#tab1_stadium_name').val(stadium.studium_name || '');
                    $('#tab1_address').val(stadium.address || '');
                    $('#tab1_latitude').val(stadium.latitude || '');
                    $('#tab1_longitude').val(stadium.longitude || '');

                    // 5. Add option to Tab 2 filter dropdown
                    $('#stadium_filter_tab2').append(newOptionHtml);

                    // 6. Add option to all existing Tab 2 row dropdowns
                    $('.infra-row-stadium').each(function() {
                        $(this).append(newOptionHtml);
                    });

                    // 7. Reset and close modal
                    form.reset();
                    closeCreateStadiumModal();
                } else {
                    toastr.error(res.msg || "Failed to create stadium.");
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(field, msgs) {
                        $.each(msgs, function(i, msg) {
                            toastr.error(msg);
                        });
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.msg) {
                    toastr.error(xhr.responseJSON.msg);
                } else {
                    toastr.error("An error occurred while creating stadium.");
                }
            }
        });
    });

    function getStadiumSelectOptionsHtml(selectedStadiumId) {
        var isNoneSel = (!selectedStadiumId) ? ' selected' : '';
        var html = '<option value=""' + isNoneSel + '>Select Stadium</option>';
        if (allStadiumsList && allStadiumsList.length > 0) {
            $.each(allStadiumsList, function(i, st) {
                var label = st.studium_name + (st.district_name ? ' (' + st.district_name + ')' : '');
                var isSel = (selectedStadiumId && selectedStadiumId == st.id) ? ' selected' : '';
                html += '<option value="' + st.id + '"' + isSel + '>' + $('<div>').text(label).html() + '</option>';
            });
        }
        return html;
    }

    function updateRowIndexes() {
        var allRows = $('#infra_table_body tr.infra-row');
        var isOnlyOne = (allRows.length <= 1);

        allRows.each(function() {
            var btn = $(this).find('.delete-btn');
            btn.prop('disabled', isOnlyOne);
            if (isOnlyOne) {
                btn.attr('title', 'Cannot delete the only row');
            } else {
                btn.attr('title', 'Delete Infrastructure');
            }
        });

        var idx = 1;
        $('#infra_table_body tr.infra-row:visible').each(function() {
            $(this).find('.infra-row-index').text(idx++);
        });
    }

    function onStadiumSelectChange(selectElem) {
        var select = $(selectElem);
        var chosenId = select.val();
        var currentRow = select.closest('tr');

        if (!chosenId) {
            currentRow.attr('data-stadium', '');
            return;
        }

        currentRow.attr('data-stadium', chosenId);
        select.removeClass('is-invalid');
    }

    function addNewInfraRow(presetStadiumId) {
        $('#no_infra_row').remove();
        $('#filter_no_row').remove();

        var currentFilter = presetStadiumId || $('#stadium_filter_tab2').val();
        var defaultStadium = (currentFilter && currentFilter !== 'all') ? currentFilter : '';

        var optionsHtml = getStadiumSelectOptionsHtml(defaultStadium);

        var newRowHtml = '<tr class="infra-row new-row" data-id="" data-stadium="' + defaultStadium + '">' +
            '<td class="text-center infra-row-index align-middle"></td>' +
            '<td class="align-middle">' +
            '<select class="form-select custom-select-icon infra-row-stadium" required onchange="onStadiumSelectChange(this)">' +
            optionsHtml +
            '</select>' +
            '</td>' +
            '<td class="align-middle">' +
            '<textarea class="form-control infra-row-name" rows="2" placeholder="e.g. Badminton Hall, Synthetic Track" required></textarea>' +
            '</td>' +
            '<td class="align-middle">' +
            '<textarea class="form-control infra-row-games" rows="2" placeholder="e.g. Badminton, Table Tennis, Squash"></textarea>' +
            '</td>' +
            '<td class="text-center align-middle">' +
            '<button type="button" class="action-icon-btn delete-btn" title="Delete Infrastructure" onclick="deleteInfraRow(this, null)">' +
            '<i class="fa fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';

        $('#infra_table_body').append(newRowHtml);
        updateRowIndexes();

        var newlyAdded = $('#infra_table_body tr.infra-row').last();
        newlyAdded.find('.infra-row-name').focus();
    }

    function resetStadiumFilter() {
        $('#stadium_filter_tab2').val('all').trigger('change');
    }

    function getEmptyTableHtml() {
        return '<tr id="no_infra_row">' +
            '<td colspan="5" class="text-center py-5 border-0 bg-white">' +
            '<div class="empty-filter-state d-flex flex-column align-items-center justify-content-center py-3">' +
            '<div class="empty-state-icon-wrapper mb-3" style="background: #f8fafc; border-color: #cbd5e1; color: #64748b;">' +
            '<i class="fa fa-building-o"></i>' +
            '</div>' +
            '<h5 class="font-weight-bold text-dark mb-2" style="font-size: 16px;">' +
            'No Stadium Infrastructures Added Yet' +
            '</h5>' +
            '<p class="text-muted mb-3" style="max-width: 460px; font-size: 13.5px; line-height: 1.6;">' +
            'Add infrastructure details such as badminton halls, synthetic tracks, gymnasiums, and available games for stadiums in your jurisdiction.' +
            '</p>' +
            '<button type="button" class="btn btn-outline-success px-4 py-2 font-weight-bold" onclick="addNewInfraRow()" style="border-radius: 6px; font-size: 13.5px;">' +
            '<i class="fa fa-plus-circle mr-1"></i> Add Infrastructure' +
            '</button>' +
            '</div>' +
            '</td>' +
            '</tr>';
    }

    function filterInfraByStadium(stadiumId) {
        $('#filter_no_row').remove();
        var visibleCount = 0;

        $('#infra_table_body tr.infra-row').each(function() {
            var rowStadium = $(this).attr('data-stadium') || $(this).find('.infra-row-stadium').val();
            if (stadiumId === 'all' || rowStadium == stadiumId) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });

        // Update active filter badge
        if (stadiumId === 'all') {
            $('#filter_active_label').html('All Stadiums <span class="text-muted font-weight-normal">(' + visibleCount + ')</span>');
        } else {
            var selectedStadiumText = $('#stadium_filter_tab2 option:selected').text().trim().replace(/^--\s*/, '').replace(/\s*--$/, '');
            $('#filter_active_label').html('<span class="text-primary font-weight-bold">' + $('<div>').text(selectedStadiumText).html() + '</span>');
        }

        if (visibleCount === 0 && $('#infra_table_body tr.infra-row').length > 0) {
            var selectedStadiumText = $('#stadium_filter_tab2 option:selected').text().trim().replace(/^--\s*/, '').replace(/\s*--$/, '');
            var safeStadiumName = $('<div>').text(selectedStadiumText).html();

            var msg = '<tr id="filter_no_row">' +
                '<td colspan="5" class="text-center py-5 border-0 bg-white">' +
                '<div class="empty-filter-state d-flex flex-column align-items-center justify-content-center py-3">' +
                '<div class="empty-state-icon-wrapper mb-3">' +
                '<i class="fa fa-map-marker text-primary"></i>' +
                '</div>' +
                '<h5 class="font-weight-bold text-dark mb-2" style="font-size: 16px;">' +
                'No Infrastructure Details for this Stadium' +
                '</h5>' +
                '<p class="text-muted mb-3" style="max-width: 520px; font-size: 13.5px; line-height: 1.6;">' +
                'There is currently no infrastructure added for <strong class="text-primary">' + safeStadiumName + '</strong>. You can add infrastructure details now or view all stadiums.' +
                '</p>' +
                '<div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: 12px;">' +
                '<button type="button" class="btn btn-primary px-3 py-2 font-weight-bold shadow-sm" onclick="addNewInfraRow(\'' + stadiumId + '\')" style="border-radius: 6px; font-size: 13.5px;">' +
                '<i class="fa fa-plus-circle mr-1"></i> Add Infrastructure for this Stadium' +
                '</button>' +
                '<button type="button" class="btn btn-outline-secondary px-3 py-2 font-weight-bold" onclick="resetStadiumFilter()" style="border-radius: 6px; font-size: 13.5px;">' +
                '<i class="fa fa-list mr-1"></i> View All Stadiums' +
                '</button>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#infra_table_body').append(msg);
        }

        updateRowIndexes();
    }

    function deleteInfraRow(btn, id) {
        if ($(btn).is(':disabled') || $(btn).prop('disabled')) {
            return false;
        }

        var row = $(btn).closest('tr');
        if (!id) {
            row.fadeOut(200, function() {
                row.remove();
                if ($('#infra_table_body tr.infra-row').length === 0) {
                    $('#infra_table_body').html(getEmptyTableHtml());
                } else {
                    updateRowIndexes();
                }
            });
            return;
        }

        var doDelete = function() {
            $.ajax({
                url: "{{ url('admin/profile/delete-infrastructure') }}/" + id,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (!response.error) {
                        toastr.success(response.msg || "Infrastructure deleted successfully.");
                        row.fadeOut(300, function() {
                            row.remove();
                            if ($('#infra_table_body tr.infra-row').length === 0) {
                                $('#infra_table_body').html(getEmptyTableHtml());
                            } else {
                                updateRowIndexes();
                            }
                        });
                    } else {
                        toastr.error(response.msg || "Could not delete.");
                    }
                },
                error: function() {
                    toastr.error("An error occurred while deleting.");
                }
            });
        };

        if (typeof swal === 'function') {
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete this infrastructure?",
                icon: "warning",
                buttons: ["Cancel", "Yes, Delete"],
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    doDelete();
                }
            });
        } else {
            if (confirm("Are you sure you want to delete this infrastructure?")) {
                doDelete();
            }
        }
    }

    function saveAllInfrastructures() {
        var rows = [];
        var hasError = false;

        $('#infra_table_body .is-invalid').removeClass('is-invalid');

        var allRows = $('#infra_table_body tr.infra-row');
        if (allRows.length === 0) {
            toastr.info("No infrastructure records to save. Click 'Add Another Row' to create one.");
            return;
        }

        for (var i = 0; i < allRows.length; i++) {
            var row = $(allRows[i]);
            var rowNum = row.find('.infra-row-index').text().trim() || (i + 1);
            var id = row.data('id') || null;
            var stadiumSelect = row.find('.infra-row-stadium');
            var stadiumId = stadiumSelect.val();
            var stadiumName = stadiumSelect.find('option:selected').text().trim();
            var nameTextarea = row.find('.infra-row-name');
            var infraName = $.trim(nameTextarea.val());
            var games = $.trim(row.find('.infra-row-games').val());

            if (!stadiumId) {
                var stadiumMsg = allRows.length > 1 ?
                    "Please select a stadium for row " + rowNum + "." :
                    "Please select a stadium.";
                toastr.error(stadiumMsg);
                stadiumSelect.addClass('is-invalid').focus();
                hasError = true;
                break;
            }

            if (!infraName) {
                var infraMsg = allRows.length > 1 ?
                    "Please enter an infrastructure name for row " + rowNum + "." :
                    "Please enter an infrastructure name.";
                toastr.error(infraMsg);
                nameTextarea.addClass('is-invalid').focus();
                hasError = true;
                break;
            }

            rows.push({
                id: id,
                stadium_id: stadiumId,
                infrastructure_name: infraName,
                available_games: games
            });
        }

        if (hasError) return;

        if (rows.length === 0) {
            toastr.info("No infrastructure records to save. Click 'Add Another Row' to create one.");
            return;
        }

        var saveBtn = $('#btn_save_all_infra');
        var originalHtml = saveBtn.html();
        saveBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> SAVING ALL');

        $.ajax({
            url: "{{ route('adminSaveAllInfrastructures') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                infrastructures: rows
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                saveBtn.prop('disabled', false).html(originalHtml);
                if (!response.error) {
                    toastr.success(response.msg || "All infrastructures saved successfully.");
                    renderInfraTable(response.infrastructures);
                } else {
                    toastr.error(response.msg || "Error saving infrastructures.");
                }
            },
            error: function(xhr) {
                saveBtn.prop('disabled', false).html(originalHtml);
                if (xhr.responseJSON && xhr.responseJSON.msg) {
                    toastr.error(xhr.responseJSON.msg);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("An error occurred while saving infrastructures.");
                }
            }
        });
    }

    function renderInfraTable(list) {
        var tbody = $('#infra_table_body');
        tbody.empty();

        if (!list || list.length === 0) {
            tbody.html(getEmptyTableHtml());
            return;
        }

        $.each(list, function(idx, item) {
            var optionsHtml = getStadiumSelectOptionsHtml(item.stadium_id);
            var safeName = $('<div>').text(item.infrastructure_name).html();
            var safeGames = $('<div>').text(item.available_games || '').html();

            var rowHtml = '<tr class="infra-row" data-id="' + item.id + '" data-stadium="' + item.stadium_id + '">' +
                '<td class="text-center infra-row-index align-middle">' + (idx + 1) + '</td>' +
                '<td class="align-middle">' +
                '<select class="form-select custom-select-icon infra-row-stadium" required onchange="onStadiumSelectChange(this)">' +
                optionsHtml +
                '</select>' +
                '</td>' +
                '<td class="align-middle">' +
                '<textarea class="form-control infra-row-name" rows="2" placeholder="e.g. Badminton Hall, Synthetic Track" required>' + safeName + '</textarea>' +
                '</td>' +
                '<td class="align-middle">' +
                '<textarea class="form-control infra-row-games" rows="2" placeholder="e.g. Badminton, Table Tennis, Squash">' + safeGames + '</textarea>' +
                '</td>' +
                '<td class="text-center align-middle">' +
                '<button type="button" class="action-icon-btn delete-btn" title="Delete Infrastructure" onclick="deleteInfraRow(this, ' + item.id + ')">' +
                '<i class="fa fa-trash"></i>' +
                '</button>' +
                '</td>' +
                '</tr>';

            tbody.append(rowHtml);
        });

        // Re-apply filter if active
        var currentFilter = $('#stadium_filter_tab2').val();
        if (currentFilter && currentFilter !== 'all') {
            filterInfraByStadium(currentFilter);
        } else {
            updateRowIndexes();
        }
    }

    $(document).on('change', '.infra-row-stadium', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });

    $(document).on('input', '.infra-row-name', function() {
        if ($.trim($(this).val())) {
            $(this).removeClass('is-invalid');
        }
    });

    $('#createStadiumModal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
        if ($('#createStadiumForm').length) {
            $('#createStadiumForm')[0].reset();
        }
    });

    $(document).on('click', '.modal-backdrop', function() {
        closeCreateStadiumModal();
    });

    $(document).ready(function() {
        if ($('#createStadiumModal').length) {
            $('#createStadiumModal').appendTo('body');
        }
        @if(count($infrastructures) == 0 && count($stadiums) > 0)
        addNewInfraRow();
        @endif
        updateRowIndexes();
    });
</script>

@endsection