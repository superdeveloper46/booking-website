@extends('frontend.main_master')
@section('main')

<script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@6.1.10/index.global.min.js'></script>

<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/book.css') }}">

<div class="service-details-area pt-45">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div id="calendar" style="height: 100px"></div>
            </div>
            <div class="col-xl-12">
                <div class="service-article">
                    <section class="checkout-area">
                        <form action="{{ route('book.store') }}" id="buyForm" method="post" enctype="multipart/form-data">
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
                                                        <select name="room" class="form-control">
                                                            @foreach ($rooms as $room)
                                                                <option value="{{$room->id}}">{{ $room->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Book Date <span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="date" value="{{ date("Y-m-d") }}" class="datetimepicker form-control">
                                                        <span class="input-group-addon"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Start <span class="required">*</span></label>
                                                    <div class="select-box">
                                                        <select name="start_at" class="form-control">
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
                                                        <select name="end_at" class="form-control">
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

                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Repeat</label>
                                                    <div class="select-box">
                                                        <select name="repeat" onchange="viewRepeatDetails()" class="form-control">
                                                            <option value="none">None</option>
                                                            <option value="daily">Daily</option>
                                                            <option value="weekly">Weekly</option>
                                                            <option value="monthly by days in month">Monthly By Days In Month</option>
                                                            <option value="monthly by days in week">Monthly By Days In Week</option>
                                                            <option value="yearly">Yearly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="repeat-wrapper" class="col-lg-12 col-md-12" style="display: none">
                                                <div class="repeat-container">
                                                    <div class="form-container">
                                                        <div>
                                                            <label class="title-label" >Interval</label>
                                                        </div>
                                                        <div>
                                                            <input type="number" class="form-control" value="1" name="interval">
                                                        </div>
                                                    </div>
                                                    <div id="by-container" class="form-container">
                                                    </div>
                                                    <hr>
                                                    <div class="end-container">
                                                        <div>
                                                            <input type="radio" checked class="form-check-input" id="never" value="never" name='rend'>
                                                        </div>
                                                        <div>
                                                            <label for="never">Never</label>
                                                        </div>
                                                    </div>
                                                    <div class="end-container">
                                                        <div>
                                                            <input type="radio" class="form-check-input" id="until" value="until" name='rend'>
                                                        </div>
                                                        <div>
                                                            <label for="until">Repeat Until</label>
                                                        </div>
                                                        <div>
                                                            <input type="text" disabled class="datetimepicker form-control" value="{{date('Y-m-d', strtotime('+1 year', strtotime(date('Y-m-d'))))}}" name="until">
                                                        </div>
                                                    </div>
                                                    <div class="end-container">
                                                        <div>
                                                            <input type="radio" class="form-check-input" id="count" value="count" name='rend'>
                                                        </div>
                                                        <div>
                                                            <label for="count">Occurence Count</label>
                                                        </div>
                                                        <div>
                                                            <input type="number" value="1" disabled class="form-control" name="count">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Name <span class="required">*</span></label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Phone <span class="required">*</span></label>
                                                    <input type="text" name="number" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Email <span class="required">*</span></label>
                                                    <input type="email" name="email" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Title <span class="required">*</span></label>
                                                    <input type="text" name="title" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Reason <span class="required">*</span></label>
                                                    <textarea class="form-control" style="height: 100px" name="reason" rows="15"></textarea>
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
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var bookings = @json($bookings);
    var rooms = @json($rooms);
    var current_date = "<?php echo date("Y-m-d"); ?>";
</script>
<script src="{{ asset('frontend/assets/js/pages/book.js') }}"></script>

@endsection
