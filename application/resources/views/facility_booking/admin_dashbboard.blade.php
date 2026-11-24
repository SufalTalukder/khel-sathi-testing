@extends('layouts/admin_layout')
@section('content')
    <div class="pageheader" id="menu-margin">
        <h4 class="mb-0">
            @if (last(request()->segments()) == 1)
                Swimming Pool (Mini)
            @elseif (last(request()->segments()) == 2)
                Guest Room
            @elseif (last(request()->segments()) == 3)
                Swimming Pool (Adult)
            @elseif (last(request()->segments()) == 4)
                Gymnasium
            @elseif (last(request()->segments()) == 5)
                Stadium
            @endif Booking List
            <a title="Application Details ExportToExcel" class="btn btn-sm btn-success float-end"
                onclick="ExportToExcel('xlsx')">
                <i class="fa fa-file-excel"></i> Export to Excel
            </a>

            <a href="{{ route('admin_facility_booking_application_pdf', last(request()->segments())) }}"
                class="btn btn-sm btn-primary float-end" target="_blank" rel="noopener noreferrer"> Export PDF</a>
        </h4>
    </div>




    {{-- Booking Filters --}}
    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <form class="row g-2 align-items-end" id="bookingFilterForm" method="post" action="{{ route('admin_facility_booking_dashboard', $type) }}">
                    @csrf
                    @if (Auth::guard('admin')->user()->admin_role == 1)
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group mb-0">
                                <label for="division_id">Division</label>
                                <select name="division_id" id="division_id" class="form-select">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $key => $item)
                                        <option value="{{ $item->id }}"
                                            {{ (string)request()->input('division_id') === (string)$item->id ? 'selected' : '' }}>
                                            {{ $item->division_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2)
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group mb-0">
                                <label for="district_id">District</label>
                                <select name="district_id" id="district_id" class="form-select">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $key => $item)
                                        <option value="{{ $item->id }}"
                                            {{ (string)request()->input('district_id') === (string)$item->id ? 'selected' : '' }}>
                                            {{ repairHindi($item->city) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group mb-0">
                            <label for="stadium">Stadium</label>
                            <select name="stadium" id="stadium" class="form-select">
                                <option value="">Select Stadium</option>
                                @foreach ($stadiums as $key => $iten)
                                    <option value="{{ $iten->id }}"
                                        {{ (string)request()->input('stadium') === (string)$iten->id ? 'selected' : '' }}>
                                        {{ $iten->studium_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <div class="form-group mb-0">
                            <label for="status">Application Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ (string)request()->input('status') === '1' ? 'selected' : '' }}>Accepted</option>
                                <option value="2" {{ (string)request()->input('status') === '2' ? 'selected' : '' }}>Rejected</option>
                                <option value="0" {{ (string)request()->input('status') === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="query_marked" {{ request()->input('status') === 'query_marked' ? 'selected' : '' }}>Query Marked</option>
                                <option value="re_submitted" {{ request()->input('status') === 're_submitted' ? 'selected' : '' }}>Re-Submitted</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <div class="form-group mb-0">
                            <label for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ (string)request()->input('payment_status') === '1' ? 'selected' : '' }}>Success / Paid</option>
                                <option value="0" {{ (string)request()->input('payment_status') === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="fee_exemption" {{ request()->input('payment_status') === 'fee_exemption' ? 'selected' : '' }}>Fee Exemption</option>
                                <option value="na" {{ request()->input('payment_status') === 'na' ? 'selected' : '' }}>NA</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 d-flex gap-2">
                        <button type="button" id="applyBookingFilters" class="btn btn-primary flex-fill">Apply Filters</button>
                        <button type="button" id="resetBookingFilters" class="btn btn-secondary flex-fill">Reset</button>
                    </div>

                </form>

            </div>


        </div>
    </div>

    <script>
        var defaultDistrictHtml = $('#district_id').html();
        var defaultStadiumHtml = $('#stadium').html();

        $("#division_id").on("change", function() {
            var division = $(this).val();
            var district = $('#district_id').val();
            var stadium = $('#stadium').val();
            if (division) {
                $.ajax({
                    type: "GET",
                    url: ajaxUrl + "/getCitybyDiv/" + division + '/' + (district || ''),
                    success: function(html) {
                        html = html.replace('Select City', 'Select District');
                        $("#district_id").html(html);
                    },
                });
                $.ajax({
                    type: "GET",
                    url: ajaxUrl + "/getStadiumbyDiv/" + division + '/' + (district || '') + '/' + (stadium || ''),
                    success: function(html) {
                        $("#stadium").html(html);
                    },
                });
            } else {
                $("#district_id").html('<option value="">Select District</option>').val('');
                $("#stadium").html(defaultStadiumHtml).val('');
            }
        });

        $("#district_id").on("change", function() {
            var division = $('#division_id').val();
            var district = $('#district_id').val();
            var stadium = $('#stadium').val();
            if (division || district) {
                $.ajax({
                    type: "GET",
                    url: ajaxUrl + "/getStadiumbyDiv/" + (division || '0') + '/' + (district || '') + '/' + (stadium || ''),
                    success: function(html) {
                        $("#stadium").html(html);
                    },
                });
            } else {
                $("#stadium").html(defaultStadiumHtml).val('');
            }
        });

        $('#applyBookingFilters').on('click', function() {
            $('#dataTableaa121').DataTable().ajax.reload();
        });

        $('#resetBookingFilters').on('click', function() {
            $('#division_id').val('');
            $('#district_id').html('<option value="">Select District</option>').val('');
            $('#stadium').html(defaultStadiumHtml).val('');
            $('#status').val('');
            $('#payment_status').val('');
            $('#dataTableaa121').DataTable().ajax.reload();
        });
    </script>


    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-lg-4">
            <div class="table-responsive">
                <table id="dataTableaa121" class="table table--striped table-hover align-middle w-100 mb-0">
                    <thead class="table-primary">
                        <tr>

                            <th>S.No.</th>
                            <th>Booking No.</th>
                            <th>Booking Type</th>
                            <th>District</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th class="text-center">Mobile No.</th>
                            <th class="text-center">Application Date</th>
                            <th class="text-center">Status of Application</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($application))
                            @foreach ($application as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $item->application_no }}
                                    </td>
                                    <td>
                                        @if ($item->service == 1)
                                            Swimming Pool (Mini)
                                        @elseif ($item->service == 2)
                                            Guest Room
                                        @elseif ($item->service == 3)
                                            Swimming Pool (Adult)
                                        @elseif ($item->service == 4)
                                            Gymnasium
                                        @elseif ($item->service == 5)
                                            Stadium
                                        @endif
                                    </td>
                                    <td>
                                        {{ !empty($item->district_name) ? repairHindi($item->district_name) : (!empty($item->location) ? districtName($item->location) : '-') }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td class="text-center">{{ $item->mobile }}</td>


                                    <td class="text-center">

                                        @if ($item->status == 1 && $item->final_submit == 1)
                                            <br>{{ dmy($item->accept_reject_date) }}
                                        @elseif ($item->status == 2 && $item->final_submit == 1)
                                            <br>{{ dmy($item->accept_reject_date) }}
                                        @elseif($item->final_submit == 1 && $item->query_status == 2)
                                            {{ dmy($item->final_submit_date) }}
                                        @elseif($item->final_submit == 1 && $item->query_status == 1)
                                            {{ dmy($item->marked_on) }}
                                        @elseif ($item->status == 1 && $item->final_submit == 1)
                                            <br>{{ dmy($item->final_submit_date) }}
                                        @else
                                            <br>{{ dmy($item->final_submit_date) }}
                                        @endif
                                    </td>


                                    <td class="text-center">

                                        @if ($item->status == 1 && $item->final_submit == 1)
                                            <span class="badge bg-success ">Accepted</span>
                                        @elseif ($item->status == 2 && $item->final_submit == 1)
                                            <span class="badge bg-danger ">Rejected
                                            </span>
                                        @elseif($item->final_submit == 1 && $item->query_status == 2)
                                            <button type="button" class="btn btn-outline-primary btn-sm">
                                                Re-Submitted</button>
                                        @elseif($item->final_submit == 1 && $item->query_status == 1)
                                            <button type="button" class="btn btn-outline-warning btn-sm"> Query
                                                Marked</button>
                                        @elseif ($item->status == 1 && $item->final_submit == 1)
                                            <span class="badge bg-primary ">Pending</span>
                                        @else
                                            <span class="badge bg-primary ">Pending</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($item->status == 1 && $item->payment_status == 1)
                                            <span class="badge bg-success ">Success</span> <br>
                                            {{ rajkosh_payment_booking($item->application_no)->Depchallan }}
                                            <br>
                                            {{ dmy($item->payment_date) }} <br>
                                            <strong> {{ $item->amount_to_be_paid }} INR. </strong>
                                        @elseif ($item->status == 1 && $item->payment_status != 1)
                                            @if ($item->fee_exemption_status == 1)
                                                <span class="badge bg-warning">Fee Exemption</span>
                                            @else
                                                <span class="badge bg-primary ">Pending</span>
                                            @endif
                                        @else
                                            NA
                                        @endif
                                    </td>


                                    <td class="text-center">

                                        <a class="btn btn-outline-success btn-sm"
                                            href="{{ route('admin_facility_booking_preview', $item->id_application) }}"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <button type="button" class="pptwbtn" style="display:none">&nbsp;</button>
    <button type="button" class="pptwbtnadd" style="display:none">&nbsp;</button>
@endsection

@push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
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
            var elt = document.getElementById('dataTableaa121');
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
    </script>

    <script>
        var id = "<?= $type ?>";

        $(document).ready(function() {
            $('#dataTableaa121').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                scrollX: true,
                fixedHeader: true,
                ajax: {
                    url: "<?= url('admin/facility_booking/dashboard') ?>/" + id,
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.division_id = $('#division_id').val() || '';
                        d.district_id = $('#district_id').val() || '';
                        d.stadium = $('#stadium').val() || '';
                        d.status = $('#status').val() || '';
                        d.payment_status = $('#payment_status').val() || '';
                    }
                },
                order: [
                    [0, 'desc']
                ],
                pageLength: 25,
                iDisplayLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, 200, -1],
                    [10, 25, 50, 100, 200, "All"]
                ],
                language: {
                    lengthMenu: '_MENU_ Entries Per Page',
                    paginate: {
                        previous: 'Previous',
                        next: 'Next'
                    }
                },
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 9, 10]
                    },
                    {
                        className: 'text-center',
                        targets: '_all'
                    }
                ],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {

                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'application_no',
                        name: 'application_no'
                    },
                    {
                        data: 'service',
                        name: 'service',

                        render: function(data, type, row) {

                            switch (parseInt(row.service)) {

                                case 1:
                                    return 'Swimming Pool (Mini)';

                                case 2:
                                    return 'Guest Room';

                                case 3:
                                    return 'Swimming Pool (Adult)';

                                case 4:
                                    return 'Gymnasium';

                                case 5:
                                    return 'Stadium';

                                default:
                                    return '';
                            }
                        }
                    },
                    {
                        data: 'district_name',
                        name: 'district_name',
                        render: function(data, type, row) {
                            return row.district_name ? row.district_name : '-';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        render: function(data, type, row) {

                            if (row.status == 1 && row.final_submit == 1) {

                                return `
                            <span>${moment(row.accept_reject_date).format("D-MM-YYYY")}</span>
                        `;

                            } else if (row.status == 2 && row.final_submit == 1) {

                                return `
                            <span>${moment(row.accept_reject_date).format("D-MM-YYYY")}</span>
                        `;

                            } else if (row.status == 1 && row.query_status == 2) {

                                return `
                            <span>${moment(row.final_submit_date).format("D-MM-YYYY")}</span>
                        `;

                            } else if (row.status == 1 && row.query_status == 1) {

                                return `
                            <span>${moment(row.marked_on).format("D-MM-YYYY")}</span>
                        `;

                            } else {

                                return `
                            <span>${moment(row.final_submit_date).format("D-MM-YYYY")}</span>
                        `;
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',

                        render: function(data, type, row) {

                            if (row.query_status == 1) {
                                return `<span class="badge bg-info">Query Marked</span><br>`;
                            } else if (row.query_status == 2 && (row.status != 1 && row.status != 2)) {
                                return `<span class="badge bg-warning">Re-Submitted</span><br>`;
                            } else if (row.status == 1 && row.final_submit == 1) {
                                return `<span class="badge bg-success">Accepted</span><br>`;
                            } else if (row.status == 2 && row.final_submit == 1) {
                                return `<span class="badge bg-danger">Rejected</span><br>`;
                            } else {
                                return `<span class="badge bg-primary">Pending</span><br>`;
                            }
                        }
                    },
                    {
                        data: null,
                        name: 'payment_status',

                        render: function(data, type, row) {

                            if (row.status == 1 && row.payment_status == 1) {

                                return `
                            <span class="badge bg-success">Success</span><br>
                            ${moment(row.payment_date).format('D-MM-YYYY')}<br>
                            <strong>${row.amount_to_be_paid} INR</strong>
                        `;

                            } else if (row.status == 1 && row.payment_status != 1) {

                                if (row.fee_exemption_status == 1) {

                                    return `
                                <span class="badge bg-warning">
                                    Fee Exemption
                                </span>
                            `;

                                } else {

                                    return `
                                <span class="badge bg-primary">Pending</span>
                            `;
                                }

                            } else {

                                return 'NA';
                            }
                        }
                    },
                    {
                        data: 'id_application',

                        render: function(data, type, row) {

                            return `
                        <a href="${ajaxUrl}/admin/facility_booking/preview/${row.id_application}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           View
                        </a>
                    `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
