@extends('frontend.main_master')
@section('main')

<style>
    .nice-select ul {
        height: 280px;
        overflow: auto !important;
    }
</style>

<div class="service-details-area pt-45">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="service-article">
                    <section class="checkout-area">
                        <div class="">
                            <form action="{{ route('book.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-details">
                                            <h3 class="title">Book Details</h3>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Room <span class="required">*</span></label>
                                                        <div class="select-box">
                                                            <select name="room" value="{{ old('room') }}" class="form-control">
                                                                @foreach ($rooms as $room)
                                                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('room')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Book Date <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input id="datetimepicker" type="text" name="date" value="{{ old('date') }}" class="form-control">
                                                            <span class="input-group-addon"></span>
                                                            @error('date')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3">
                                                    <div class="form-group">
                                                        <label>Start <span class="required">*</span></label>
                                                        <div class="select-box">
                                                            <select name="start_at" value="{{ old('start_at') }}" class="form-control">
                                                                @for ($i=1; $i<=12; $i++)
                                                                    <option value="{{ $i }}:00 AM">{{ $i }}:00 AM</option>
                                                                    <option value="{{ $i }}:30 AM">{{ $i }}:30 AM</option>
                                                                @endfor
                                                                @for ($i=1; $i<=12; $i++)
                                                                    <option value="{{ $i }}:00 PM">{{ $i }}:00 PM</option>
                                                                    <option value="{{ $i }}:30 PM">{{ $i }}:30 PM</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3">
                                                    <div class="form-group">
                                                        <label>End <span class="required">*</span></label>
                                                        <div class="select-box">
                                                            <select name="end_at" value="{{ old('end_at') }}" class="form-control">
                                                                @for ($i=1; $i<=12; $i++)
                                                                    <option value="{{ $i }}:00 AM">{{ $i }}:00 AM</option>
                                                                    <option value="{{ $i }}:30 AM">{{ $i }}:30 AM</option>
                                                                @endfor
                                                                @for ($i=1; $i<=12; $i++)
                                                                    <option value="{{ $i }}:00 PM">{{ $i }}:00 PM</option>
                                                                    <option value="{{ $i }}:30 PM">{{ $i }}:30 PM</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Repeat</label>
                                                        <div class="select-box">
                                                            <select name="repeat" value="{{ old('repeat') }}" class="form-control">
                                                                <option value="none">None</option>
                                                                <option value="daily">Daily</option>
                                                                <option value="weekly">Weekly</option>
                                                                <option value="monthly">Monthly</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Name <span class="required">*</span></label>
                                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Phone <span class="required">*</span></label>
                                                        <input type="text" name="number" value="{{ old('number') }}" class="form-control">
                                                        @error('phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Email <span class="required">*</span></label>
                                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Title <span class="required">*</span></label>
                                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Reason <span class="required">*</span></label>
                                                        <textarea class="form-control" style="height: 100px" name="reason" value="{{ old('reason') }}" rows="15"></textarea>
                                                        @error('reason')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12">
                                                    <button type="submit" class="w-100 btn btn-danger">Book Now</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
