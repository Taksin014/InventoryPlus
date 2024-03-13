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
                        <h3 class="page-title">Bill</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bill</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('create/bill/page') }}" class="btn add-btn"><i class="fa fa-plus"></i> Create
                            Bill</a>
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
                                            @if ($item->acu_id == Auth::user()->id)
                                                @if ($items->state == 'Pending' && $items->dispense != 'Succeed')
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td hidden class="id">{{ $item->id }}</td>
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
                                                                class="badge @if ($items->verify == 'Pending') bg-inverse-primary 
                                                @elseif($items->verify == 'Verified') bg-inverse-success @else bg-inverse-danger @endif">
                                                                {{ $items->verify }}
                                                            </span>
                                                        </td>
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-primary edit_type"
                                                                data-toggle="modal"
                                                                data-target="#documentModal{{ $item->bill_number }}">
                                                                ดูรายละเอียด
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div id="documentModal{{ $item->bill_number }}"
                                                        class="modal custom-modal fade" role="dialog"
                                                        aria-labelledby="documentModalLabel{{ $item->bill_number }}">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <input type="hidden"
                                                                        id="documentModalLabel{{ $item->bill_number }}"
                                                                        name="bill_number"
                                                                        value="{{ $item->bill_number }}">
                                                                    <h5 class="modal-title">{{ $item->bill_number }}</h5>
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
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="col-form-label">Desc</label>
                                                                                <input class="form-control" type="text"
                                                                                    id="item_id" name="item_id" readonly
                                                                                    value="{{ $items->desc }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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

@section('script')
    {{-- delete model --}}
    <script>
        $(document).on('click', '.delete_bill', function() {
            var _this = $(this).parents('tr');
            $('.b_id').val(_this.find('.ids').text());
            $('.bill_number').val(_this.find('.bill_number').text());
        });
    </script>
@endsection
@endsection
