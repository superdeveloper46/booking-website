@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Room</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.room') }}" class="btn btn-primary px-5">Add Room </a>
            </div>
        </div>
    </div>

    <hr/>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Room Name </th>
                            <th>Room Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($allroom as $key=> $item )
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <td>
                                <a href="{{ route('edit.room',$item->id) }}" class="btn btn-outline-warning radius-30" title="Edit"><i class="bx bx-edit me-0"></i></a>
                                <a href="{{ route('delete.room',$item->id) }}" class="btn btn-outline-danger radius-30" title="Delete" id="delete"><i class="bx bx-trash me-0"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection
