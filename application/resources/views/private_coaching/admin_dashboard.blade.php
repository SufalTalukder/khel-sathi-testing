@extends('layouts/admin_layout')
@section('content')
    <div class="pageheader" id="menu-margin">
        <h4 class="mb-0">
            List of Applicants who applied for Associations
            <a title="Application Details ExportToExcel" class="btn btn-sm btn-success float-end"
                onclick="ExportToExcel('xlsx')">
                <i class="fa fa-file-excel"></i> Export to Excel
            </a>

            <a href="{{ route('private_coaching_export_pdf', 1) }}" class="btn btn-sm btn-primary float-end me-2" target="_blank"
                rel="noopener noreferrer"> Export PDF</a>

            <a href="{{ route('admin_private_coaching_report', ['category_id' => 1]) }}" class="btn btn-sm btn-info float-end me-2 text-white">
                <i class="fa fa-bar-chart"></i> Fee Report
            </a>
        </h4>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <form class="row g-2 align-items-end" method="get" action="{{ url()->current() }}">
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="status">Application Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ (string)$status === '1' ? 'selected' : '' }}>Accepted</option>
                                <option value="2" {{ (string)$status === '2' ? 'selected' : '' }}>Rejected</option>
                                <option value="0" {{ (string)$status === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="query_marked" {{ $status === 'query_marked' ? 'selected' : '' }}>Query Marked</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="fee_status">Payment Status</label>
                            <select name="fee_status" id="fee_status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ (string)$fee_status === '1' ? 'selected' : '' }}>Paid</option>
                                <option value="0" {{ (string)$fee_status === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="not_set" {{ $fee_status === 'not_set' ? 'selected' : '' }}>Fee Not Set</option>
                            </select>
                        </div>
                    </div>

                    @if(empty(Auth::guard('admin')->user()->district_id) && Auth::guard('admin')->user()->admin_role != 9)
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="district_id">District</label>
                            <select name="district_id" id="district_id" class="form-select">
                                <option value="">All Districts</option>
                                @foreach ($districts as $dst)
                                    <option value="{{ $dst->id }}" {{ (string)$district_id === (string)$dst->id ? 'selected' : '' }}>
                                        {{ repairHindi($dst->city) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-info me-2">Submit</button>
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive table-bordred">
                <table id="dataTable" class="table table_new datatable table-bordred table-hover bg-white">
                    <thead>
                        <tr>

                            <th>S.No.</th>
                            <th>Application No.</th>
                            <th>District</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Institution Name</th>

                            <th>Email ID</th>
                            <th>Mobile No.</th>
                            <th>Sports Name</th>
                            <th class="text-center">Payment Received (₹)</th>
                            <th class="text-center">Status of Application</th>

                            {{-- <th class="text-center">Action</th> --}}
                            <th class="text-center">View</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($application as $key => $item)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $item->application_no }}
                                </td>
                                <td>
                                    {{ !empty($item->district_name) ? repairHindi($item->district_name) : (!empty($item->district) ? districtName($item->district) : '-') }}
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->designation }}
                                </td>
                                <td>
                                    {{ $item->institute_name }}
                                </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>
                                    {{ $item->mobile }}
                                </td>
                                <td>
                                    {{ sport_name($item->sport_id) }}
                                </td>

                                <td class="text-center">
                                    @if ($item->fee_status == 1)
                                        <span class="badge bg-success" style="font-size: 0.85rem;" title="Payment Received">
                                            <i class="fa fa-check-circle me-1"></i>₹{{ number_format((float)$item->protsahan_samiti_fee, 2) }}
                                        </span>
                                        @if(!empty($item->fee_paid_date))
                                            <div class="small text-muted" style="font-size: 0.72rem;"><i class="fa fa-calendar me-1"></i>{{ date('d-m-Y', strtotime($item->fee_paid_date)) }}</div>
                                        @endif
                                    @elseif(!empty($item->protsahan_samiti_fee) && (float)$item->protsahan_samiti_fee > 0)
                                        <span class="badge bg-warning text-dark" style="font-size: 0.85rem;" title="Payment Pending">
                                            <i class="fa fa-clock-o me-1"></i>₹{{ number_format((float)$item->protsahan_samiti_fee, 2) }}
                                        </span>
                                        <div class="small text-warning" style="font-size: 0.72rem;">(Pending)</div>
                                    @elseif($item->status == 1)
                                        <span class="badge bg-secondary" style="font-size: 0.75rem;">Not Set</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($item->status == 1 && $item->final_submit == 1)
                                        <span class="badge bg-success ">Accepted</span>
                                    @elseif ($item->status == 2 && $item->final_submit == 1)
                                        <span class="badge bg-danger ">Rejected</span>
                                    @elseif ($item->final_submit == 1 && $item->query_status == 2)
                                        <span type="button" class="badge bg-info"> Re-Submitted</span>
                                    @elseif($item->final_submit == 1 && $item->query_status == 1)
                                        <span type="button" class="badge bg-warning"> Query Marked</span>
                                    @elseif ($item->status == 1 && $item->final_submit == 1)
                                        <span class="badge bg-success ">Accepted</span>
                                    @elseif ($item->status == 2 && $item->final_submit == 1)
                                        <span class="badge bg-danger ">Rejected</span>
                                    @else
                                        <span class="badge bg-primary ">Pending</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    <div style="display: inline-block;">

                                        <?php if ($item->is_forwarded >= 1 && Auth::guard('admin')->user()->admin_role == 3) { ?>
                                        <strong class="badge bg-success text-white rounded-pill disabled">Forwarded to
                                            SO / RSO</strong>
                                        <?php }elseif ($item->is_forwarded == 2) { ?>
                                        <strong class="badge bg-success text-white rounded-pill disabled">Forwarded to
                                           Prize Money Admin </strong>
                                        <?php } else { ?>
                                        <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                                            data-id="{{ $item->id }}" data-form_type="1"
                                            data-data="{{ $item->is_forwarded }}"
                                            data-application_no="{{ $item->application_no }}" id="h{{ $item->id }}"
                                            onclick="forward({{ $item->id }})" data-bs-toggle="modal"
                                            data-bs-target="#forwarded1">Forward to @if (Auth::guard('admin')->user()->admin_role == 3) SO/RSO @else Prize Money Admin @endif</a>
                                        <?php } ?>
                                    </div>
                                </td> --}}
                                <td class="text-center">

                                    <a class="btn btn-outline-success btn-sm"
                                        href="{{ route('admin_private_coaching_preview', $item->id_application) }}"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <!--Forwarded Button-->
    <div class="modal" id="forwarded1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forward to
                        <span>
                            @if (Auth::guard('admin')->user()->admin_role == 3)
                                SO/RSO
                            @else
                                Prize Money Admin
                            @endif
                        </span>
                    </h5>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <form action="{{ route('admin_private_forward') }}" method="post" id="preregister"
                    class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" class="financial_forward" name="id" value="" />
                        <input type="hidden" class="application_no" name="application_no" value="" />
                        <input type="hidden" name="form_type" value="1">

                        <label class="placeholder">Remark <span class="text-danger">*</span></label>
                        <textarea class="form-control" required name="remark" id="is_mark_query" cols="95" rows="2"></textarea>

                        <label id="verification_document">Upload Relevant application verification document <span
                                class="text-danger remove_danger">*</span></label></br>
                        <span class="text-danger">(If you have more than one supporting document then make please a single
                            PDF for all then upload.)</span>
                        <div class="input-group">
                            <input type="file" required name="verification_document" class="form-control remove_danger"
                                onchange="getfileext(this.value,10)" id="File10" aria-describedby="inputGroupFileAddon05"
                                aria-label="Upload">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <input type="submit" class="btn btn-info" value="Yes">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="exampleModalLabellllll">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Booking</h5>
                </div>
                <form action="" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <input type="hidden" name="id" id="bookid" value="">
                                <select class="form-select form-control" name="status" required>
                                    <option value="">Select</option>
                                    <option value="1">Approved </option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="placeholder">
                                    Message
                                </label>
                                <input type="text" class="form-control" value="" name="status_message"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn btn-outline-danger"><span class="icons icon-cloud-download"></span> Download</button>-->
                            <button type="submit" class="btn btn-info">Submit</button>
                            <button type="button" class="btn btn-danger" onclick="closetrial()">No</button>
                        </div>
                </form>
            </div>
        </div>
    </div>



    <script type="text/javascript" src="{{ asset('js/xlsx.full.min.js') }}"></script>
    <script>
        function approved(id) {
            alert(id);
            $("#bookid").val(id);

            $("#exampleModalLabellllll").show();



        }

        function closetrial() {
            $("#exampleModalLabellllll").hide();
        }

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('dataTable');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('Application Details.' + (type || 'xlsx')));
        }
        $("#preregister").submit(function(e) {

            e.preventDefault();
            if ($("#preregister")[0].checkValidity() === false) {
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
            $("#preregister").addClass("was-validated");
        });
    </script>
@endpush
