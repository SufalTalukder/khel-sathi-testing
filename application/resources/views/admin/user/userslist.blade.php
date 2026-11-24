@extends('layouts/admin_layout')
@section('content')
    <div class="pageheader" id="menu-margin">
        <h4 class="mb-0">User List
            <a href="{{ route('user_manager_add') }}" class="btn btn-primary btn-sm float-end">Add User</a>
            <a title="User List" class="btn btn-sm btn-success float-end" onclick="ExportToExcel('xlsx')">
                <i class="fa fa-file-excel"></i> Export to Excel
            </a>
        </h4>
    </div>

    <div class="card">
        <div class="card-body">


            <form action="{{ route('user_manager') }}" method="GET" id="roleFilterForm">

                <div class="dropdown">

                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="roleDropdownBtn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="selectedRoleText">Select Admin Role</span>
                    </button>

                    <div class="dropdown-menu p-3 shadow" style="width: 260px;" id="roleDropdown">

                        <!-- Search -->
                        <input type="text" id="searchRole" class="form-control form-control-sm mb-2"
                            placeholder="Search...">

                        <!-- Select All -->
                        <div class="form-check mb-1 border-bottom pb-1">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                <strong>(Select All)</strong>
                            </label>
                        </div>

                        <!-- Role List -->
                        <div class="overflow-auto" style="max-height: 160px;">

                            @foreach ($admin_roles as $role)
                                <div class="form-check role-item">
                                    <input type="checkbox" class="form-check-input role-checkbox" name="admin_role[]"
                                        id="role{{ $role->id }}" value="{{ $role->id }}"
                                        {{ in_array($role->id, request('admin_role', [])) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        {{ $role->role_name }}
                                    </label>
                                </div>
                            @endforeach

                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-3 border-top pt-2">

                            <button type="submit" class="btn btn-primary btn-sm">
                                OK
                            </button>

                            <button type="button" class="btn btn-secondary btn-sm" id="cancelRole">
                                Cancel
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {

            // Open Dropdown
            $('#roleDropdownBtn').click(function() {
                $('#roleDropdown').toggleClass('show');
            });

            // Search Roles
            $('#searchRole').on('keyup', function() {

                var search = $(this).val().toLowerCase();

                $('.role-checkbox').each(function() {

                    var roleName = $(this).parent().text().toLowerCase();

                    $(this).parent().toggle(roleName.indexOf(search) !== -1);

                });

                $('.select-all').show();

            });

            // Select All
            $('#selectAll').change(function() {

                var checked = $(this).prop('checked');

                $('.role-checkbox:visible').prop('checked', checked);

                updateRoleText();

            });

            // Individual Checkbox
            $('.role-checkbox').change(function() {

                var total = $('.role-checkbox').length;
                var checked = $('.role-checkbox:checked').length;

                $('#selectAll').prop('checked', total === checked);

                updateRoleText();

            });

            // Update Selected Text
            function updateRoleText() {

                var selected = $('.role-checkbox:checked').length;

                $('#selectedRoleText').text(
                    selected > 0 ? selected + ' Roles Selected' : 'Select Admin Role'
                );

            }

            // Cancel
            var previousSelection = [];

            $('#roleDropdownBtn').click(function() {

                previousSelection = $('.role-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

            });

            $('#cancelRole').click(function() {

                $('.role-checkbox').prop('checked', false);

                $.each(previousSelection, function(i, value) {
                    $('.role-checkbox[value="' + value + '"]').prop('checked', true);
                });

                $('#selectAll').prop(
                    'checked',
                    $('.role-checkbox').length === $('.role-checkbox:checked').length
                );

                updateRoleText();

                $('#roleDropdown').removeClass('show');

            });

            // OK Button
            $('#roleFilterForm').on('submit', function() {
                $('#roleDropdown').removeClass('show');
            });

            // Initial Count
            $('#selectAll').prop(
                'checked',
                $('.role-checkbox').length > 0 &&
                $('.role-checkbox').length === $('.role-checkbox:checked').length
            );

            // Maintain selected roles after Apply
function updateRoleText() {

    var selected = $('.role-checkbox:checked').length;

    $('#selectedRoleText').text(
        selected > 0 ? selected + ' Roles Selected' : 'Select Admin Role'
    );

    $('#selectAll').prop(
        'checked',
        $('.role-checkbox').length > 0 &&
        $('.role-checkbox').length === $('.role-checkbox:checked').length
    );
}

            updateRoleText();

        });
    </script>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordred table-hover bg-white datatable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Email Id</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Login Detail</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ roleName($item->admin_role) }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->designation }}</td>
                                <td class="text-center">
                                    <div class="form-control2">
                                        <label class="switch">
                                            <input type="checkbox" id="themeskin{{ $key + 1 }}" <?php if ($item->status == 1) {
                                                echo 'checked';
                                            } elseif ($item->status == 0) {
                                                echo '';
                                            } else {
                                                echo 'checked';
                                            } ?>>
                                            <div class="slider round"
                                                onclick="userManagerStatus('{{ $item->id }}', this)">
                                                <span class="off">Disable</span>
                                                <span class="on">Enable</span>
                                            </div>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary pointer bt"
                                        href="{{ route('logDetail', $item->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-dark pointer bt" href="{{ route('edituser', $item->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger pointer bt px-2"
                                        href="{{ url('/admin/deleteUser') }}/{{ $item->id }}"
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
@endsection


@push('custom-scripts')
    <script type="text/javascript" src="{{ asset('js/xlsx.full.min.js') }}"></script>
    <script>
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
                XLSX.writeFile(wb, fn || ('UserList.' + (type || 'xlsx')));
        }
    </script>
@endpush
