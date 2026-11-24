@extends('layouts.private_coaching_auth_layout')
@section('content')

    <div class="container-fluid pagecontentbody">
        <div class="tab-content">
            <div class="pagebody removebg-color">
                <div class="pageheader d-flex justify-content-between align-items-center flex-wrap" id="menu-margin" style="padding: 14px 0; margin-bottom: 22px; border-bottom: 1px solid #e2e8f0;">
                    <div>
                        <h4 class="mb-1 text-dark fw-bold" style="font-size: 1.25rem;">
                            <i class="fa fa-th-list text-primary me-2"></i> Applicant Details / आवेदक विवरण
                        </h4>
                        <small class="text-muted">View all your submitted applications, inspection schedules, fee status, and certificates.</small>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <a class="btn btn-success btn-sm rounded-pill px-4 shadow-sm" href="{{ route('private_apply_for') }}" style="font-weight: 600;">
                            <i class="fa fa-plus me-1"></i> Apply For
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: #ffffff;">
                    <div class="card-body p-4">
                        @if(
                                $academyApplication->isEmpty() && $associationApplication->isEmpty() &&
                                $swimmingApplication->isEmpty() && $gymApplication->isEmpty()
                            )
                            <div class="alert alert-info border-0 rounded-3 text-center py-4 my-2">
                                <i class="fa fa-info-circle fa-lg me-2"></i> No applications found. Click <strong>Apply For</strong> above to submit a new application.
                            </div>
                        @else
                            <table class="table table-bordred table-hover bg-white">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        <th>Application No.</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Institution Name</th>
                                        <th>Email ID</th>
                                        <th>Mobile No.</th>
                                   
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp

                                    <!-- Academy Applications -->
                                    @foreach ($academyApplication as $item)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>Academy</td>
                                            <td>{{ $item->application_no ?? 'N/A' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->institute_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->mobile }}</td>
                                  

                                            @include('private_coaching.applicant_status_cell', ['item' => $item, 'type' => 'academy'])
                                            <td class="text-center">
                                                <a class="btn btn-xs btn-outline-primary"
                                                    href="{{ route('academies_application_preview', $item->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($item->final_submit != 1)
                                                    <a class="btn btn-xs btn-outline-success"
                                                        href="{{ route('private_coaching_academies', $item->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Association Applications -->
                                    @foreach ($associationApplication as $item)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>Association</td>
                                            <td>{{ $item->application_no ?? 'N/A' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->institute_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->mobile }}</td>
                          

                                            @include('private_coaching.applicant_status_cell', ['item' => $item, 'type' => 'association'])

                                            <td class="text-center">
                                                <a class="btn btn-xs btn-outline-primary"
                                                    href="{{ route('private_coaching_application_preview', $item->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($item->final_submit != 1)
                                                    <a class="btn btn-xs btn-outline-success"
                                                        href="{{ route('private_coaching_application_form', $item->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Swimming Applications -->
                                    @foreach ($swimmingApplication as $item)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>Swimming Pool</td>
                                            <td>{{ $item->application_no ?? 'N/A' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->institute_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->mobile }}</td>
                                       

                                            @include('private_coaching.applicant_status_cell', ['item' => $item, 'type' => 'swimming'])

                                            <td class="text-center">
                                                <a class="btn btn-xs btn-outline-primary"
                                                    href="{{ route('swimming_pool_application_preview', $item->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($item->final_submit != 1)
                                                    <a class="btn btn-xs btn-outline-success"
                                                        href="{{ route('private_coaching_swimming_pool', $item->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Gym Applications -->
                                    @foreach ($gymApplication as $item)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>Gym</td>
                                            <td>{{ $item->application_no ?? 'N/A' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->institute_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->mobile }}</td>
                                   

                                            @include('private_coaching.applicant_status_cell', ['item' => $item, 'type' => 'gym'])

                                            <td class="text-center">
                                                <a class="btn btn-xs btn-outline-primary"
                                                    href="{{ route('gyms_application_preview', $item->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($item->final_submit != 1)
                                                    <a class="btn btn-xs btn-outline-success"
                                                        href="{{ route('private_coaching_gyms', $item->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentnote" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Note</h5>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Registration Fees - <span class="text-danger"><i
                                class="fa fa-rupee-sign"></i>5500.00</span></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Proceed To Pay</button>
                </div>
            </div>
        </div>
    </div>

@endsection
