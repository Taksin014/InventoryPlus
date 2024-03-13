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
                        <h3 class="page-title">Dispense</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dispense</li>
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
                                <option>Succeed</option>
                                <option>Fail</option>
                                <option>Wait</option>
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
                        <table class="table table-striped custom-table mb-0 datatable" id="DataTables">
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
                                    @foreach ($billJoin as $key => $items)
                                        @if ($items->bill_number == $item->bill_number)
                                            @if (Auth::check() && Auth::user()->role_name == 'Employee')
                                                @if ($items->dispense == 'Succeed' || $items->dispense == 'Fail')
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
                                                                class="badge @if ($items->dispense == 'Wait') bg-inverse-warning 
                                            @elseif($items->dispense == 'Succeed') bg-inverse-success @else bg-inverse-danger @endif">
                                                                {{ $items->dispense }}
                                                            </span>
                                                        </td>
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-primary edit_type"
                                                                data-toggle="modal"
                                                                data-target="#documentModal{{ $items->bill_line_id }}">
                                                                ดูรายละเอียด
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <div id="documentModal{{ $items->bill_line_id }}"
                                                    class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content"
                                                            id="modalContent{{ $items->bill_line_id }}">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $items->bill_number }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('form/dispense/update') }}"
                                                                    method="POST">
                                                                    <input type="hidden" name="bill_line_id"
                                                                        value="{{ $items->bill_line_id }}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Item
                                                                                    Name</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="item_id" name="item_id" readonly
                                                                                    value="{{ $items->item_name }}">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    class="col-form-label">Department</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="department" name="department"
                                                                                    value="{{ $items->department }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Qty</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="qty" name="qty"
                                                                                    value="{{ $items->qty }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Investor
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text"
                                                                                    name="investor" id="investor" value="{{ $items->investor }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Receiver
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control "
                                                                                    type="text" name="receiver"
                                                                                    id="receiver" value="{{ $items->receiver }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="submit-section">
                                                                        <button type="submit" id="dispense"
                                                                            name="dispense" value="Succeed"
                                                                            class="btn btn-success submit-btn">Edit
                                                                            Succeed</button>
                                                                        <button type="submit" id="dispense"
                                                                            name="dispense" value="Fail"
                                                                            class="btn btn-primary submit-btn">Edit
                                                                            Fail</button>
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
                    url: '/dispense/view/' + bill_line_id, // เปลี่ยน URL ตามที่เหมาะสม
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
