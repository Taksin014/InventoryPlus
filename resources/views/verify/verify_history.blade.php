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
            <!-- /Search Filter -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                                @if ($items->verify == 'Verified' || $items->verify == 'Failed')
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
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
                                                @elseif($items->verify == 'Verified') bg-inverse-success @else bg-inverse-danger @endif">
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
                                                                                <input class="form-control" type="text"
                                                                                    readonly
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
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ old('department', $items->department) }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Qty</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="qty" name="qty" readonly
                                                                                    value="{{ $items->qty }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Desc</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="desc" name="desc" readonly
                                                                                    value="{{ $items->desc }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <option selected>
                                                                                    Reasons
                                                                                </option>
                                                                                <input class="form-control" type="text"
                                                                                    id="reason_code" name="reason_code" readonly
                                                                                    value="{{ $items->reason_code }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <option selected>-</option>
                                                                            <input class="form-control" type="text"
                                                                                id="segment_desc{{ $items->bill_line_id }}"
                                                                                name="segment_desc" readonly
                                                                                value="segment_desc">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <option
                                                                                    selected>Charge
                                                                                    account
                                                                                </option>
                                                                                <input class="form-control" type="text"
                                                                                    id="segment{{ $items->bill_line_id }}"
                                                                                    name="segment" readonly value="{{ $items->segment }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <input class="form-control" type="text"
                                                                                    id="acc_desc{{ $items->bill_line_id }}"
                                                                                    name="acc_desc" readonly value="{{ $items->acc_desc }}">
                                                                            </div>
                                                                        </div>
                                                                        </div>
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
