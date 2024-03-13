@extends('layouts.master')
@section('content')
    <style>
        .red-text {
            color: red;
        }
    </style>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Create Bill</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Bill</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('create/bill/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Company <span class="text-danger">*</span></label>
                                    <select class="select" id="company" name="company" class="form-control">
                                        <option value="" disabled selected>Select Company
                                        </option>
                                        <option value="Sunny">Sunny</option>
                                        <option value="Sunfood">Sunfood</option>
                                        <option value="Sungrop">Sungrop</option>
                                    </select>
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Agencies<span class="text-danger">*</span></label>
                                    <select class="select2s-hidden-accessible" style="width: 100%;" tabindex="-1"
                                        aria-hidden="true" id="agencies" name="agencies">
                                        <option value="" disabled selected>Select Agencies
                                        </option>
                                        @foreach ($agencies as $value)
                                            <option value="{{ $value->age_id }}"
                                                {{ old('age_id') == $value->age_id ? 'selected' : '' }}>
                                                {{ $value->age_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('agencies')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="bill_date"
                                            name="bill_date">
                                        @error('bill_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Name Code <span class="text-danger">*</span></label>
                                    <input class="form-control" type="requester" id="requester" name="requester">
                                    @error('requester')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Approver <span class="text-danger">*</span></label>
                                    <select class="select2s-hidden-accessible col-md-12 col-sm-12" id="users"
                                        name="users">
                                        <option value="" disabled selected>Select Approver
                                        </option>
                                        @foreach ($users as $value)
                                            @if ($value->role_name == 'Approve')
                                                <option value="{{ $value->user_id }}"
                                                    {{ old('user_id') == $value->user_id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('users')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-white" id="tableBill">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px">#</th>
                                                <th class="col ">Item</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    {{-- <div class="input-group  mb-3 mt-2 " style="width:auto;"> --}}
                                                    <select class="select2s-hidden-accessible col-md-12 col-sm-10"
                                                        id="item" name="item[]" required>
                                                        <option value="" disabled selected>Select Item</option>
                                                        @foreach ($items as $value)
                                                            <option value="{{ $value->item_id }}"
                                                                {{ in_array($value->item_id, old('item_id', [])) ? 'selected' : '' }}>
                                                                {{ $value->item_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('item')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <div class="input-group  mb-3 mt-2 ">
                                                        <select class="select2s-hidden-accessible col-md-12 col-sm-10"
                                                            id="departments" name="departments[]" required>
                                                            <option value="" disabled selected>Select Department
                                                            </option>
                                                            @foreach ($departments as $value)
                                                                <option value="{{ $value->depart_id }}"
                                                                    {{ in_array($value->depart_id, old('departments', [])) ? 'selected' : '' }}>
                                                                    {{ $value->department }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('departments')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <span class="input-group-text mt-2 col-md-auto"
                                                            id="inputGroup-sizing-default">Qty</span>
                                                        <input type="text" class="form-control mt-2 qty col-md-auto"
                                                            aria-label="Sizing example input" oninput="makeNegative(this)"
                                                            aria-describedby="inputGroup-sizing-default" id="qty"
                                                            name="qty[]">
                                                        <span class="input-group-text mt-2 col-md-auto"
                                                            id="inputGroup-sizing-default">Desc</span>
                                                        <input type="text" class="form-control mt-2 qty col-md-auto"
                                                            aria-label="Sizing example input"
                                                            aria-describedby="inputGroup-sizing-default" id="desc"
                                                            name="desc[]">
                                                    </div>
                                                    <div class="input-group  mb-2 mt-2 ">
                                                        @error('qty.*')
                                                            <span class="text-danger col-md-6">{{ $message }}</span>
                                                        @enderror
                                                        @error('desc.*')
                                                            <span class="text-danger col-md-6">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td><a href="javascript:void(0)" class="text-success font-18"
                                                        title="Add" id="addBtn"><i class="fa fa-plus"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            {{-- <button class="btn btn-primary submit-btn m-r-10">Save & Send</button> --}}
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2s-hidden-accessible').select2({
                closeOnSelect: false
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#item').select2({
                placeholder: '',
                allowClear: true,
                minimumResultsForSearch: 1,
                maximumSelectionLength: 1,
            });
        });
    </script> --}}
    {{-- add multiple row --}}
    <script>
        var rowIdx = 1;
        $("#addBtn").on("click", function() {
            // Adding a row inside the tbody.
            var newRow = $(`
                <tr id="R${++rowIdx}">
                    <td class="row-index text-center"><p>${rowIdx}</p></td>
                    <td>
                        <select class="select2s-hidden-accessible col-md-12 col-sm-10"
                                                        id="item${rowIdx}" name="item[]" required>
                                                        <option value="" disabled selected>Select Department</option>
                                                        @foreach ($items as $value)
                                                            <option value="{{ $value->item_id }}"
                                                                {{ in_array($value->item_id, old('item_id', [])) ? 'selected' : '' }}>
                                                                {{ $value->item_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('item${rowIdx}')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <div class="input-group  mb-3 mt-2 ">
                                                        <select class="select2s-hidden-accessible col-md-12 col-sm-10"
                                                            id="departments${rowIdx}" name="departments[]" required>
                                                            <option value="" disabled selected>Select Department
                                                            </option>
                                                            @foreach ($departments as $value)
                                                                <option value="{{ $value->depart_id }}"
                                                                    {{ in_array($value->depart_id, old('departments', [])) ? 'selected' : '' }}>
                                                                    {{ $value->department }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('departments${rowIdx}')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <span class="input-group-text mt-2 col-md-auto"
                                                            id="inputGroup-sizing-default">Qty</span>
                                                        <input type="text" class="form-control mt-2 qty col-md-auto"
                                                            aria-label="Sizing example input" oninput="makeNegative(this)"
                                                            aria-describedby="inputGroup-sizing-default" id="qty"
                                                            name="qty[]">
                                                        @error('qty.*')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <span class="input-group-text mt-2 col-md-auto"
                                                            id="inputGroup-sizing-default">Desc</span>
                                                        <input type="text" class="form-control mt-2 qty col-md-auto"
                                                            aria-label="Sizing example input"
                                                            aria-describedby="inputGroup-sizing-default" id="desc"
                                                            name="desc[]">
                                                        @error('desc.*')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </td>
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fa fa-trash-o"></i></a></td>
                </tr>`);

            // Append the new row to the table
            $("#tableBill tbody").append(newRow);
            // Initialize the newly added select input as a multiple select box
            $('#item' + rowIdx).select2();
            $('#departments' + rowIdx).select2();
        });

        $("#tableBill tbody").on("click", ".remove", function() {
            // Getting all the rows next to the row
            // containing the clicked button
            var child = $(this).closest("tr").nextAll();
            // Iterating across all the rows
            // obtained to change the index
            child.each(function() {
                // Getting <tr> id.
                var id = $(this).attr("id");

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children(".row-index").children("p");

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`${dig - 1}`);

                // Modifying row id.
                $(this).attr("id", `R${dig - 1}`);
            });

            // Removing the current row.
            $(this).closest("tr").remove();

            // Decreasing total number of rows by 1.
            rowIdx--;
        });
    </script>
    <script>
        // ฟังก์ชันที่ใช้เพื่อทำให้ค่าเป็นลบ
        function makeNegative(input) {
            // แปลงค่าที่ป้อนเข้ามาเป็นตัวเลข
            var value = parseFloat(input.value);

            // ตรวจสอบว่าค่าที่ป้อนมีค่ามากกว่า 0 หรือไม่
            if (value > 0) {
                // ทำให้เป็นลบ
                input.value = -value;
            }
        }
    </script>
@endsection
@endsection
