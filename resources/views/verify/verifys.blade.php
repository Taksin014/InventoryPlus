@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Verify</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Verify</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            {{-- <form action="{{ route('expenses/search') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating">
                                <option>Select Status</option>
                                <option>Accepted</option>
                                <option>Declined</option>
                                <option>Pending</option>
                            </select>
                            <label class="focus-label">Status</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="#" class="btn btn-success btn-block"> Search </a>
                    </div>
                </div>
            </form> --}}


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable mb-0">
                            <thead>
                                <tr>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th hidden></th>
                                    <th>Bill number</th>
                                    <th>Name</th>
                                    <th>Agencies</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $key => $item)
                                    @if (Auth::check() && Auth::user()->role_name == 'Employee')
                                        @foreach ($billJoin as $key => $items)
                                            @if ($items->bill_number == $item->bill_number)
                                                @if ($items->state == 'Approver' && $items->verify != 'Verified' && $items->verify != 'Failed')
                                                    <tr>
                                                        <td hidden class="bill_line_id">{{ $items->bill_line_id }}</td>
                                                        <td hidden class="bill_number">{{ $items->bill_number }}</td>
                                                        <td hidden class="requester">{{ $item->requester }}</td>
                                                        <td hidden class="company">{{ $item->company }}</td>
                                                        <td hidden class="bill_date">{{ $item->bill_date }}</td>
                                                        <td hidden class="state">{{ $items->state }}</td>
                                                        <td hidden class="verify">{{ $items->verify }}</td>
                                                        <td hidden class="investor">{{ $items->investor }}</td>
                                                        <td hidden class="dispense">{{ $items->dispense }}</td>
                                                        <td hidden class="receiver">{{ $items->receiver }}</td>
                                                        <td class="bill_number"><a>{{ $items->bill_number }}</a></td>
                                                        <td class="requester">{{ $item->requester }}</td>
                                                        <td class="age_id">{{ $item->age_name }}</td>
                                                        <td>{{ date('d F, Y', strtotime($item->bill_date)) }}</td>
                                                        <td>
                                                            <span id="status-badge"
                                                                class="badge @if ($items->verify == 'Pending') bg-inverse-warning 
                                                    @else bg-inverse-default @endif">
                                                                {{ $items->verify }}
                                                            </span>
                                                        </td>
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#documentModal{{ $items->bill_line_id }}">
                                                                ดูรายละเอียด
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div id="documentModal{{ $items->bill_line_id }}"
                                                        class="modal custom-modal fade" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content"
                                                                id="modalContent{{ $items->bill_line_id }}">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $items->bill_number }}</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('form/verify/update') }}"
                                                                        method="POST">
                                                                        <input type="hidden" name="bill_line_id"
                                                                            value="{{ $items->bill_line_id }}">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Item
                                                                                        Name</label>
                                                                                    <input hidden class="form-control"
                                                                                        type="text" id="item_id"
                                                                                        name="item_id" readonly
                                                                                        value="{{ old('item_id', $items->item_id) }}">
                                                                                    <input class="form-control"
                                                                                        type="text" readonly
                                                                                        value="{{ old('item_id', $items->item_name ?? $items->item_id) }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="col-form-label">Department</label>
                                                                                    <input hidden class="form-control"
                                                                                        type="text" id="depart_id"
                                                                                        name="depart_id" readonly
                                                                                        value="{{ old('depart_id', $items->depart_id) }}">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        value="{{ old('department', $items->department) }}"
                                                                                        readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="col-form-label">Qty</label>
                                                                                    <input class="form-control"
                                                                                        type="text" id="qty"
                                                                                        name="qty" readonly
                                                                                        value="{{ $items->qty }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="col-form-label">Desc</label>
                                                                                    <input class="form-control"
                                                                                        type="text" id="desc"
                                                                                        name="desc" readonly
                                                                                        value="{{ $items->desc }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-2 col-sm-2">
                                                                                <div class="form-group">
                                                                                    <option
                                                                                        for="UOM{{ $items->bill_line_id }}"
                                                                                        selected>
                                                                                        UOM
                                                                                    </option>
                                                                                    <input class="form-control"
                                                                                        type="text" id="UOM"
                                                                                        name="UOM" readonly
                                                                                        value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-7 col-sm-7">
                                                                                <div class="form-group">
                                                                                    <option
                                                                                        for="location{{ $items->bill_line_id }}"
                                                                                        selected>Location
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="location{{ $items->bill_line_id }}"
                                                                                        name="location">
                                                                                        <option value="" disabled
                                                                                            selected>Select Location
                                                                                        </option>
                                                                                        {{-- @foreach ($accounts as $key => $acc)
                                                                                            <option
                                                                                                value="{{ $acc->SEGMENT5 }}"
                                                                                                {{ old('SEGMENT5') == $acc->SEGMENT5 ? 'selected' : '' }}>
                                                                                                {{ $acc->SEGMENT5 }}
                                                                                            </option>
                                                                                        @endforeach --}}
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 col-sm-3">
                                                                                <div class="form-group">
                                                                                    <option for="machine" selected>Machine
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="machine{{ $items->bill_line_id }}"
                                                                                        name="machine">
                                                                                        <option value="" disabled
                                                                                            selected>Select Machine
                                                                                        </option>
                                                                                        {{-- @foreach ($accounts as $key => $acc)
                                                                                            <option
                                                                                                value="{{ $acc->SEGMENT6 }}"
                                                                                                {{ old('SEGMENT6') == $acc->SEGMENT6 ? 'selected' : '' }}>
                                                                                                {{ $acc->SEGMENT6 }}
                                                                                            </option>
                                                                                        @endforeach --}}
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <option selected
                                                                                        for="reason_code{{ $items->bill_line_id }}">
                                                                                        Reasons
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="reason_code{{ $items->bill_line_id }}"
                                                                                        name="reason_code">
                                                                                        <option value="" disabled
                                                                                            selected>Select Reasons
                                                                                        </option>
                                                                                        @foreach ($reasons as $key => $reason)
                                                                                            <option
                                                                                                value="{{ $reason->reason_code }}"
                                                                                                {{ old('reason_code') == $reason->reason_code ? 'selected' : '' }}>
                                                                                                {{ $reason->reason_code }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <option selected>-</option>
                                                                                <input class="form-control" type="text"
                                                                                    id="segment_desc{{ $items->bill_line_id }}"
                                                                                    name="segment_desc" readonly
                                                                                    value="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-4 col-sm-4">
                                                                                <div class="form-group">
                                                                                    <option
                                                                                        for="SEGMENT4{{ $items->bill_line_id }}"
                                                                                        selected>Charge
                                                                                        account
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="SEGMENT4{{ $items->bill_line_id }}"
                                                                                        name="SEGMENT4">
                                                                                        <option value="" disabled
                                                                                            selected>Select Segment
                                                                                        </option>
                                                                                        @foreach ($accounts as $key => $acc)
                                                                                            <option
                                                                                                value="{{ $acc->SEGMENT4 }}"
                                                                                                {{ old('SEGMENT4') == $acc->SEGMENT4 ? 'selected' : '' }}>
                                                                                                {{ $acc->SEGMENT4 }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-4">
                                                                                <div class="form-group">
                                                                                    <option
                                                                                        for="SEGMENT5{{ $items->bill_line_id }}"
                                                                                        selected>-
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="SEGMENT5{{ $items->bill_line_id }}"
                                                                                        name="SEGMENT5">
                                                                                        <option value="" disabled
                                                                                            selected>Select Segment
                                                                                        </option>
                                                                                        @foreach ($accounts as $key => $acc)
                                                                                            <option
                                                                                                value="{{ $acc->SEGMENT5 }}"
                                                                                                {{ old('SEGMENT5') == $acc->SEGMENT5 ? 'selected' : '' }}>
                                                                                                {{ $acc->SEGMENT5 }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-sm-4">
                                                                                <div class="form-group">
                                                                                    <option for="SEGMENT6" selected>-
                                                                                    </option>
                                                                                    <select
                                                                                        class="select2s-hidden-accessible"
                                                                                        style="width: 100%;"
                                                                                        tabindex="-1" aria-hidden="true"
                                                                                        id="SEGMENT6{{ $items->bill_line_id }}"
                                                                                        name="SEGMENT6">
                                                                                        <option value="" disabled
                                                                                            selected>Select Segment
                                                                                        </option>
                                                                                        @foreach ($accounts as $key => $acc)
                                                                                            <option
                                                                                                value="{{ $acc->SEGMENT6 }}"
                                                                                                {{ old('SEGMENT6') == $acc->SEGMENT6 ? 'selected' : '' }}>
                                                                                                {{ $acc->SEGMENT6 }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <input class="form-control"
                                                                                        type="text"
                                                                                        id="SEGMENT3{{ $items->bill_line_id }}"
                                                                                        name="SEGMENT3" readonly
                                                                                        value="0000">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <input class="form-control"
                                                                                        type="text"
                                                                                        id="SEGMENT7{{ $items->bill_line_id }}"
                                                                                        name="SEGMENT7" readonly
                                                                                        value="000">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        class="col-form-label">Desc</label>
                                                                                    <input class="form-control"
                                                                                        type="text"
                                                                                        id="segment{{ $items->bill_line_id }}"
                                                                                        name="segment" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <input class="form-control"
                                                                                        type="text"
                                                                                        id="acc_desc{{ $items->bill_line_id }}"
                                                                                        name="acc_desc" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <input class="form-control "
                                                                                        type="text"
                                                                                        id="chartpower{{ $items->bill_line_id }}"
                                                                                        name="chartpower" readonly
                                                                                        value="">
                                                                                    <input hidden class="form-control "
                                                                                        type="text"
                                                                                        id="chart{{ $items->bill_line_id }}"
                                                                                        name="chart" readonly>
                                                                                    <input hidden class="form-control"
                                                                                        type="text" id="state"
                                                                                        name="state" readonly
                                                                                        value="{{ $items->state }}">
                                                                                    <input hidden class="form-control"
                                                                                        type="text" id="bill_date"
                                                                                        name="bill_date" readonly
                                                                                        value="{{ $items->bill_date }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="submit-section">
                                                                            <button type="submit" id="verify"
                                                                                name="verify" value="Verified"
                                                                                class="btn btn-success submit-btn">Succeed</button>
                                                                            <button type="submit" id="verify"
                                                                                name="verify" value="Failed"
                                                                                class="btn btn-primary submit-btn">Fail</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal -->
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2s-hidden-accessible').select2({
                closeOnSelect: false
            });
        });
    </script>
    @foreach ($billJoin as $items)
        <script>
            $('#SEGMENT3{{ $items->bill_line_id }},#SEGMENT4{{ $items->bill_line_id }}, #SEGMENT5{{ $items->bill_line_id }}, #SEGMENT6{{ $items->bill_line_id }}, #SEGMENT7{{ $items->bill_line_id }}')
                .on('input', function() {

                    var segment3V = $('#SEGMENT3{{ $items->bill_line_id }}').val();
                    var segment4V = $('#SEGMENT4{{ $items->bill_line_id }}').val();
                    var segment5V = $('#SEGMENT5{{ $items->bill_line_id }}').val();
                    var segment6V = $('#SEGMENT6{{ $items->bill_line_id }}').val();
                    var segment7V = $('#SEGMENT7{{ $items->bill_line_id }}').val();

                    var combinedDescription = segment3V + '.' + segment4V + '.' + segment5V + '.' + segment6V + '.' +
                        segment7V;
                    $('#acc_desc{{ $items->bill_line_id }}').val(combinedDescription);
                });
        </script>


        <script>
            $(document).ready(function() {
                console.log('Document ready!');
                $('#SEGMENT3{{ $items->bill_line_id }}').on('input', function() {
                    console.log('SEGMENT3Input changed!');
                    fetchAndDisplayDescriptions();
                });

                $('#SEGMENT4{{ $items->bill_line_id }}').on('input', function() {
                    console.log('SEGMENT4 Input changed!');
                    fetchAndDisplayDescriptions();
                });

                $('#SEGMENT5{{ $items->bill_line_id }}').on('input', function() {
                    console.log('SEGMENT5 Input changed!');
                    fetchAndDisplayDescriptions();
                });

                $('#SEGMENT6{{ $items->bill_line_id }}').on('input', function() {
                    console.log('SEGMENT6 Input changed!');
                    fetchAndDisplayDescriptions();
                });

                $('#SEGMENT7{{ $items->bill_line_id }}').on('input', function() {
                    console.log('SEGMENT7 Input changed!');
                    fetchAndDisplayDescriptions();
                });

                function fetchAndDisplayDescriptions() {
                    var segment3Value = $('#SEGMENT3{{ $items->bill_line_id }}').val();
                    var segment4Value = $('#SEGMENT4{{ $items->bill_line_id }}').val();
                    var segment5Value = $('#SEGMENT5{{ $items->bill_line_id }}').val();
                    var segment6Value = $('#SEGMENT6{{ $items->bill_line_id }}').val();
                    var segment7Value = $('#SEGMENT7{{ $items->bill_line_id }}').val();

                    // Use AJAX to fetch segment descriptions from the server
                    $.ajax({
                        url: '/get-segment-desc', // replace with your actual route
                        method: 'GET',
                        data: {
                            segment3: segment3Value,
                            segment4: segment4Value,
                            segment5: segment5Value,
                            segment6: segment6Value,
                            segment7: segment7Value,
                        },
                        success: function(data) {
                            var concatenatedDesc = data.segment_desc3 + '.' + data.segment_desc4 + '.' +
                                data.segment_desc5 + '.' + data.segment_desc6 + '.' + data.segment_desc7;
                            $('#segment{{ $items->bill_line_id }}').val(concatenatedDesc);
                        },
                        error: function() {
                            // Handle error if needed
                        }
                    });
                }
            });
        </script>



        <script>
            $('#SEGMENT3{{ $items->bill_line_id }}, #SEGMENT4{{ $items->bill_line_id }}, #SEGMENT5{{ $items->bill_line_id }}, #SEGMENT6{{ $items->bill_line_id }}, #SEGMENT7{{ $items->bill_line_id }}')
                .on('input', function() {
                    var segment3 = $('#SEGMENT3{{ $items->bill_line_id }}').val();
                    var segment4 = $('#SEGMENT4{{ $items->bill_line_id }}').val();
                    var segment5 = $('#SEGMENT5{{ $items->bill_line_id }}').val();
                    var segment6 = $('#SEGMENT6{{ $items->bill_line_id }}').val();
                    var segment7 = $('#SEGMENT7{{ $items->bill_line_id }}').val();

                    $.ajax({
                        url: '/check-matching-row',
                        method: 'GET',
                        data: {
                            segment3: segment3,
                            segment4: segment4,
                            segment5: segment5,
                            segment6: segment6,
                            segment7: segment7,
                        },
                        success: function(response) {
                            if (response.chartOfAccountsId) {
                                var chartOfAccountsId = response.chartOfAccountsId;
                                $('#chart{{ $items->bill_line_id }}').val(chartOfAccountsId);
                                $('#chartpower{{ $items->bill_line_id }}').val('GL Account is valid');
                                $('#chartpower{{ $items->bill_line_id }}').css("border-color", "green");
                                $('#chartpower{{ $items->bill_line_id }}').css("color", "green");
                            } else {
                                $('#chartpower{{ $items->bill_line_id }}').val('Not found');
                                $('#chartpower{{ $items->bill_line_id }}').css("border-color", "red");
                                $('#chartpower{{ $items->bill_line_id }}').css("color", "red");

                                // You can handle this case in a way that fits your application's requirements
                            }
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });
        </script>

        <script>
            $(document).ready(function() {
                console.log('Document ready!');
                $('#reason_code{{ $items->bill_line_id }}').on('input', function() {
                    console.log('Input changed!');
                    var reason_Value = $(this).val();

                    // Use AJAX to fetch SEGMENT1_DESC from the server
                    $.ajax({
                        url: '/get-reason-name', // replace with your actual route
                        method: 'GET',
                        data: {
                            reason_code: reason_Value
                        },
                        success: function(data) {
                            // Update the value of SEGMENT_DESC input field
                            $('#segment_desc{{ $items->bill_line_id }}').val(data.reason_desc, );
                            $('#segment_desc{{ $items->bill_line_id }}').css("border-color",
                            "green");
                            $('#segment_desc{{ $items->bill_line_id }}').css("color", "green");


                        },
                        error: function() {
                            // Handle error if needed
                        }
                    });
                });
            });
        </script>
    @endforeach

    {{-- update --}}
    <script>
        $(document).ready(function() {
            $(".js-example-tags").select2({
                tags: true
            });
            $('.documentModal').click(function() {
                // ดึงค่า bill_number จาก data attribute
                var billNumber = $(this).data('bill_line_id');

                // ทำ Ajax request เพื่อดึงข้อมูลจากตารางอื่นๆ โดยใช้ billNumber
                $.ajax({
                    url: '/verify/view/' + bill_line_id, // เปลี่ยน URL ตามที่เหมาะสม
                    type: 'GET',
                    data: {
                        bill_line_id: billNumber
                    },
                    success: function(data) {
                        // แสดงข้อมูลใน Modal
                        $('#modalContent' +
                            billNumber).html(data);

                        // เปิด Modal
                        $('#documentModal' + billNumber).css('display', 'block');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            // เพิ่ม Event Listener สำหรับปิด Modal
            $('.close').click(function() {
                var billNumber = $(this).data('bill_line_id');
                $('#documentModal' + billNumber).css('display', 'none');
            });
        });
    </script>
@endsection
@endsection
