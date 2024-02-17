@extends('frontend.main_master')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<style>
    @media only screen and (max-width: 600px) {
        .cancel-booking {
            display: none;
        }
    }
</style>

<div class="service-details-area pt-45">
    <div class="container">
        <div class="row">
             <div class="col-lg-3">
                @include('frontend.dashboard.user_menu')
            </div>

            <div class="col-lg-9">
                <div class="service-article">
                    <section n class="checkout-area">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <h3 class="title">User Booking List  </h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Room</th>
                                                <th scope="col">Start/End</th>
                                                <th scope="col">Repeat</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allBooking as $key=> $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{date('Y-m-d', strtotime($item->created_at))}}</td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['room']['name'] }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ substr($item->start_at, 0, 16) }} ~ {{substr($item->end_at, 11, 5)}}</span>
                                                    </td>
                                                    <td>
                                                        {{ucfirst($item->repeat)}}
                                                    </td>
                                                    <td>
                                                        @if ($item->status == '1')
                                                            <span class="text-success">Active</span>
                                                        @elseif ($item->status == '2')
                                                            <span class="text-danger">Cancel</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status != '2')
                                                            <a href="{{ route('book.cancel', $item->id) }}" class="btn btn-outline-danger radius-30" title="Cancel Booking" id="cancel"><i class="bx bx-trash me-0"></i> <span class="cancel-booking">Cancel</span></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
