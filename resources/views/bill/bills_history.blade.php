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
                                    @foreach ($billJoin as $key => $items)
                                        @if ($items->bill_number == $item->bill_number)
                                            @if ($item->acu_id == Auth::user()->id)
                                                @if ($items->dispense == 'Fail' || $items->dispense == 'Succeed' || $items->verify == 'Failed')
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
                                                                class="badge 
                                                        @if ($items->verify == 'Failed' || $items->dispense == 'Fail') bg-inverse-danger
                                                        @elseif ($items->verify == 'Verified') bg-inverse-success @endif">
                                                                @if ($items->dispense == 'Fail')
                                                                    {{ $items->dispense }}
                                                                @else
                                                                    {{ $items->verify }}
                                                                @endif
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
                                            @endif
                                            <!-- Modal -->
                                            <div id="documentModal{{ $items->bill_line_id }}"
                                                class="modal custom-modal fade" role="dialog"
                                                aria-labelledby="documentModalLabel{{ $items->bill_line_id }}">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <input type="hidden"
                                                                id="documentModalLabel{{ $items->bill_line_id }}"
                                                                name="bill_number" value="{{ $items->bill_number }}">
                                                            <h5 class="modal-title">{{ $items->bill_number }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                                        <label class="col-form-label">Department</label>
                                                                        <input class="form-control" type="text"
                                                                            id="department" name="department"
                                                                            value="{{ $items->department }}" readonly>
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
                                                                            id="desc" name="desc" readonly
                                                                            value="{{ $items->desc }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
