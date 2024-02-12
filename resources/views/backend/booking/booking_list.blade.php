@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
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
                            <th>Booking Date</th>
                            <th>Title</th>
                            <th>Room</th>
                            <th>Booking IN/Out</th>
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
                            <td> <span class="badge bg-primary">{{ $item->start_at }}</span> <br> <span class="badge bg-warning text-dark">{{ $item->end_at }}</span> </td>
                            <td> {{ $item->repeat }} </td>
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
