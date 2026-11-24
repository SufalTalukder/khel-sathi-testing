{{-- 
    Applicant Dashboard Status Cell & Rejection Modal Partial
    Variables required:
    - $item (application object)
    - $type (string: 'academy', 'association', 'swimming', 'gym')
--}}
<td class="text-center align-middle">
    @if ($item->final_submit == 1)
        {{-- Rejected --}}
        @if ($item->status == 2)
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#userRejectModal_{{ $item->id }}_{{ $type }}">
                <i class="fa fa-times-circle"></i> Rejected
            </button>

            <!-- Rejection Details Modal -->
            <div class="modal fade" id="userRejectModal_{{ $item->id }}_{{ $type }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog text-start">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="fa fa-info-circle"></i> Application Rejection Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-1"><strong>Application No:</strong> {{ $item->application_no ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Rejected On:</strong> {{ dmy($item->accept_reject_date) }}</p>
                            <label class="fw-bold text-muted">Reasons for Rejection:</label>
                            <div class="p-2 bg-light border rounded mb-3 text-dark">
                                {{ $item->remark ?? 'No specific reasons provided.' }}
                            </div>
                            @if (!empty($item->rejection_doc))
                                <div class="mb-2">
                                    <label class="fw-bold">Supporting Document:</label><br>
                                    <a href="{{ asset('public/private_coaching_storage/rejection_doc/' . $item->rejection_doc) }}" target="_blank" class="btn btn-sm btn-outline-danger mt-1">
                                        <i class="fa fa-file-pdf-o"></i> Download Supporting Document (PDF)
                                    </a>
                                </div>
                            @endif
                            @if (!empty($item->inspection_report))
                                <div class="mb-2">
                                    <label class="fw-bold">Inspection Report:</label><br>
                                    <a href="{{ asset('public/private_coaching_storage/inspection_report/' . $item->inspection_report) }}" target="_blank" class="btn btn-sm btn-outline-info mt-1">
                                        <i class="fa fa-file-pdf-o"></i> Download Inspection Report (PDF)
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        {{-- Certificate Issued --}}
        @elseif (!empty($item->certificate_file))
            <span class="badge bg-success mb-1 d-block">Certificate Issued</span>
            @if (!empty($item->certificate_valid_upto))
                <small class="d-block text-muted mb-1">Valid Upto: <strong>{{ dmy($item->certificate_valid_upto) }}</strong></small>
            @endif
            <a href="{{ asset('public/private_coaching_storage/certificate/' . $item->certificate_file) }}" target="_blank" class="btn btn-success btn-xs" download>
                <i class="fa fa-download"></i> Certificate
            </a>

        {{-- Fees Paid, Certificate Pending --}}
        @elseif ($item->status == 1 && $item->fee_status == 1)
            <span class="badge bg-primary">Fees Paid</span>
            <small class="d-block text-muted">Certificate Pending</small>

        {{-- Inspection Approved, Fees Pending --}}
        @elseif ($item->status == 1 && $item->fee_status == 0)
            <span class="badge bg-warning text-dark">Fee Pending</span>
            <div class="small fw-bold text-danger mt-1">
                Amount: ₹{{ number_format($item->protsahan_samiti_fee ?? 0, 2) }}
            </div>
            @if (!empty($item->inspection_report))
                <a href="{{ asset('public/private_coaching_storage/inspection_report/' . $item->inspection_report) }}" target="_blank" class="btn btn-outline-info btn-xs mt-1">
                    <i class="fa fa-file-pdf-o"></i> Report
                </a>
            @endif

        {{-- Inspection Scheduled --}}
        @elseif (!empty($item->inspection_date) && empty($item->inspection_report))
            <span class="badge bg-info text-dark">Inspection Scheduled</span>
            <div class="small text-muted mt-1">
                Date: <strong>{{ dmy($item->inspection_date) }}</strong>
            </div>

        {{-- Query Marked / Re-Submitted --}}
        @elseif ($item->query_status == 1)
            <span class="badge bg-warning text-dark">Query Marked</span>
        @elseif ($item->query_status == 2)
            <span class="badge bg-info">Re-Submitted</span>

        {{-- Submitted --}}
        @else
            <span class="badge bg-success">Submitted</span>
        @endif
    @else
        <span class="badge bg-secondary">Pending</span>
    @endif
</td>
