{{-- 
    Institutions Workflow Actions & Modals Partial
    Variables required:
    - $application (object)
    - $categoryValue (int: 1=Coaching, 2=Gym, 3=Academy, 4=Swimming Pool)
--}}
@php
    $appId = $application->id_application ?? $application->id;
@endphp

<style>
    .workflow-btn-group {
        display: inline-flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
    }
    .workflow-btn-group .btn,
    .pageheader .workflow-btn-group .btn {
        width: auto !important;
        height: auto !important;
        min-height: 31px !important;
        white-space: nowrap !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        padding: 5px 12px !important;
        font-size: 13px !important;
        line-height: 1.3 !important;
        margin: 0 !important;
        float: none !important;
    }
    .workflow-btn-group .btn i,
    .workflow-btn-group .btn span,
    .pageheader .workflow-btn-group .btn i,
    .pageheader .workflow-btn-group .btn span {
        float: none !important;
        margin: 0 !important;
        line-height: 1 !important;
    }
    .workflow-btn-group .badge {
        width: auto !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
        padding: 6px 12px !important;
        font-size: 13px !important;
        margin: 0 !important;
        float: none !important;
        line-height: 1.3 !important;
    }
    .workflow-header-toolbar {
        display: inline-flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        margin-left: auto !important;
    }
    .workflow-header-toolbar .btn,
    .pageheader .workflow-header-toolbar .btn {
        width: auto !important;
        height: auto !important;
        min-height: 31px !important;
        white-space: nowrap !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        padding: 5px 14px !important;
        font-size: 13px !important;
        line-height: 1.3 !important;
        margin: 0 !important;
        float: none !important;
    }
    .workflow-header-toolbar .btn i,
    .workflow-header-toolbar .btn span,
    .pageheader .workflow-header-toolbar .btn i,
    .pageheader .workflow-header-toolbar .btn span {
        float: none !important;
        margin: 0 !important;
        line-height: 1 !important;
    }

    /* Fix Bootstrap 5 Modal Stacking, Backdrop and Header Positioning */
    .modal-backdrop {
        z-index: 1060 !important;
        opacity: 0.5 !important;
    }
    .modal {
        z-index: 1070 !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }
    .modal-dialog {
        z-index: 1075 !important;
        margin-top: 80px !important;
        margin-bottom: 40px !important;
    }
    .modal-dialog.modal-dialog-centered {
        display: flex !important;
        align-items: center !important;
        min-height: calc(100% - 100px) !important;
        margin-top: 50px !important;
        margin-bottom: 50px !important;
    }
    .modal-content {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25) !important;
        border-radius: 8px !important;
        border: 1px solid rgba(0,0,0,0.1) !important;
    }
    #toast-container {
        z-index: 999999 !important;
    }
    #toast-container > div {
        opacity: 1 !important;
    }
</style>

<!-- Status Badges & Action Buttons -->
<div class="workflow-btn-group">
    {{-- Query Modal Trigger --}}
    @if ($application->final_submit == 1)
        @if ($application->query_status == 1)
            <button type="button" data-bs-toggle="modal" data-bs-target="#queryModal" class="btn btn-outline-warning btn-sm rounded-pill">
                <i class="fa fa-question-circle"></i> Query Marked
            </button>
        @elseif ($application->query_status == 2)
            <button type="button" data-bs-toggle="modal" data-bs-target="#queryModal" class="btn btn-outline-info btn-sm rounded-pill">
                <i class="fa fa-question-circle"></i> Query Re-Submitted
            </button>
        @else
            <button type="button" data-bs-toggle="modal" data-bs-target="#queryModal" class="btn btn-outline-info btn-sm rounded-pill">
                <i class="fa fa-question-circle"></i> Query
            </button>
        @endif
    @endif

    {{-- Rejection Status --}}
    @if ($application->status == 2 && $application->final_submit == 1)
        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#viewRejectionModal">
            <i class="fa fa-info-circle"></i> Rejected (View Details)
        </button>
    @elseif ($application->final_submit == 1)
        {{-- Certificate Issued --}}
        @if (!empty($application->certificate_file))
            <span class="badge bg-success rounded-pill">
                <i class="fa fa-check-circle"></i> Certificate Issued ({{ dmy($application->certificate_issue_date) }})
            </span>
            @if (!empty($application->certificate_valid_upto))
                <span class="badge bg-info text-dark rounded-pill">
                    <i class="fa fa-calendar-check-o"></i> Valid Upto: {{ dmy($application->certificate_valid_upto) }}
                    @if (!empty($application->certificate_validity))
                        ({{ $application->certificate_validity }})
                    @endif
                </span>
            @endif
            <a href="{{ asset('public/private_coaching_storage/certificate/' . $application->certificate_file) }}" target="_blank" class="btn btn-success btn-sm rounded-pill">
                <i class="fa fa-certificate"></i> View Certificate
            </a>

        {{-- Fees Paid, Certificate Pending --}}
        @elseif ($application->status == 1 && $application->fee_status == 1)
            <span class="badge bg-primary rounded-pill">
                <i class="fa fa-credit-card"></i> Fees Paid ({{ dmy($application->fee_paid_date) }})
            </span>
            @if (!empty($application->inspection_report))
                <a href="{{ asset('public/private_coaching_storage/inspection_report/' . $application->inspection_report) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill">
                    <i class="fa fa-file-pdf-o"></i> Inspection Report
                </a>
            @endif
            <button type="button" class="btn btn-success btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadCertificateModal">
                <i class="fa fa-upload"></i> Upload Certificate
            </button>

        {{-- Inspection Approved, Fees Pending --}}
        @elseif ($application->status == 1 && $application->fee_status == 0)
            <span class="badge bg-warning text-dark rounded-pill">
                <i class="fa fa-clock-o"></i> Fees Pending: ₹{{ number_format($application->protsahan_samiti_fee ?? 0, 2) }}
            </span>
            @if (!empty($application->inspection_report))
                <a href="{{ asset('public/private_coaching_storage/inspection_report/' . $application->inspection_report) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill">
                    <i class="fa fa-file-pdf-o"></i> Inspection Report
                </a>
            @endif
            <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#markFeePaidModal">
                <i class="fa fa-check-circle"></i> Mark Fee as Paid
            </button>

        {{-- Inspection Scheduled, Report Pending --}}
        @elseif (!empty($application->inspection_date) && empty($application->inspection_report))
            <span class="badge bg-info text-dark rounded-pill">
                <i class="fa fa-calendar"></i> Inspection Date: {{ dmy($application->inspection_date) }}
            </span>
            <button type="button" class="btn btn-outline-success btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#inspectionReportModal">
                <i class="fa fa-file-text-o"></i> Upload Inspection Report
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#inspectionDateModal">
                <i class="fa fa-calendar"></i> Reschedule
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fa fa-times"></i> Reject
            </button>

        {{-- Fresh Application / Initial State --}}
        @else
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fa fa-times"></i> Reject
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#inspectionDateModal">
                <i class="fa fa-calendar-check-o"></i> Mark Inspection Date
            </button>
        @endif
    @endif
</div>

<!-- =========================================================================
     MODAL 1: Mark Inspection Date
     ========================================================================= -->
<div class="modal fade" id="inspectionDateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inspectionDateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inspectionDateLabel"><i class="fa fa-calendar"></i> Schedule Physical Inspection Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin_private_coaching_mark_inspection_date') }}" method="post" class="wf-ajax-form">
                @csrf
                <input type="hidden" name="application_id" value="{{ $appId }}">
                <input type="hidden" name="value" value="{{ $categoryValue }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Inspection Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="inspection_date" value="{{ $application->inspection_date ?? date('Y-m-d') }}" required>
                        <small class="text-muted">Applicant will be notified of this scheduled inspection date.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Inspection Date</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 2: Upload Inspection Report & Decision (Accept / Reject)
     ========================================================================= -->
<div class="modal fade" id="inspectionReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inspectionReportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inspectionReportLabel"><i class="fa fa-clipboard"></i> Upload Inspection Report & Application Decision</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin_private_coaching_inspection_report_submit') }}" method="post" enctype="multipart/form-data" class="wf-ajax-form">
                @csrf
                <input type="hidden" name="application_id" value="{{ $appId }}">
                <input type="hidden" name="value" value="{{ $categoryValue }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Inspection Report (PDF only, Max 2MB) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control wf-pdf-file" name="inspection_report" accept="application/pdf" required>
                        <small class="text-muted">Upload the completed and signed physical inspection report.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Application Decision <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input wf-decision-radio" type="radio" name="decision" id="decisionAccept" value="1" checked>
                                <label class="form-check-label text-success fw-bold" for="decisionAccept">
                                    <i class="fa fa-check"></i> Accept Application
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input wf-decision-radio" type="radio" name="decision" id="decisionReject" value="2">
                                <label class="form-check-label text-danger fw-bold" for="decisionReject">
                                    <i class="fa fa-times"></i> Reject Application
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Protsahan Samiti Fee Section (Shown when Accept is selected) --}}
                    <div id="wfFeeSection" class="mb-3">
                        <label class="form-label fw-bold">Protsahan Samiti Fees Amount (₹) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control" name="protsahan_samiti_fee" id="wfProtsahanFee" placeholder="Enter amount to be paid by applicant (e.g. 5000)" value="{{ $application->protsahan_samiti_fee ?? '' }}" required>
                        </div>
                        <small class="text-muted">This fee amount will be displayed to the applicant on their dashboard for payment.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" id="wfInspectionRemarkLabel">Remarks</label>
                        <textarea class="form-control" name="remark" rows="3" placeholder="Enter remarks (mandatory if rejecting)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit Decision</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 3: Mark Protsahan Samiti Fees as Paid
     ========================================================================= -->
<div class="modal fade" id="markFeePaidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="markFeePaidLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markFeePaidLabel"><i class="fa fa-money"></i> Mark Fees as Paid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin_private_coaching_mark_fee_paid') }}" method="post" class="wf-ajax-form">
                @csrf
                <input type="hidden" name="application_id" value="{{ $appId }}">
                <input type="hidden" name="value" value="{{ $categoryValue }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Received Amount (₹) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control" name="protsahan_samiti_fee" value="{{ $application->protsahan_samiti_fee ?? '' }}" placeholder="Enter fee amount received" required>
                        </div>
                        <small class="text-muted">Confirm or update the exact payment amount received.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date of Payment <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="fee_paid_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <p class="text-muted mb-0">Are you sure you want to mark this applicant's Protsahan Samiti fees as paid?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Confirm Fees Paid</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 4: Upload Registration Certificate
     ========================================================================= -->
<div class="modal fade" id="uploadCertificateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadCertificateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCertificateLabel"><i class="fa fa-certificate"></i> Upload Registration Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin_private_coaching_upload_certificate') }}" method="post" enctype="multipart/form-data" class="wf-ajax-form">
                @csrf
                <input type="hidden" name="application_id" value="{{ $appId }}">
                <input type="hidden" name="value" value="{{ $categoryValue }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Certificate File (PDF only, Max 2MB) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control wf-pdf-file" name="certificate_file" accept="application/pdf" required>
                        <small class="text-muted">Once uploaded, the applicant will be able to download this certificate from their dashboard.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Certificate Issue Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="certificate_issue_date" id="wfCertIssueDate" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Certificate Validity Option <span class="text-danger">*</span></label>
                        <select class="form-select" name="certificate_validity" id="wfCertValiditySelect" required>
                            <option value="1 Year" selected>1 Year</option>
                            <option value="2 Years">2 Years</option>
                            <option value="3 Years">3 Years</option>
                            <option value="5 Years">5 Years</option>
                            <option value="Custom">Custom Date</option>
                        </select>
                        <small class="text-muted">Select a standard validity duration or choose Custom Date to specify manually.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Certificate Valid Upto Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="certificate_valid_upto" id="wfCertValidUpto" value="{{ date('Y-m-d', strtotime('+1 year')) }}" min="{{ date('Y-m-d') }}" required>
                        <small class="text-muted">Expiration / validity date of this registration certificate.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload & Issue Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 5: Reject Application (with Reason & Optional Supporting PDF)
     ========================================================================= -->
<div class="modal fade" id="rejectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="rejectModalLabel"><i class="fa fa-times-circle"></i> Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin_private_coaching_accepted_reject_status') }}" method="post" enctype="multipart/form-data" class="wf-ajax-form">
                @csrf
                <input type="hidden" name="application_id" value="{{ $appId }}">
                <input type="hidden" name="status" value="2">
                <input type="hidden" name="value" value="{{ $categoryValue }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rejection Reasons <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="remark" rows="3" required placeholder="Specify reason for rejection. This will be visible to the applicant."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Supporting Document (Non-mandatory, PDF only, Max 2MB)</label>
                        <input type="file" class="form-control wf-pdf-file" name="rejection_doc" accept="application/pdf">
                        <small class="text-muted">Optional: Upload an official rejection order or supporting notice in PDF format.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 6: View Rejection Details (for Admin viewing rejected record)
     ========================================================================= -->
@if ($application->status == 2)
<div class="modal fade" id="viewRejectionModal" tabindex="-1" aria-labelledby="viewRejectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="viewRejectionLabel"><i class="fa fa-info-circle"></i> Rejection Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Rejection Date:</strong> {{ dmy($application->accept_reject_date) }}</p>
                <p><strong>Reasons:</strong></p>
                <div class="p-2 bg-light border rounded mb-3">
                    {{ $application->remark ?? 'No reasons specified.' }}
                </div>
                @if (!empty($application->rejection_doc))
                    <p>
                        <strong>Supporting Document:</strong><br>
                        <a href="{{ asset('public/private_coaching_storage/rejection_doc/' . $application->rejection_doc) }}" target="_blank" class="btn btn-sm btn-outline-danger mt-1">
                            <i class="fa fa-file-pdf-o"></i> Download Supporting Document (PDF)
                        </a>
                    </p>
                @endif
                @if (!empty($application->inspection_report))
                    <p>
                        <strong>Inspection Report:</strong><br>
                        <a href="{{ asset('public/private_coaching_storage/inspection_report/' . $application->inspection_report) }}" target="_blank" class="btn btn-sm btn-outline-info mt-1">
                            <i class="fa fa-file-pdf-o"></i> Download Inspection Report (PDF)
                        </a>
                    </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Relocate all modals directly to body to avoid parent stacking context & backdrop trapping
    $('.modal').appendTo('body');
    $(document).on('show.bs.modal', '.modal', function() {
        $(this).appendTo('body');
    });

    // Dynamic Protsahan Fee field display toggle on Decision radio change
    document.querySelectorAll('.wf-decision-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var feeSection = document.getElementById('wfFeeSection');
            var feeInput = document.getElementById('wfProtsahanFee');
            var remarkInput = document.querySelector('#inspectionReportModal textarea[name="remark"]');
            var remarkLabel = document.getElementById('wfInspectionRemarkLabel');
            if (this.value === '1') {
                if (feeSection) feeSection.style.display = 'block';
                if (feeInput) feeInput.setAttribute('required', 'required');
                if (remarkInput) remarkInput.removeAttribute('required');
                if (remarkLabel) remarkLabel.innerHTML = 'Remarks';
            } else {
                if (feeSection) feeSection.style.display = 'none';
                if (feeInput) feeInput.removeAttribute('required');
                if (remarkInput) remarkInput.setAttribute('required', 'required');
                if (remarkLabel) remarkLabel.innerHTML = 'Remarks (Rejection Reason) <span class="text-danger">*</span>';
            }
        });
    });

    // Toastr helper function
    function showWfToast(type, msg) {
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": 8000,
                "extendedTimeOut": 4000
            };
            if (type === 'success') {
                toastr.success(msg);
            } else if (type === 'error') {
                toastr.error(msg);
            } else if (type === 'warning') {
                toastr.warning(msg);
            } else {
                toastr.info(msg);
            }
        } else if (type === 'success' && typeof success === 'function') {
            success(msg);
        } else if (type === 'error' && typeof error === 'function') {
            error(msg);
        } else {
            alert(msg);
        }
    }

    // Client-side file size (< 2MB) and PDF validation
    document.querySelectorAll('.wf-pdf-file').forEach(function(fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var file = this.files[0];
                var maxSize = 2 * 1024 * 1024; // 2MB
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    showWfToast('error', 'Invalid file type! Please upload a PDF file only.');
                    this.value = '';
                    return false;
                }
                if (file.size > maxSize) {
                    showWfToast('error', 'File is too large! Maximum allowed file size is 2MB.');
                    this.value = '';
                    return false;
                }
            }
        });
    });

    // Auto-calculate Certificate Valid Upto based on Issue Date and Validity Option
    function updateCertValidityDate() {
        var issueDateInput = document.getElementById('wfCertIssueDate');
        var validitySelect = document.getElementById('wfCertValiditySelect');
        var validUptoInput = document.getElementById('wfCertValidUpto');

        if (!issueDateInput || !validitySelect || !validUptoInput) return;

        var issueDateVal = issueDateInput.value;
        if (!issueDateVal) return;

        validUptoInput.min = issueDateVal;

        var selectedVal = validitySelect.value;
        if (selectedVal === 'Custom') {
            return;
        }

        var parts = issueDateVal.split('-');
        if (parts.length === 3) {
            var yyyy = parseInt(parts[0], 10);
            var mm = parts[1];
            var dd = parts[2];

            var yearsToAdd = 1;
            if (selectedVal === '2 Years') yearsToAdd = 2;
            else if (selectedVal === '3 Years') yearsToAdd = 3;
            else if (selectedVal === '5 Years') yearsToAdd = 5;

            var newYear = yyyy + yearsToAdd;
            validUptoInput.value = newYear + '-' + mm + '-' + dd;
        }
    }

    var issueDateEl = document.getElementById('wfCertIssueDate');
    var validitySelectEl = document.getElementById('wfCertValiditySelect');
    var validUptoEl = document.getElementById('wfCertValidUpto');

    if (issueDateEl && validitySelectEl && validUptoEl) {
        issueDateEl.addEventListener('change', updateCertValidityDate);
        validitySelectEl.addEventListener('change', updateCertValidityDate);
        validUptoEl.addEventListener('input', function() {
            validitySelectEl.value = 'Custom';
        });
    }

    // AJAX Form Submission for workflow forms
    $(document).on('submit', '.wf-ajax-form', function(e) {
        e.preventDefault();
        var form = this;
        var submitBtn = $(form).find('button[type="submit"]');
        submitBtn.prop('disabled', true).prepend('<i class="fa fa-spinner fa-spin me-1"></i> ');

        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                if (res.error === false) {
                    $('.modal').modal('hide');
                    showWfToast('success', res.msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1400);
                } else {
                    showWfToast('error', res.msg || 'Action failed.');
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).find('.fa-spinner').remove();
                var msg = 'An error occurred while processing your request.';
                if (xhr.responseJSON && xhr.responseJSON.msg) {
                    msg = xhr.responseJSON.msg;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showWfToast('error', msg);
            }
        });
    });
});
</script>
