@extends('admin.admin_dashboard')
@section('admin')

<style>
    #booking_detail_modal i {
        color: #008cff!important;
        font-size: 22px;
    }

    #booking_detail_modal .detail_row {
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 10px;
        padding-top: 10px;
    }


    #booking_detail_modal span {
        font-size: 16px;
    }
</style>

<div class="page-content">
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Booking</li>
                </ol>
            </nav>
        </div>
    </div>

    <hr/>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Room</th>
                            <th>Start/End</th>
                            <th>Repeat</th>
                            <th>User</th>
                            <th>Email</th>
                            {{-- <th>Reason</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($allbooking as $key=> $item )
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td> {{ date('Y-m-d', strtotime($item->created_at)) }} </td>
                            <td> {{ $item->title}} </td>
                            <td> {{ $item->room->name}} </td>
                            <td>
                                <span class="badge bg-primary">{{ substr($item->start_at, 0, 16) }} ~ {{substr($item->end_at, 11, 5)}}</span>
                            </td>
                            <td> {{ ucfirst($item->repeat) }} </td>
                            <td> {{ $item->name }} </td>
                            <td> {{ $item->email }} </td>
                            {{-- <td> {{ $item->reason }} </td> --}}
                            <td>
                                @if ($item->status == '1')
                                    <span class="text-success">Active</span>
                                @elseif ($item->status == '2')
                                    <span class="text-danger">Cancel</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('delete.booking', $item->id) }}" class="btn btn-outline-danger radius-30" title="Delete" id="delete"><i class="bx bx-trash me-0"></i></a>
                                <a class="btn btn-outline-info radius-30" title="View Detail" onclick="viewDetail({{$item->id}}, 'list')"><i class="bx bx-detail me-0"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr/>

</div>

@endsection
