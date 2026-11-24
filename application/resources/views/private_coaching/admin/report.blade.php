@extends('layouts/admin_layout')
@section('content')

<style>
    .nowraptd {
        white-space: nowrap;
    }
    .dn {
        display: none;
    }
</style>

<div class="container-fluid pagecontentbody">
    <div class="tab-content">
        <div class="pagebody removebg-color">

            {{-- Page Header --}}
            <div class="col-12">
                <div class="pageheader" id="menu-margin">
                    <h4 class="mb-0">
                        Institutions Registrations Fee & Payment Report
                        <a href="{{ $backUrl }}" class="btn btn-outline-secondary float-end ms-2">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                        <a title="Print" class="btn btn-outline-success float-end ms-2" data-print="modal" onclick="PrintDoc()">
                            <i class="icons icon-printer"></i> प्रिंट
                        </a>
                        <button onclick="ExportToExcel('Institutions Registration Fee Report')" class="btn btn-outline-primary float-end">
                            Excel
                        </button>
                    </h4>
                </div>
            </div>

            {{-- Filter Form --}}
            <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-2 align-items-end" method="get" action="{{ route('admin_private_coaching_report') }}">
                        @if(Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 3)
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="division_id">Division</label>
                                    <select name="division_id" id="division_id" class="form-select">
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $div)
                                            <option value="{{ $div->id }}" {{ (string)$division_id === (string)$div->id ? 'selected' : '' }}>
                                                {{ $div->division_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if(Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 2 || Auth::guard('admin')->user()->admin_role == 3)
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="district_id">District</label>
                                    <select name="district_id" id="district_id" class="form-select">
                                        <option value="">Select District</option>
                                        @foreach ($districts as $dst)
                                            <option value="{{ $dst->id }}" {{ (string)$district_id === (string)$dst->id ? 'selected' : '' }}>
                                                {{ $dst->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">All Categories</option>
                                    <option value="1" {{ (string)$category_id === '1' ? 'selected' : '' }}>Sports Associations</option>
                                    <option value="2" {{ (string)$category_id === '2' ? 'selected' : '' }}>Private Gyms</option>
                                    <option value="3" {{ (string)$category_id === '3' ? 'selected' : '' }}>Private Academies</option>
                                    <option value="4" {{ (string)$category_id === '4' ? 'selected' : '' }}>Swimming Pools</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $from_date ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $to_date ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-info me-2">Submit</button>
                                <a href="{{ route('admin_private_coaching_report', $category_id ? ['category_id' => $category_id] : []) }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Report Tables Card --}}
            <div class="card" id="prodiv">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <div>
                            <span class="fs-6 me-3"><strong>Total Paid Institutions:</strong> <span class="badge bg-primary fs-6">{{ $totalRecordsCount }}</span></span>
                            <span class="fs-6"><strong>Total Payment Received:</strong> <span class="text-success fw-bold fs-5">₹{{ number_format($totalPaidFee, 2) }}</span></span>
                        </div>
                    </div>

                    {{-- 1. Monthly District Summary Report --}}
                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 text-dark">
                            <i class="fa fa-bar-chart text-info"></i> Monthly District Summary Report
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0" id="summaryTable">
                                <thead>
                                    <tr style="background-color: #f7f9fa;">
                                        <th style="width: 50px;" class="text-center">S.No.</th>
                                        <th>Month & Year</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th class="text-end">Associations (₹)</th>
                                        <th class="text-end">Gyms (₹)</th>
                                        <th class="text-end">Academies (₹)</th>
                                        <th class="text-end">Swimming Pools (₹)</th>
                                        <th class="text-end">Total Received (₹)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($summary as $sKey => $sRow)
                                        <tr>
                                            <td class="text-center">{{ $sKey + 1 }}</td>
                                            <td><strong>{{ $sRow->month_year }}</strong></td>
                                            <td>{{ $sRow->division_name }}</td>
                                            <td>{{ $sRow->district_name }}</td>
                                            <td class="text-end">{{ $sRow->associations_fee > 0 ? '₹' . number_format($sRow->associations_fee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $sRow->gyms_fee > 0 ? '₹' . number_format($sRow->gyms_fee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $sRow->academies_fee > 0 ? '₹' . number_format($sRow->academies_fee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $sRow->swimming_fee > 0 ? '₹' . number_format($sRow->swimming_fee, 2) : '-' }}</td>
                                            <td class="text-end text-success fw-bold">₹{{ number_format($sRow->total_fee, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-3 text-muted">
                                                No payment summary records found for the selected criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($summary->isNotEmpty())
                                    <tfoot>
                                        <tr style="background-color: #eef2f5; font-weight: bold;">
                                            <td colspan="4" class="text-center text-uppercase">Grand Total</td>
                                            <td class="text-end">{{ $totalAssocFee > 0 ? '₹' . number_format($totalAssocFee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $totalGymFee > 0 ? '₹' . number_format($totalGymFee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $totalAcadFee > 0 ? '₹' . number_format($totalAcadFee, 2) : '-' }}</td>
                                            <td class="text-end">{{ $totalSwimFee > 0 ? '₹' . number_format($totalSwimFee, 2) : '-' }}</td>
                                            <td class="text-end text-success fs-6">₹{{ number_format($totalPaidFee, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- 2. Transaction Details / Breakdown --}}
                    <div>
                        <h5 class="fw-bold mb-3 text-dark">
                            <i class="fa fa-list-ul text-info"></i> Transaction Details / Breakdown
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable table-hover mb-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">S.No.</th>
                                        <th class="text-center">Payment Date</th>
                                        <th>Month & Year</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Application No.</th>
                                        <th>Institution Name</th>
                                        <th>Applicant Name</th>
                                        <th>Category</th>
                                        <th class="text-end">Payment Received (₹)</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 60px;">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($details as $key => $row)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                {{ !empty($row->fee_paid_date) ? date('d-m-Y', strtotime($row->fee_paid_date)) : '-' }}
                                            </td>
                                            <td>{{ $row->month_year }}</td>
                                            <td>{{ $row->division_name ?? '-' }}</td>
                                            <td><strong>{{ $row->district_name ?? '-' }}</strong></td>
                                            <td>{{ $row->application_no }}</td>
                                            <td>{{ $row->institute_name ?? 'N/A' }}</td>
                                            <td>{{ $row->applicant_name }}</td>
                                            <td>
                                                @if($row->category_id == 1)
                                                    Associations
                                                @elseif($row->category_id == 2)
                                                    Gym
                                                @elseif($row->category_id == 3)
                                                    Academy
                                                @elseif($row->category_id == 4)
                                                    Swimming Pool
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">₹{{ number_format((float)$row->protsahan_samiti_fee, 2) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ $row->preview_link }}" target="_blank" class="btn btn-outline-success btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4 text-muted">
                                                No payment records found for the selected filter criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($details->isNotEmpty())
                                    <tfoot>
                                        <tr style="background-color: #f2f2f2; font-weight: bold;">
                                            <td colspan="9" class="text-center text-uppercase">Grand Total Payment Received</td>
                                            <td class="text-end text-success fs-6">₹{{ number_format($totalPaidFee, 2) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>

                </div>

                {{-- Hidden Print Section --}}
                <div id="print_section" class="dn">
                    <table style="width: 100%;" class="dn">
                        <tr>
                            <td align="center" style="position: relative; border: 0; padding-bottom: 5px;">
                                <div style="border-bottom: 0px solid #000; padding-bottom: 2vw;">
                                    <div style="font-size: 18px; font-weight: bold;">
                                        Khel Sathi Portal<br>
                                        Department of Sports
                                    </div>
                                    <div style="font-size: 14px; font-weight: bold;">
                                        Government of Uttar Pradesh
                                    </div>
                                    <div style="font-size: 13px; font-weight: bold; margin-top: 5px;">
                                        Institutions Registrations Fee & Payment Report
                                    </div>
                                    <div style="font-size: 11px; color: #555;">
                                        Generated on: {{ date('d-m-Y H:i:s') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div style="font-weight: bold; font-size: 13px; margin: 10px 0 5px 0;">1. Monthly District Summary Report</div>
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;" border="1" cellpadding="5">
                        <thead>
                            <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center;">
                                <th>S.No.</th>
                                <th>Month & Year</th>
                                <th>Division</th>
                                <th>District</th>
                                <th>Associations (₹)</th>
                                <th>Gyms (₹)</th>
                                <th>Academies (₹)</th>
                                <th>Swimming Pools (₹)</th>
                                <th>Total Received (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $sKey => $sRow)
                                <tr>
                                    <td align="center">{{ $sKey + 1 }}</td>
                                    <td align="center">{{ $sRow->month_year }}</td>
                                    <td>{{ $sRow->division_name }}</td>
                                    <td>{{ $sRow->district_name }}</td>
                                    <td align="right">{{ $sRow->associations_fee > 0 ? number_format($sRow->associations_fee, 2) : '-' }}</td>
                                    <td align="right">{{ $sRow->gyms_fee > 0 ? number_format($sRow->gyms_fee, 2) : '-' }}</td>
                                    <td align="right">{{ $sRow->academies_fee > 0 ? number_format($sRow->academies_fee, 2) : '-' }}</td>
                                    <td align="right">{{ $sRow->swimming_fee > 0 ? number_format($sRow->swimming_fee, 2) : '-' }}</td>
                                    <td align="right">{{ number_format($sRow->total_fee, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #e6e6e6; font-weight: bold;">
                                <td colspan="4" align="center">GRAND TOTAL</td>
                                <td align="right">{{ number_format($totalAssocFee, 2) }}</td>
                                <td align="right">{{ number_format($totalGymFee, 2) }}</td>
                                <td align="right">{{ number_format($totalAcadFee, 2) }}</td>
                                <td align="right">{{ number_format($totalSwimFee, 2) }}</td>
                                <td align="right">{{ number_format($totalPaidFee, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div style="font-weight: bold; font-size: 13px; margin: 10px 0 5px 0;">2. Transaction Details / Breakdown</div>
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px;" border="1" cellpadding="5">
                        <thead>
                            <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center;">
                                <th>S.No.</th>
                                <th>Payment Date</th>
                                <th>Month & Year</th>
                                <th>Division</th>
                                <th>District</th>
                                <th>Application No.</th>
                                <th>Institution Name</th>
                                <th>Applicant Name</th>
                                <th>Category</th>
                                <th>Payment Received (₹)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $k => $row)
                                <tr>
                                    <td align="center">{{ $k + 1 }}</td>
                                    <td align="center">{{ !empty($row->fee_paid_date) ? date('d-m-Y', strtotime($row->fee_paid_date)) : '-' }}</td>
                                    <td align="center">{{ $row->month_year }}</td>
                                    <td>{{ $row->division_name ?? '-' }}</td>
                                    <td>{{ $row->district_name ?? '-' }}</td>
                                    <td>{{ $row->application_no }}</td>
                                    <td>{{ $row->institute_name ?? 'N/A' }}</td>
                                    <td>{{ $row->applicant_name }}</td>
                                    <td>{{ $row->category_name }}</td>
                                    <td align="right">₹{{ number_format((float)$row->protsahan_samiti_fee, 2) }}</td>
                                    <td align="center">Paid</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #e6e6e6; font-weight: bold;">
                                <td colspan="9" align="center">GRAND TOTAL PAYMENT RECEIVED</td>
                                <td align="right">₹{{ number_format($totalPaidFee, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script>
    function PrintDoc() {
        var toPrint = document.getElementById('print_section');
        var popupWin = window.open('', '_blank', 'left=100,top=100,width=1100,height=600,toolbar=0,scrollbars=1,status=0,resizable=1');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Preview:Institutions Registration Fee Report::</title><head><style>body{font-family:Arial} .noprint{display: none;} table{width:100%; border-collapse:collapse;} .table tr th, .table tr td{border:1px solid #000; padding:3px 5px; font-size: 12px; text-align: left;} th.table-warning{background-color: #dbdbdb;} .dn{display: block !important;}</style></head><body onload="window.print()">');
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</body></html>');
        popupWin.document.close();
    }

    function ExportToExcel(fn) {
        var wb = XLSX.utils.book_new();
        var sElt = document.getElementById('summaryTable');
        if (sElt) {
            var ws1 = XLSX.utils.table_to_sheet(sElt);
            XLSX.utils.book_append_sheet(wb, ws1, "Monthly Summary");
        }
        var dElt = document.getElementById('dataTable');
        if (dElt) {
            var ws2 = XLSX.utils.table_to_sheet(dElt);
            XLSX.utils.book_append_sheet(wb, ws2, "Transaction Details");
        }
        XLSX.writeFile(wb, fn ? (fn + '.xlsx') : 'Institutions_Registration_Fee_Report.xlsx');
    }

    $(function () {
        $("#division_id").on("change", function () {
            var division = $(this).val();
            var district = $('#district_id').val();
            if (division) {
                var baseUrl = typeof ajaxUrl !== 'undefined' ? ajaxUrl : '{{ url('/') }}';
                $.ajax({
                    type: "GET",
                    url: baseUrl + "/getCitybyDiv/" + division + '/' + (district || ''),
                    success: function (html) {
                        $("#district_id").html(html);
                    }
                });
            } else {
                $("#district_id").html('<option value="">Select District</option>');
            }
        });
    });
</script>

@endsection
