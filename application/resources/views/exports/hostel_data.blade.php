<!DOCTYPE html>
<html>

<head>
    <title>Khel Sathi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        @page {
            size: A4 landscape;
            margin: 15pt 20pt 25pt 15pt;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            font-size: 8.5pt;
        }

        h1,
        h2,
        h5,
        h6 {
            font-weight: bold;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-top: 1px solid #000;
            border-left: 1px solid #000;
            table-layout: fixed;
            margin-bottom: 0px;
        }

        .table tr th,
        .table tr td {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 8pt;
            padding: 3px 4px;
            vertical-align: middle;
        }

        .table tr th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .table td {
            word-break: break-all;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div id="prodiv" style="width: 100%; margin: 0 auto;">
        <div style="padding: 0 15px 3px; margin-bottom: 6px; border-bottom: 2px solid #000; text-align: center;">
            @php
                $logoPath = public_path('assets_admin/images/logo.png');
                $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
            @endphp
            @if(!empty($logoBase64))
                <img src="{{ $logoBase64 }}" style="width: 50px; height: auto;">
            @endif
            <h1 style="font-size: 16pt; margin: 3px 0 0; padding: 0; color: #000;">Sports Directorate, Uttar Pradesh</h1>
            <h2 style="font-size: 9pt; margin: 2px 0 3px; padding: 0; color: #000;">Khel Bhawan, Hazratganj, Lucknow, Uttar Pradesh 226001</h2>
            <h5 style="font-size: 12pt; margin: 0; padding: 0; color: #000;">Khel Sathi Portal</h5>
        </div>
        <h6 style="text-align: center; margin:0px 0px 0px 0px; font-size:12pt; padding: 0px; color:#000;">
            {{ $data['module_name'] ?? '' }}
        </h6>
        <h6 style="text-align: center; margin:2px 0px 10px 0px; font-size:11pt; padding: 0px; color:#000; text-decoration:underline;">
            {{ $pdfTitle ?? '' }}
        </h6>
        <div style="width: 100%; font-size: 8.5pt; margin-bottom: 6px; overflow: hidden;">
            <span style="float: left;"><b>Report Period : 01-04-2023 To {{ dmy(now()) }}</b></span>
            <span style="float: right; text-align: right;">
                <b>Report Code :</b> {{ $data['report_code'] ?? 'RS001' }} &nbsp;&nbsp;
                <b>Report Generated On :</b> {{ now()->format('d-m-Y h:i A') }}
            </span>
            <div style="clear: both;"></div>
        </div>

        @php
            $perPage = 15;
            $chunks = (isset($hostelList) && count($hostelList) > 0)
                ? ($hostelList instanceof \Illuminate\Support\Collection ? $hostelList->chunk($perPage) : collect($hostelList)->chunk($perPage))
                : [];
        @endphp

        @if (count($chunks) > 0)
            @foreach ($chunks as $chunkIndex => $chunk)
                @if ($chunkIndex > 0)
                    <div class="page-break"></div>
                @endif
                <table class="table" border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th style="width: 4%;">S.No.</th>
                            <th style="width: 11%;">Application No.</th>
                            <th style="width: 13%;">Applicant’s Name</th>
                            <th style="width: 14%;">Email ID</th>
                            <th style="width: 9%;">Mobile No.</th>
                            <th style="width: 6%;">Gender</th>
                            <th style="width: 11%;">District</th>
                            <th style="width: 10%;">Sports</th>
                            @if (isset($checkk) && $checkk === 1)
                                <th style="width: 7%;">Sub Sport</th>
                                <th style="width: 8%;">Application Status</th>
                                <th style="width: 7%;">Payment Status</th>
                            @else
                                <th style="width: 7%;">Total Marks</th>
                                <th style="width: 7%;" class="text-center">Approved</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chunk as $idx => $item)
                            @php
                                $globalIndex = $chunkIndex * $perPage + $idx + 1;
                            @endphp
                            <tr>
                                <td style="text-align: center;">{{ $globalIndex }}</td>
                                <td>{{ $item->application_no }}</td>
                                <td>{{ ucwords(strtolower($item->name)) }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td style="text-align: center;">
                                    @if ($item->gender == 1)
                                        Male
                                    @else
                                        Female
                                    @endif
                                </td>
                                <td>{{ $item->district_name ?? districtName($item->district_id) }}</td>
                                <td>{{ $item->sport_name ?? sport_name_hostel($item->sports) }}</td>
                                @if (isset($checkk) && $checkk === 1)
                                    <td>{{ $item->subsport_name ?? ($item->sub_sport_type ? sub_sport_name($item->sub_sport_type) : 'NA') }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->status == 3)
                                            Pending
                                        @elseif ($item->status == 1)
                                            Provisionally Accepted
                                        @else
                                            Rejected
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($item->payment_status == 1)
                                            Pending
                                        @elseif ($item->payment_status == 2)
                                            Success
                                            @if(!empty($item->payment_allotment_fee_date) || !empty($item->payment_date))
                                                <br>{{ dmy($item->payment_allotment_fee_date != '' ? $item->payment_allotment_fee_date : $item->payment_date) }}
                                            @endif
                                            <br>10 INR
                                        @elseif ($item->payment_status == 3)
                                            Fail
                                        @else
                                            -
                                        @endif
                                    </td>
                                @else
                                    <td style="text-align: center;">{{ isset($item->total_mark) ? number_format($item->total_mark, 2) : '-' }}</td>
                                    <td style="text-align: center;">
                                        @if ((isset($checkk) && $checkk === 2 && isset($item->final_list_approved) && $item->final_list_approved == 1) ||
                                             (isset($checkk) && $checkk === 3 && isset($item->division_level_approved) && $item->division_level_approved == 1) ||
                                             (isset($checkk) && $checkk === 4 && isset($item->medical_test) && $item->medical_test == 2) ||
                                             (isset($checkk) && $checkk === 5 && isset($item->competition_level_approved) && $item->competition_level_approved == 1) ||
                                             (isset($checkk) && $checkk === 10 && isset($item->district_level_approved) && $item->district_level_approved == 1) ||
                                             (isset($item->final_list_approved) && $item->final_list_approved == 1))
                                            Approved
                                        @else
                                            Pending
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @else
            <table class="table" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="text-align: center; padding: 15px;">
                            <h4>No records Found!</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>
