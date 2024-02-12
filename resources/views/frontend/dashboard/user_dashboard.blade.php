@extends('frontend.main_master')
@section('main')

<div class="service-details-area pt-45">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.dashboard.user_menu')
            </div>

            <div class="col-lg-9">
                <div class="service-article">

                    <div class="service-article-title">
                        <h2>User Dashboard </h2>
                    </div>

                    <div class="service-article-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                                    <div class="card-header">Total Booking</div>
                                    <div class="card-body">
                                        <h1 class="card-title" style="font-size: 25px;">{{$bookingCount}} Total</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
