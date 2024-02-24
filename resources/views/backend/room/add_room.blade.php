@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Room </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Room</li>
                </ol>
            </nav>
        </div>

    </div>
    <div class="container">
        <div class="main-body">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body p-4">

                            <form  class="row g-3" action="{{ route('store.room') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Room Name </label>
                                    <input type="text" name="name" class="form-control"   >
                                </div>

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Room Type </label>
                                    <select name="type" class="form-select mb-3">
                                        <option value="meeting">Meeting Room</option>
                                        <option value="scholar">Scholar Room</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
