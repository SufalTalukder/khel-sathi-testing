<style>
    .fa-stack[data-count]:after {
        position: absolute;
        right: 0%;
        top: 1%;
        content: attr(data-count);
        font-size: 30%;
        padding: .6em;
        border-radius: 999px;
        line-height: .75em;
        color: white;
        background: rgba(255, 0, 0, .85);
        text-align: center;
        min-width: 2em;
        font-weight: bold;
    }

    .disabledd {
        display: none;
    }
</style>

<?php
$d_check = '';
if (($form_type1 == 1 || $form_type1 == 2) && Auth::guard('admin')->user()->admin_role == 3) {
    $d_check = 'disabledd';
}
?>
<div class="table-responsive">
    <table id="applicantTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Application No.</th>
                @if ($form_type1 == 6)
                <th>Post Name</th>
                @endif
                <th>Applicant’s Name</th>
                <th>Email ID</th>
                <th> District</th>
                <th>Sport Name</th>
                <th>Date of Application</th>
                <th>Application Status</th>

                @if (
                (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17) &&
                $form_type1 != 6)
                <th>Amount</th>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 3)
                <th>Query Status</th>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 2 ||
                Auth::guard('admin')->user()->admin_role == 4 ||
                Auth::guard('admin')->user()->admin_role == 8 ||
                Auth::guard('admin')->user()->admin_role == 9)
                @if (Auth::guard('admin')->user()->admin_role != 4)
                <th>Query Status</th>
                @endif
                <th class="text-center">Action</th>
                @if (Auth::guard('admin')->user()->admin_role == 2 || Auth::guard('admin')->user()->admin_role == 9)
                <th class="text-center">View</th>
                @endif
                <!-- <th>Forward to Directorate</th> -->
                @if (Auth::guard('admin')->user()->admin_role == 8)
                <th style="width: 165.783px;">Forward to Directorate</th>
                @endif
                @else
                @if (Auth::guard('admin')->user()->admin_role != 3)
                <th class="text-center">View</th>
                @endif

                @if (Auth::guard('admin')->user()->admin_role == 3 && $direct_ass == 0)
                <th style="width: 165.783px;" class="{{ $d_check }}">Forward to @if ($form_type1 == 3 || $form_type1 == 7)
                    SO/RSO
                    @else
                    Directorate
                    @endif Status
                </th>
                <th class="text-center {{ $d_check }}">Action</th>
                @elseif(Auth::guard('admin')->user()->admin_role == 3 && $direct_ass == 1)
                <th style="width: 165.783px;" class="{{ $d_check }}">Forward to @if (Auth::guard('admin')->user()->admin_role == 3 && $form_type1 == 6)
                    Dealing Assistance
                    @else
                    Directorate
                    @endif Status
                </th>
                <th class="text-center {{ $d_check }}">Action</th>
                @endif

                @if (Auth::guard('admin')->user()->admin_role == 3)
                <th class="text-center">View</th>
                @endif
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 11)
                <th class="text-center">Forward</th>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 10)
                <th class="text-center">Forward to Directorate</th>
                @endif
                @if (
                (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17) &&
                $form_type1 == 6)
                <th class="text-center">Forward Status</th>
                @endif
                <!-- <th>Query Status</th> -->
                <!-- <th class="text-center">Action</th> -->
                <!-- <th>Forward to Directorate</th> -->
                <!-- <th>Amount</th> -->
                @if (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17)
                <th>Trail</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $key => $list)

            <?php
            $ttt = '';
            if ((Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 18 || Auth::guard('admin')->user()->admin_role == 17) && ($list->notificationBy == 3 || $list->notificationBy == 2) && ($list->is_forwarded_by_rso == 1 || (isset($list->is_forwarded_by_association) && $list->is_forwarded_by_association == 1))) {
                $ttt = 'data-count=1';
            }

            if (Auth::guard('admin')->user()->admin_role == 2 && $list->notificationBy == 3 && $list->is_forwarded_by_rso != 1) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 2 && $list->notificationBy == 1 && $list->is_forwarded_by_rso == 1) {
                $ttt = 'data-count=1';
            }

            if (Auth::guard('admin')->user()->admin_role == 3 && $list->notificationBy == 2 && (isset($list->is_forwarded_by_association) && $list->is_forwarded_by_association != 1)) {
                $ttt = 'data-count=1';
            }

            if (Auth::guard('admin')->user()->admin_role == 3 && $list->notificationBy == 1 && (isset($list->is_forwarded_by_association) && $list->is_forwarded_by_association == 1)) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 3 && $list->notificationBy == 2 && (isset($list->is_forwarded_by_association) && $list->is_forwarded_by_association == 1) && $form_type1 == 3 && $list->is_forwarded_by_rso != 1) {
                $ttt = 'data-count=1';
            }

            if (Auth::guard('admin')->user()->admin_role == 3 && ($list->notificationBy == 1 || $list->notificationBy == 11) && $list->is_forwarded_by_rso == 1 && $form_type1 == 6) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 11 && $list->notificationBy == 3 && $list->is_forwarded_by_rso == 1 && $form_type1 == 6) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 11 && $list->notificationBy == 8 && $list->is_forwarded_by_rso == 3 && $form_type1 == 6) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 11 && $list->notificationBy == 2 && $list->is_forwarded_by_rso == 2) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 8 && ($list->notificationBy == 3 || $list->notificationBy == 11) && $list->is_forwarded_by_rso == 3) {
                $ttt = 'data-count=1';
            }
            if (Auth::guard('admin')->user()->admin_role == 8 && ($list->notificationBy == 1 || $list->notificationBy == 11) && $list->is_forwarded_by_rso == 4) {
                $ttt = 'data-count=1';
            }

            if ((Auth::guard('admin')->user()->admin_role == 1 || Auth::guard('admin')->user()->admin_role == 18 || Auth::guard('admin')->user()->admin_role == 17) && ($list->notificationBy == 4 || $list->notificationBy == 8) && $list->is_forwarded_by_rso == 4) {
                $ttt = 'data-count=1';
            }

            ?>
            <tr>
                <?php $data = AllCom($list->application_no); ?>
                <td>{{ $key + 1 }}</td>
                <td>{{ $list->application_no }}</td>
                @if ($form_type1 == 6)
                <td>{{ ucwords(strtolower(AllAppliedPost($list->application_no))) }}</td>
                @endif
                <td>{{ $list->fullname }}</td>

                <td>{{ $list->email }}</td>
                <td>{{ districtName($list->permanent_district) }}</td>

                <td>
                    {{ $list->sportName }}
                    {{-- @if (count($data) > 0)
                        @foreach ($data as $item)
                        {{sport_name($item->sport_name)}} <br>
                    @endforeach
                    @endif --}}
                </td>
                @if ($form_type1 == 7)
                <td>{{ application_submission_date($list) }}</td>
                @php
                $tot_q = isset($list->total_queries) ? (int)$list->total_queries : DB::table('query_master')->where('form_type', 7)->where('application_no', $list->application_no)->count();
                $opn_q = isset($list->open_queries) ? (int)$list->open_queries : DB::table('query_master')->where('form_type', 7)->where('application_no', $list->application_no)->where(function($q) { $q->where('is_closed', 0)->orWhereNull('is_closed'); })->count();
                @endphp
                <td>
                    @if ($list->form_status == 1)
                    <span class="badge bg-success text-white rounded-pill">Accepted</span>
                    @elseif ($list->form_status == 2)
                    <span class="badge bg-danger text-white rounded-pill">Rejected</span>
                    @elseif ($tot_q > 0)
                    @if ($opn_q > 0)
                    <span class="badge bg-primary text-white rounded-pill">Query Raised</span>
                    @else
                    <span class="badge bg-success text-white rounded-pill">Query Resolved</span>
                    @endif
                    @elseif ($list->form_status == 3)
                    <span class="badge bg-warning text-white rounded-pill">Pending</span>
                    @else
                    <span class="badge bg-warning text-white rounded-pill">Pending</span>
                    @endif
                </td>
                @else
                <td>{{ date('d-m-Y', strtotime($list->created_at)) }}</td>
                <td><?php if ($list->form_status == 1) { ?>
                        <span class="badge bg-success text-white rounded-pill">Accepted</span>
                    <?php } elseif ($list->form_status == 3) { ?>
                        <span class="badge bg-warning text-white rounded-pill">Pending</span>
                    <?php } elseif ($list->form_status == 2) { ?>
                        <span class="badge bg-danger text-white rounded-pill">Rejected</span>
                    <?php } else { ?>
                        <span class="badge bg-warning text-white rounded-pill">Pending</span>
                    <?php } ?>
                </td>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 3)
                {{-- @if ($form_type1 == 4 || $form_type1 == 5 || $form_type1 == 6)
                <?php $abc = marked_status($list->user_id, $form_type1); ?>
                @else --}}
                <?php
                $abc = marked_status($list->application_no, $form_type1);
                if (!$abc && $form_type1 == 7) {
                    $abc = DB::table('query_master')->select('query_status', 'current_status', 'is_closed')->where('application_no', $list->application_no)->where('form_type', 7)->orderBy('id', 'DESC')->first();
                }
                ?>
                {{-- @endif --}}
                <td>
                    @if (isset($abc) && ($list->form_status == 0 || ($form_type1 == 7 && $list->form_status == 3)) && $abc->is_closed == 0)
                    @if ($abc->query_status == 0)
                    <strong class="badge bg-success text-white rounded-pill">Marked</strong>
                    @else
                    <strong class="badge bg-primary text-white rounded-pill">
                        @if ($abc->current_status == 'User')
                        User
                        @endif Replied
                    </strong>
                    @endif
                    @elseif(isset($abc) && $abc->is_closed == 1)
                    <strong class="badge bg-danger text-white rounded-pill disabled">Closed</strong>
                    @else
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not
                        Marked</strong>
                    @endif
                </td>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 2 ||
                Auth::guard('admin')->user()->admin_role == 4 ||
                Auth::guard('admin')->user()->admin_role == 8 ||
                Auth::guard('admin')->user()->admin_role == 9)
                {{-- @if ($form_type1 == 4 || $form_type1 == 5 || $form_type1 == 6)
                <?php $abc = marked_status($list->user_id, $form_type1); ?>
                @else --}}

                <?php
                $abc = marked_status($list->application_no, $form_type1);
                if (!$abc && $form_type1 == 7) {
                    $abc = DB::table('query_master')->select('query_status', 'current_status', 'is_closed')->where('application_no', $list->application_no)->where('form_type', 7)->orderBy('id', 'DESC')->first();
                }
                ?>
                {{-- @endif --}}
                @if (Auth::guard('admin')->user()->admin_role != 4)
                <td>
                    @if (isset($abc) && ($list->form_status == 0 || ($form_type1 == 7 && $list->form_status == 3)) && $abc->is_closed == 0)
                    @if ($abc->query_status == 0)
                    <strong class="badge bg-primary text-white rounded-pill">Marked</strong>
                    @else
                    <strong class="badge bg-primary text-white rounded-pill">
                        @if ($abc->current_status == 'User')
                        User
                        @endif Replied
                    </strong>
                    @endif
                    @elseif(isset($abc) && $abc->is_closed == 1)
                    <strong class="badge bg-danger text-white rounded-pill disabled">Closed</strong>
                    @else
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not
                        Marked</strong>
                    @endif
                </td>
                @endif
                @if (Auth::guard('admin')->user()->admin_role == 2 || Auth::guard('admin')->user()->admin_role == 9)
                <td>

                    <div style="display: inline-block;">

                        <?php if ($list->is_forwarded_by_rso == 1) { ?>
                            <strong class="badge bg-success text-white rounded-pill disabled">Forwarded to
                                @if ($form_type1 == 7)
                                Prize Money Admin
                                @else
                                Directorate
                                @endif
                            </strong>
                        <?php } else { ?>
                            <a href="#"
                                class="btn btn-primary btn-xs btn-block show_data_id @if ($list->form_status == 2) disabled @endif"
                                data-id="{{ $list->id }}" data-form_type="{{ $form_type1 }}"
                                data-data="{{ $list->is_forwarded_by_rso }}"
                                data-application_no="{{ $list->application_no }}" id="h{{ $list->id }}"
                                onclick="forward({{ $list->id }})" data-bs-toggle="modal"
                                data-bs-target="#forwardedbtn1">Forward to @if ($form_type1 == 7)
                                Prize Money Admin
                                @else
                                Directorate
                                @endif
                            </a>
                        <?php } ?>
                    </div>
                </td>
                @endif
                <td class="text-center">

                    <span class="fa-stack " {{ $ttt }}>
                        @if ($form_type1 == 4 || $form_type1 == 5 || $form_type1 == 6)
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @else
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @endif
                    </span>
                    <!-- <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i class="fa fa-eye"></i></a> -->
                </td>

                @if (Auth::guard('admin')->user()->admin_role == 8)
                <td>
                    @if ($list->is_forwarded_by_rso > 3 || ($form_type1 == 6 && $list->is_forwarded_by_rso >= 2))
                    <strong class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                    @else
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id "
                        data-id="{{ $list->id }}" data-form_type="{{ $form_type1 }}"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}" id="h{{ $list->user_id }}"
                        onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward</a>
                    @endif
                </td>
                @endif
                @else
                @if (
                (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17) &&
                $form_type1 != 6)
                <td><?php if (($list->is_forwarded_by_rso == 1 && $form_type1 == 3  && $list->form_status == 1) || (isset($list->is_forwarded_by_association) && $list->is_forwarded_by_association == 1) && ($form_type1 == 1 ||  $form_type1 == 2 ||  $form_type1 == 4 ||  $form_type1 == 5)  && $list->form_status == 1) { ?>

                        <?php if ($list->amount_release_status == 1) { ?>
                            <strong class="badge bg-success text-white rounded-pill disabled">Released</strong>
                        <?php } else { ?>
                            <a href="#" class="btn btn-info btn-xs btn-block show_released_id"
                                data-id="{{ $list->id }}" data-form_type="{{ $form_type1 }}"
                                onclick="released({{ $list->id }})" data-bs-toggle="modal"
                                data-bs-target="#releasebtn1">Release</a>
                        <?php } ?>
                    <?php } else { ?>
                        <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not
                            Released</strong>
                    <?php } ?>
                </td>
                @endif
                @if (Auth::guard('admin')->user()->admin_role != 3)
                <td class="text-center">
                    <span class="fa-stack " {{ $ttt }}>
                        @if ($form_type1 == 4 || $form_type1 == 5 || $form_type1 == 6)
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @else
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @endif
                    </span>
                </td>
                @endif
                @if (Auth::guard('admin')->user()->admin_role != 1 &&
                Auth::guard('admin')->user()->admin_role != 18 &&
                Auth::guard('admin')->user()->admin_role != 17)
                @if (Auth::guard('admin')->user()->admin_role == 3)
                <td class="{{ $d_check }}">
                    @if ($direct_ass == 0)
                    @if ($list->is_forwarded_by_association == 1)
                    <strong class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                    @elseif ($list->form_status == 2)
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not Forwarded</strong>
                    @else
                    <strong class="badge bg-warning text-white rounded-pill disabled">Pending</strong>
                    @endif
                    @elseif ($direct_ass == 1)
                    @if (($form_type1 != 6 && $list->is_forwarded_by_rso == 4) || ($form_type1 == 6 && $list->is_forwarded_by_rso >= 5))
                    <strong class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                    @elseif ($list->form_status == 2 && $list->is_forwarded_by_rso != 4)
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not Forwarded</strong>
                    @else
                    <strong class="badge bg-warning text-white rounded-pill disabled">Pending</strong>
                    @endif
                    @endif
                </td>
                <td class="text-center {{ $d_check }}">
                    @if ($direct_ass == 0)
                    @php
                    $forward_target = ($form_type1 == 3 || $form_type1 == 7) ? 'SO/RSO' : 'Directorate';
                    @endphp
                    @if ($list->is_forwarded_by_association == 1)
                    <strong class="badge bg-success text-white rounded-pill disabled nowrap">Forwarded to {{ $forward_target }}</strong>
                    @elseif ($list->form_status == 2)
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not Forwarded</strong>
                    @else
                    @if (isset($abc) && $list->form_status == 0 && $abc->is_closed == 0)
                    <a class="btn btn-primary btn-xs btn-block disabled nowrap">Forward to {{ $forward_target }}</a>
                    @else
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id nowrap"
                        data-reg_id="{{ $list->user_id }}"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}"
                        id="h{{ $list->id }}" data-id="{{ $list->id }}"
                        data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward to {{ $forward_target }}</a>
                    @endif
                    @endif
                    @elseif ($direct_ass == 1)
                    @php
                    $forward_target_1 = ($form_type1 == 6) ? 'Dealing Assistance' : 'Directorate';
                    @endphp
                    @if (($form_type1 != 6 && $list->is_forwarded_by_rso == 4) || ($form_type1 == 6 && $list->is_forwarded_by_rso >= 5))
                    <strong class="badge bg-success text-white rounded-pill disabled nowrap">Forwarded to {{ $forward_target_1 }}</strong>
                    @elseif ($list->form_status == 2 && $list->is_forwarded_by_rso != 4)
                    <strong class="badge bg-danger text-white rounded-pill disabled nowrap">Not Forwarded</strong>
                    @else
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id nowrap"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}"
                        id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                        data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward to {{ $forward_target_1 }}</a>
                    @endif
                    @endif
                </td>
                <td class="text-center">
                    <span class="fa-stack " {{ $ttt }}>
                        @if ($form_type1 == 4 || $form_type1 == 5 || $form_type1 == 6)
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @else
                        <a class="btn btn-sm btn-dark" href="{{ route($url, $list->application_no) }}"><i
                                class="fa fa-eye"></i></a>
                        @endif
                    </span>
                </td>
                @else
                <td class="{{ $d_check }}">
                    @if ($direct_ass == 0 && $list->is_forwarded_by_association == 0)
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}"
                        id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                        data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward</a>
                    @elseif($direct_ass == 1)
                    @if ($list->is_forwarded_by_rso == 4 && $form_type1 != 6)
                    <strong
                        class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                    @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso == 1)
                    <strong class="badge bg-success text-white rounded-pill disabled">Forwarded to
                        Examination Committee</strong>
                    @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso == 5)
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}"
                        id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                        data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward</a>
                    @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso >= 3 && $list->is_forwarded_by_rso < 4)
                        <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}"
                        id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                        data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward</a>
                        @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso >= 4)
                        <strong
                            class="badge bg-success text-white rounded-pill disabled nowrap">Forwarded</strong>
                        @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso == 0)
                        <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                            data-data="{{ $list->is_forwarded_by_rso }}"
                            data-application_no="{{ $list->application_no }}"
                            id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                            data-form_type="{{ $form_type1 }}"
                            onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                            data-bs-target="#forwardedbtn1">Forward</a>
                        @elseif(Auth::guard('admin')->user()->admin_role == 11 && $list->is_forwarded_by_rso == 2 && $form_type1 != 6)
                        <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                            data-data="{{ $list->is_forwarded_by_rso }}"
                            data-application_no="{{ $list->application_no }}"
                            id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                            data-form_type="{{ $form_type1 }}"
                            onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                            data-bs-target="#forwardedbtn1">Forward to Examination Committee</a>
                        @elseif(Auth::guard('admin')->user()->admin_role == 11 && $form_type1 == 6)
                        <!-- dr -->
                        @if ($list->is_forwarded_by_rso == 2)
                        {{-- <a href="#" class="btn btn-primary btn-xs btn-block show_data_id" data-data="{{$list->is_forwarded_by_rso}}" data-application_no="{{$list->application_no}}" id="h{{$list->user_id}}" data-id="{{$list->id}}" data-form_type="{{$form_type1}}" onclick="forward({{$list->user_id}})" data-bs-toggle="modal" data-bs-target="#forwardedbtn1">Forward to Dealing Assistance</a> --}}
                        <strong class="badge bg-success text-white rounded-pill disabled">Pending
                            At Directorate</strong>
                        @elseif($list->is_forwarded_by_rso == 0)
                        <strong class="badge bg-success text-white rounded-pill disabled">Forwarded
                            to Examination Committee</strong>
                        @elseif($list->is_forwarded_by_rso == 1)
                        <strong class="badge bg-success text-white rounded-pill disabled">Pending
                            At Examination Committee</strong>
                        @elseif($list->is_forwarded_by_rso == 3)
                        <strong class="badge bg-success text-white rounded-pill disabled">Pending
                            At Dealing Assistance</strong>
                        @endif
                        @else
                        <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                            data-data="{{ $list->is_forwarded_by_rso }}"
                            data-application_no="{{ $list->application_no }}"
                            id="h{{ $list->user_id }}" data-id="{{ $list->id }}"
                            data-form_type="{{ $form_type1 }}"
                            onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                            data-bs-target="#forwardedbtn1">Forward</a>
                        @endif
                        @else
                        <strong
                            class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                        @endif
                </td>
                @endif

                @endif
                @endif

                @if (
                (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17) &&
                $form_type1 == 6)
                <td>
                    @if ($list->is_forwarded_by_rso == 2)
                    <a href="#" class="btn btn-primary btn-xs btn-block show_data_id"
                        data-data="{{ $list->is_forwarded_by_rso }}"
                        data-application_no="{{ $list->application_no }}" id="h{{ $list->user_id }}"
                        data-id="{{ $list->id }}" data-form_type="{{ $form_type1 }}"
                        onclick="forward({{ $list->user_id }})" data-bs-toggle="modal"
                        data-bs-target="#forwardedbtn1">Forward to Dealing Assistance</a>
                    {{-- <strong class="badge bg-success text-white rounded-pill disabled">Forward to Dealing Assistance </strong> --}}
                    @elseif($list->is_forwarded_by_rso == 0)
                    <strong class="badge bg-success text-white rounded-pill disabled">Pending At Dealing
                        Level</strong>
                    @elseif($list->is_forwarded_by_rso == 1)
                    <strong class="badge bg-success text-white rounded-pill disabled">Pending At
                        Examination Committee</strong>
                    @elseif($list->is_forwarded_by_rso >= 3)
                    <strong class="badge bg-success text-white rounded-pill disabled">Forwarded</strong>
                    @endif
                </td>
                @endif

                @if (Auth::guard('admin')->user()->admin_role == 1 ||
                Auth::guard('admin')->user()->admin_role == 18 ||
                Auth::guard('admin')->user()->admin_role == 17)
                <td class="text-center">
                    <a class="btn btn-sm btn-danger pointer bt"
                        href="{{ url('/admin/trail/') }}/{{ $list->user_id }}/{{ $form_type1 }}">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(isset($collection) && method_exists($collection, 'links'))
    <div class="row mt-3 mb-2 align-items-center">
        <div class="col-sm-6">
            <div class="dataTables_info text-muted fw-semibold">
                Showing {{ $collection->firstItem() ?? 0 }} to {{ $collection->lastItem() ?? 0 }} of {{ $collection->total() }} entries
            </div>
        </div>
        <div class="col-sm-6 text-end">
            <div class="d-inline-block">
                {{ $collection->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @endif
</div>