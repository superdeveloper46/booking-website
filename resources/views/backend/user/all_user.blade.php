@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All User</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.user') }}" class="btn btn-primary px-5">Add User </a>
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
                            <th>No</th>
                            <th>Image </th>
                            <th>Name </th>
                            <th>Email </th>
                            <th>Phone </th>
                            <th>Role </th>
                            <th>Book Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($alluser as $key=> $item )
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td> <img src="{{ (!empty($item->photo)) ? url('upload/admin_images/'.$item->photo) : url('upload/no_image.png') }}" alt="" style="width: 70px; height:40px;"> </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <span class="badge badge-pill {{$item->role=='admin'?'bg-danger': 'bg-primary'}}">{{ $item->role }}</span>
                            </td>
                            <td>
                                @if($item->can_book == 'yes')
                                    <i class="bx bx-check font-22 text-success text-"></i>
                                @else
                                    <i class="bx bx-x font-22 text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('update.bookPermission',['id'=> $item->id, 'value'=>$item->can_book == 'yes'? 'no': 'yes']) }}" class="btn btn-outline-primary radius-30" title="Book Permission"><i class="bx {{$item->can_book == 'no'? 'bx-book-add' : 'bx-block'}} me-0"></i></a>
                                <a href="{{ route('edit.user',$item->id) }}" class="btn btn-outline-warning radius-30" title="Edit"><i class="bx bx-edit me-0"></i></a>
                                <a href="{{ route('delete.user',$item->id) }}" class="btn btn-outline-danger radius-30" title="Delete" id="delete"><i class="bx bx-trash me-0"></i></a>
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
