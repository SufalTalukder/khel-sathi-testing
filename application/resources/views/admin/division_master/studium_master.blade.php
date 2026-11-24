@extends('layouts/admin_layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="pageheader" id="menu-margin">
            <h4 class="mb-0">Create Stadium Master</h4>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('saveStudiumMaster') }}" class="needs-validation" novalidate method="post"
                    autocomplete="off">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="form-group mb-md-0">
                                <label for="studium_name">Stadium Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control alphanumeric" id="studium_name"
                                    name="studium_name" value="{{ old('studium_name') }}"
                                    placeholder="Enter Stadium Name" required>
                                <div class="invalid-feedback">
                                    Please provide Stadium Name.
                                </div>
                                @if ($errors->has('studium_name'))
                                <span class="error_mess">{{ $errors->first('studium_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-md-0">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <select class="form-select" id="district" name="district" required>
                                    <option selected="" disabled="" value="">Select District</option>
                                    @foreach ($districts as $key => $district)
                                    <option value="{{ $district->id }}" {{ old('district') == $district->id ? 'selected' : '' }}>{{ $district->city }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please provide District.
                                </div>
                                @if ($errors->has('district'))
                                <span class="error_mess">{{ $errors->first('district') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-md-0">
                                <label for="longitude">Longitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control alphanumeric" id="longitude" name="longitude"
                                    value="{{ old('longitude') }}" placeholder="Enter Stadium Longitude" required>
                                <div class="invalid-feedback">
                                    Please provide Longitude.
                                </div>
                                @if ($errors->has('longitude'))
                                <span class="error_mess">{{ $errors->first('longitude') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-md-0">
                                <label for="latitude">Latitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control alphanumeric" id="latitude" name="latitude"
                                    value="{{ old('latitude') }}" placeholder="Enter Stadium Latitude" required>
                                <div class="invalid-feedback">
                                    Please provide Latitude.
                                </div>
                                @if ($errors->has('latitude'))
                                <span class="error_mess">{{ $errors->first('latitude') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-md-0 d-grid">
                                <button class="btn btn-primary" type="submit" style="white-space: nowrap;">Submit/दर्ज करे</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="pageheader" id="menu-margin">
            <h4 class="mb-0">Stadium Master List
                <a title="Stadium Master List" class="btn btn-sm btn-success float-end" onclick="ExportToExcel('xlsx')">
                    <i class="fa fa-file-excel"></i> Export to Excel
                </a>
            </h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordred table-hover bg-white datatable">
                        <thead>
                            <tr>
                                <th width="6%">S.No.</th>
                                <th width="22%">Stadium Name</th>
                                <th width="16%">District Name</th>
                                <th width="12%">Longitude</th>
                                <th width="12%">Latitude</th>
                                <th width="18%" class="text-center">Infrastructure & Games</th>
                                <th width="7%" class="text-center">Edit</th>
                                <th width="7%" class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studiums as $key => $studium)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $studium->studium_name }}</td>
                                <td>{{ $studium->city }}</td>
                                <td>{{ $studium->longitude }}</td>
                                <td>{{ $studium->latitude }}</td>
                                <td class="text-center align-middle">
                                    @php
                                    $infraList = isset($infrastructures[$studium->id]) ? $infrastructures[$studium->id] : collect();
                                    $infraCount = $infraList->count();
                                    @endphp
                                    @if($infraCount > 0)
                                    @php
                                    $facilitiesPayload = $infraList->map(function($item) {
                                    return [
                                    'id' => $item->id,
                                    'infra' => $item->infrastructure_name,
                                    'games' => $item->available_games ?? '',
                                    'updated' => $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y, h:i A') : 'N/A',
                                    'updater_name' => ucwords($item->updater_name ?? 'Officer'),
                                    'updater_role' => $item->updater_role_title ?? 'Sports Officer',
                                    ];
                                    })->values()->toArray();
                                    @endphp
                                    <button type="button" class="btn btn-sm btn-info text-white font-weight-bold px-3 py-1 shadow-sm view-infra-btn"
                                        data-toggle="modal" data-target="#infraViewModal"
                                        data-stadium="{{ $studium->studium_name }}"
                                        data-district="{{ $studium->city }}"
                                        data-facilities="{{ json_encode($facilitiesPayload) }}"
                                        title="View Infrastructure & Games"
                                        style="border-radius: 6px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa fa-eye" style="font-size: 13px;"></i> View Details
                                    </button>
                                    @else
                                    <span class="badge badge-light border text-muted px-2 py-1" style="font-size: 11.5px; background: #f8fafc; font-weight: 500; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa fa-info-circle"></i> Not Added
                                    </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-dark pointer bt role_manager_id"
                                        href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"
                                        data-id="{{ $studium->id }}" data-name="{{ $studium->studium_name }}"
                                        data-longitude="{{ $studium->longitude }}"
                                        data-latitude="{{ $studium->latitude }}"
                                        data-district="{{ $studium->city_id }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger pointer bt px-2"
                                        href="{{ url('/admin/delete-studium-master/') }}/{{ $studium->id }}"
                                        onclick="return confirm('Are you sure you want to delete ?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Stadium Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <form action="{{ route('updateStudiumMaster') }}" class="needs-validation" method="post"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Stadium Name</label>
                                <input type="hidden" class="form-control" id="studium_id" name="id">
                                <input type="text" class="form-control alphanumeric" id="studium_name"
                                    name="studium_name" required>
                                <div class="invalid-feedback">
                                    Please provide Division.
                                </div>
                                @if ($errors->has('studium_name'))
                                <span class="error_mess">{{ $errors->first('studium_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">District *</label>
                                <select class="form-select" id="district" name="district"
                                    value="{{ old('district') }}" required>
                                    <option selected="" disabled="" value="">Select District</option>
                                    @foreach ($districts as $key => $district)
                                    <option value="{{ $district->id }}" data-badge="">{{ $district->city }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('district'))
                            <span class="error_mess">{{ $errors->first('district') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Longitude *</label>
                                <input type="text" class="form-control alphanumeric" id="longitude"
                                    name="longitude" required>
                                <div class="invalid-feedback">
                                    Please provide Division.
                                </div>

                            </div>
                            @if ($errors->has('longitude'))
                            <span class="error_mess">{{ $errors->first('longitude') }}</span>
                            @endif

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Latitude *</label>
                                <input type="text" class="form-control alphanumeric" id="latitude"
                                    name="latitude" required>
                                <div class="invalid-feedback">
                                    Please provide Latitude.
                                </div>

                            </div>
                            @if ($errors->has('latitude'))
                            <span class="error_mess">{{ $errors->first('latitude') }}</span>
                            @endif

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Submit/दर्ज करे</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #infraViewModal .modal-dialog {
        max-width: 820px;
        height: 78vh;
        margin: 2rem auto;
    }
    #infraViewModal .modal-content {
        height: 100%;
        max-height: 78vh;
        display: flex;
        flex-direction: column;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        background: #ffffff;
    }
    #infraViewModal .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 20px;
        flex-shrink: 0;
    }
    #infraViewModal #modal_infra_body {
        flex: 1 1 auto;
        overflow-y: auto;
        padding: 16px 20px;
        background: #f8fafc;
    }
    #infraViewModal .modal-footer {
        background: #ffffff;
        border-top: 1px solid #e5e7eb;
        padding: 10px 20px;
        flex-shrink: 0;
    }
    #modal_infra_body::-webkit-scrollbar {
        width: 6px;
    }
    #modal_infra_body::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    #modal_infra_body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    #modal_infra_body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<!-- Modal: View Stadium Infrastructure Details -->
<div class="modal fade" id="infraViewModal" tabindex="-1" role="dialog" aria-labelledby="infraViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="infraViewModalLabel" style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">
                    <i class="fa fa-building-o text-primary" style="font-size: 18px; margin-right: 10px;"></i>
                    <span>Stadium Infrastructure Details</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 22px; color: #64748b; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_infra_body">
                <!-- Stadium & District Header Box -->
                <div class="p-3 mb-3 bg-white" style="border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center" style="gap: 12px;">
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: #f0f9ff; border: 1px solid #e0f2fe; display: flex; align-items: center; justify-content: center; margin-right: 4px; flex-shrink: 0;">
                                <i class="fa fa-university text-primary" style="font-size: 17px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px;">
                                    Stadium & District
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                                    <span id="modal_infra_stadium" style="font-size: 14.5px; font-weight: 600; color: #0f172a;">--</span>
                                    <span class="badge" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; font-size: 11.5px; font-weight: 500; padding: 3px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa fa-map-marker text-danger"></i> <span id="modal_infra_district">--</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-sm-right flex-shrink-0">
                            <span id="modal_infra_count_badge" class="badge" style="background: #0284c7; color: #ffffff; font-size: 11.5px; font-weight: 500; padding: 5px 12px; border-radius: 14px; display: inline-block;">
                                1 Facility
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Facilities Container -->
                <div id="modal_facilities_list">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 6px; font-size: 13px; font-weight: 500;">Close</button>
            </div>
        </div>
    </div>
</div>


@push('custom-scripts')
<script type="text/javascript" src="{{ asset('js/xlsx.full.min.js') }}"></script>

<script type="text/javascript">
    //update==========================
    $('.role_manager_id').click(function() {
        var studium_id = $(this).data('id');
        var studium_name = $(this).data('name');
        var district = $(this).data('district');
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        $('#district').val(district);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        $('#studium_id').val(studium_id);
        $('#studium_name').val(studium_name);
    });

    // View Infrastructure Modal
    $(document).on('click', '.view-infra-btn', function() {
        var stadium = $(this).data('stadium');
        var district = $(this).data('district');
        var facilities = $(this).data('facilities');

        if (typeof facilities === 'string') {
            try {
                facilities = JSON.parse(facilities);
            } catch (e) {
                facilities = [];
            }
        }

        if (!Array.isArray(facilities)) {
            facilities = [];
        }

        $('#modal_infra_stadium').text(stadium || '--');
        $('#modal_infra_district').text(district || '--');
        $('#modal_infra_count_badge').text(facilities.length + (facilities.length > 1 ? ' Facilities Recorded' : ' Facility Recorded'));

        var html = '';
        if (facilities.length === 0) {
            html = '<div class="alert alert-light text-center border text-muted py-4">' +
                '<i class="fa fa-info-circle" style="margin-right: 5px;"></i> No infrastructure facilities registered yet.' +
                '</div>';
        } else {
            $.each(facilities, function(idx, item) {
                var num = idx + 1;
                html += '<div class="card mb-3 shadow-sm" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; background: #ffffff;">' +
                    '<div class="py-2 px-3 d-flex justify-content-between align-items-center" style="background: #f8fafc; border-bottom: 1px solid #e5e7eb;">' +
                    '<div class="d-flex align-items-center" style="gap: 10px;">' +
                    '<span class="badge" style="background: #0284c7; color: #ffffff; font-size: 11.5px; font-weight: 500; padding: 4px 10px; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px;"><i class="fa fa-building-o" style="font-size: 12px;"></i> Facility #' + num + '</span>' +
                    '<span style="font-size: 13px; font-weight: 500; color: #334155; margin-left: 2px;">Infrastructure Details</span>' +
                    '</div>' +
                    '<div class="text-muted d-flex align-items-center" style="font-size: 12px; font-weight: 400; gap: 6px;"><i class="fa fa-clock-o"></i> <span>' + $('<div>').text(item.updated).html() + '</span></div>' +
                    '</div>' +
                    '<div class="card-body p-0">' +
                    '<table class="table mb-0" style="border-collapse: collapse; width: 100%;">' +
                    '<tbody>' +
                    '<tr style="border-bottom: 1px solid #f1f5f9;">' +
                    '<td style="width: 26%; background: #fafafa; font-size: 12.5px; font-weight: 500 !important; color: #374151 !important; padding: 11px 14px; vertical-align: top; border-right: 1px solid #f1f5f9;">' +
                    '<div style="font-weight: 500; color: #374151;">Infrastructure Facilities</div>' +
                    '<div class="text-muted" style="font-size: 11px; font-weight: 400; margin-top: 3px;">(Managed by RSO/DSO)</div>' +
                    '</td>' +
                    '<td style="padding: 11px 16px; font-size: 13px; line-height: 1.65; font-weight: 400; white-space: pre-wrap; word-break: break-word; color: #1f2937; vertical-align: top;">' +
                    $('<div>').text(item.infra || '--').html() +
                    '</td>' +
                    '</tr>' +
                    '<tr style="border-bottom: 1px solid #f1f5f9;">' +
                    '<td style="background: #fafafa; font-size: 12.5px; font-weight: 500 !important; color: #374151 !important; padding: 11px 14px; vertical-align: top; border-right: 1px solid #f1f5f9;">' +
                    '<div style="font-weight: 500; color: #374151;">Available Games & Sports</div>' +
                    '</td>' +
                    '<td style="padding: 11px 16px; font-size: 13px; line-height: 1.65; font-weight: 400; white-space: pre-wrap; word-break: break-word; color: #1f2937; vertical-align: top;">' +
                    $('<div>').text(item.games || 'No games specified.').html() +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="background: #fafafa; font-size: 12.5px; font-weight: 500 !important; color: #374151 !important; padding: 10px 14px; vertical-align: middle; border-right: 1px solid #f1f5f9;">' +
                    '<div style="font-weight: 500; color: #374151;">Updated By</div>' +
                    '</td>' +
                    '<td style="padding: 10px 16px; vertical-align: middle;">' +
                    '<div class="d-flex align-items-center flex-wrap" style="gap: 8px;">' +
                    '<i class="fa fa-user-circle text-primary" style="font-size: 16px; margin-right: 3px;"></i>' +
                    '<span style="font-weight: 500; color: #111827; font-size: 13px; margin-right: 4px;">' + $('<div>').text(item.updater_name).html() + '</span>' +
                    '<span class="badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 500; font-size: 10.5px; padding: 3px 8px; border-radius: 4px;">' + $('<div>').text(item.updater_role).html() + '</span>' +
                    '</div>' +
                    '</td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>';
            });
        }

        $('#modal_facilities_list').html(html);
    });

    // Clean up backdrop and body scroll lock when modal is hidden
    $('#infraViewModal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

    //Delete Hostel Division
    function deleteStudiumMaster(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: ajaxUrl + "/deleteStudiumMaster/" + id,
                    dataType: "json",
                    success: function(res) {
                        success(res.msg);
                        $("#responsive").load(" #responsive");
                        tableRendor();
                    },
                });
            }
        });
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
            XLSX.writeFile(wb, fn || ('Stadium Master List.' + (type || 'xlsx')));
    }
</script>
@endpush