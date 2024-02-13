<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use DB;
use DateTime;

class BookingController extends Controller
{
    // Admin View
    public function AllBooking(){
        $allbooking = Booking::with(['user', 'room'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('backend.booking.booking_list',compact('allbooking'));
    }

    public function UpdateBooking($id, $status){
        $booking = Booking::find($id);
        $booking->status = $status;
        $booking->save();

        $notification = array(
            'message' => 'Booking Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.booking')->with($notification);
    }

    public function DeleteBooking($id){
        $booking = Booking::find($id);

        if (!is_null($booking)) {
            $booking->delete();
        }

        $notification = array(
            'message' => 'Booking Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function BookingCalendar(){
        $bookings = Booking::select('id', 'room_id as resourceId', 'title', 'start_at AS start', 'end_at AS end', 'repeat')
                            ->where('status', '1')
                            ->whereDate('start_at', \DB::raw('CURDATE()'))
                            ->get();
        $rooms = Room::select('id', 'name as title')
                        ->orderBy('type')
                        ->get();

        return view('backend.booking.booking_calendar', ['bookings'=>$bookings, 'rooms'=>$rooms]);
    }

    // User View
    public function UserBookList(){
        $id = Auth::user()->id;
        $allBooking = Booking::with(['user', 'room'])
                        ->where("user_id", $id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('frontend.dashboard.user_booking',compact('allBooking'));
    }

    public function Book(){
        $rooms = Room::where('type', 'meeting')->get();
        return view('frontend.book.book', compact('rooms'));
    }

    public function BookStore(Request $request){

        $request->validate([
            'room' => 'required',
            'date' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'name' => 'required',
            'number' => 'required',
            'email' => 'required',
            'title' => 'required',
            'reason' => 'required',
        ]);

        $start_at = $this->createDateTime($request->date, $request->start_at);
        $end_at = $this->createDateTime($request->date, $request->end_at);

        $startTimeObj = new DateTime($start_at);
        $endTimeObj = new DateTime($end_at);
        $currentDateTime = new DateTime();
        $timeDifference = $startTimeObj->getTimestamp() -$currentDateTime->getTimestamp();


        // end_at > start_at
        if($startTimeObj->getTimestamp() >= $endTimeObj->getTimestamp()) {
            $notification = array(
                'message' => 'The end time must be later than the start time.',
                'alert-type' => 'warning'
            );
            return redirect()->route('book')->with($notification)->withInput();
        }


        // before 24 hours
        if($timeDifference < 86400) {
            $notification = array(
                'message' => 'Booking must be made one day in advance.',
                'alert-type' => 'warning'
            );

            return redirect()->route('book')->with($notification)->withInput();
        }

        // overlapping
        if($request->repeat == "none") {
            $overlappingBookings = Booking::findOverlappingBookings(
                $start_at,
                $end_at
            );

            if(!empty($overlappingBookings)) {
                $notification = array(
                    'message' => 'There are overlapping bookings.',
                    'alert-type' => 'warning'
                );

                return redirect()->route('book')->with($notification)->withInput();
            }
        }else {

        }


        $book = new Booking();
        $book->room_id = $request->room;
        $book->start_at = $start_at;
        $book->end_at = $end_at;
        $book->repeat = $request->repeat;
        $book->name = $request->name;
        $book->contact_number = $request->number;
        $book->email = $request->email;
        $book->title = $request->title;
        $book->reason = $request->reason;
        $book->user_id = Auth::user()->id;
        $book->status = 1;
        $book->save();

        $notification = array(
            'message' => 'Book Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.book')->with($notification);
    }

    public function createDateTime($date, $time) {
        $datetime_str = $date . ' ' . $time;
        $timestamp = strtotime($datetime_str);

        $datetime = new DateTime();
        $datetime->setTimestamp($timestamp);

        return $datetime->format('Y-m-d H:i:s');
    }

    public function CancelBooking($id){
        $booking = Booking::where("user_id", Auth::user()->id)->find($id);
        $booking->status = 2;
        $booking->save();

        $notification = array(
            'message' => 'Booking Status Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.book')->with($notification);
    }

}
