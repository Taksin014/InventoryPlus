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
                        <h3 class="page-title">Permission</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Permission</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

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
                                    @if ($item->user_id == Auth::user()->user_id)
                                        @if ($item->state == 'Pending')
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td hidden class="bill_id">{{ $item->bill_id }}</td>
                                                <td hidden class="bill_number">{{ $item->bill_number }}</td>
                                                <td hidden class="requester">{{ $item->requester }}</td>
                                                <td hidden class="company">{{ $item->company }}</td>
                                                <td hidden class="bill_date">{{ $item->bill_date }}</td>
                                                <td hidden class="state">{{ $item->state }}</td>
                                                <td class="bill_number"><a>{{ $item->bill_number }}</a></td>
                                                <td class="requester">{{ $item->requester }}</td>
                                                <td class="age_id">{{ $item->age_name }}</td>
                                                <td>{{ date('d F, Y', strtotime($item->bill_date)) }}</td>
                                                <td>
                                                    <span id="status-badge"
                                                        class="badge @if ($item->state == 'Pending') bg-inverse-primary 
                                                @elseif($item->state == 'Approver') bg-inverse-success @else bg-inverse-danger @endif">
                                                        {{ $item->state }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <button type="button" class="btn btn-primary documentModal"
                                                        data-toggle="modal"
                                                        data-target="#documentModal{{ $item->bill_number }}">
                                                        ดูรายละเอียด
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                    <!-- Modal -->
                                    <div id="documentModal{{ $item->bill_number }}" class="modal custom-modal fade"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content" id="modalContent{{ $item->bill_number }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $item->bill_number }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('form/approver/update') }}" method="POST">
                                                        <input class="form-control" type="hidden" id="bill_id"
                                                            name="bill_id" value="{{ $item->bill_id }}">
                                                        <input class="form-control" type="hidden" id="bill_number"
                                                            name="bill_number" value="{{ $item->bill_number }}">
                                                        @csrf
                                                        <div class="row">
                                                            @foreach ($billJoin as $key => $items)
                                                                @if ($items->bill_number == $item->bill_number)
                                                                    <input type="hidden" name="bill_adds[]"
                                                                        value="{{ $items->bill_line_id }}">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Item
                                                                                Name</label>
                                                                            <input class="form-control" type="text"
                                                                                id="item_id" name="item_id[]" readonly
                                                                                value="{{ old('item_id', $items->item_id ?? $items->item_name) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Department</label>
                                                                            <input class="form-control" type="text"
                                                                                id="depart_id" name="depart_id[]" readonly
                                                                                value="{{ old('depart_id', $items->depart_id ?? $items->department) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Qty</label>
                                                                            <input class="form-control" type="text"
                                                                                id="qty" name="qty[]" readonly
                                                                                value="{{ $items->qty }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Desc</label>
                                                                            <input class="form-control" type="text"
                                                                                id="desc" name="desc[]" readonly
                                                                                value="{{ $items->desc }}">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="submit-section">
                                                            <button type="submit"type="hidden" id="state"
                                                                name="state" value="Approver"
                                                                class="btn btn-success submit-btn">อนุมัติ</button>
                                                            <button type="submit"type="hidden" id="state"
                                                                name="state" value="Rejected"
                                                                class="btn btn-primary submit-btn">ไม่อนุมัติ</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <!-- Modal -->
    {{-- <div id="documentModal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <form action="{{ route('form/approver/update') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="e_id_{{ $item->id }}" name="id">
                                {{ $item->bill_number }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" class="form-control" id="e_id_{{ $item->id }}" name="id"
                            value="{{ $item->id }}">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="e_id_hidden" name="id" value="">
                            <div class="row">
                                @foreach ($billJoin as $itemKey => $billItem)
                                    @if ($billItem->bill_number == $item->bill_number)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Item Name</label>
                                                <select class="select @error('item_id') is-invalid @enderror"
                                                    name="item_id">
                                                    <option value="{{ $billItem->item_id }}"
                                                        {{ old('item_id') == $billItem->item_id ? 'selected' : '' }}>
                                                        {{ $billItem->item_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Qty</label>
                                                <input class="form-control" type="text" id="e_qty" name="qty"
                                                    value="{{ $billItem->qty }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">ompany</label>
                                                <input class="form-control " type="text" name="company"
                                                    id="e_company" value="" readonly>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Qty</label>
                                        <input class="form-control" type="text" id="e_qty" name="qty">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Desc</label>
                                        <input class="form-control" type="text" id="e_desc" name="desc">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success submit-btn">อนุมัติ</button>
                                <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal"
                                    onclick="rejectBill('{{ $item->bill_number }}')">ไม่อนุมัติ</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div> --}}

    <!-- /Page Wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@section('script')
    {{-- update --}}

    <script>
        function rejectBill(bill_number) {
            console.log('Rejecting bill with number:', bill_number);
            // ทำ AJAX request ไปยัง backend เพื่อไม่อนุมัติ
            $.ajax({
                url: '/reject-bill/' + bill_number,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log('บิลถูกปฏิเสธเรียบร้อยแล้ว');
                    location.reload();
                },
                error: function(error) {
                    console.log('เกิดข้อผิดพลาด: ' + error.responseJSON.error);
                }
            });
        }

        $(document).ready(function() {
            // เพิ่ม Event Listener สำหรับทุกรายการที่มี class "documentModal"
            $('.documentModal').click(function() {
                // ดึงค่า bill_number จาก data attribute
                var billNumber = $(this).data('bill_number');

                // ทำ Ajax request เพื่อดึงข้อมูลจากตารางอื่นๆ โดยใช้ billNumber
                $.ajax({
                    url: '/approver/view/' + bill_number, // เปลี่ยน URL ตามที่เหมาะสม
                    type: 'GET',
                    data: {
                        bill_number: billNumber
                    },
                    success: function(data) {
                        // แสดงข้อมูลใน Modal
                        $('#modalContent' +
                            billNumber).html(data);

                        // เปิด Modal
                        $('#documentModal' +
                            billNumber).css('display', 'block');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // เพิ่ม Event Listener สำหรับปิด Modal
            $('.close').click(function() {
                var billNumber = $(this).data('bill_number');
                $('#documentModal' + billNumber).css('display', 'none');
            });
        });
    </script>
@endsection
@endsection
