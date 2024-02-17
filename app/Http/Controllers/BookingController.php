<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use DB;
use DateTime;


use App\Mail\BookNotification;
use Illuminate\Support\Facades\Mail;

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
        $currentYear = now()->year;
        $bookings = Booking::selectRaw('`bookings`.id, room_id as `resourceId`, `title`, `repeat`, start_at AS `start`, end_at AS `end`, `repeat`, `freq`, `interval`, `until`, `count`, `byweekday`, `bysetpos`, `bymonthday`')
                            ->where('status', '1')
                            ->whereYear('start_at', $currentYear)
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
        $roomType = 'meeting';
        if(Auth::user()->role == 'user') {
            $roomType = 'meeting';
        }else {
            $roomType = 'scholar';
        }

        $currentYear = now()->year;
        $bookings = Booking::leftJoin('rooms', 'bookings.room_id', '=', 'rooms.id')
                            ->selectRaw('`bookings`.id, room_id as `resourceId`, `title`, `repeat`, start_at AS `start`, end_at AS `end`, `repeat`, `freq`, `interval`, `until`, `count`, `byweekday`, `bysetpos`, `bymonthday`')
                            ->where('status', '1')
                            ->where('rooms.type', $roomType)
                            ->whereYear('start_at', $currentYear)
                            ->get();
        $rooms = Room::select('id', 'name', 'name as title')
                        ->where('type', $roomType)
                        ->orderBy('type')
                        ->get();
        return view('frontend.book.book', ['bookings'=>$bookings, 'rooms'=>$rooms]);
    }

    public function BookStore(Request $request){
        if(Auth::user()->can_book == 'no') {
            $notification = array(
                'message' => "You don't have permission to book. Please contact your administrator.",
                'alert-type' => 'warning'
            );

            return redirect()->route('book')->with($notification)->withInput();
        }

        $start_at = $this->createDateTime($request->date, $request->start_at);
        $end_at = $this->createDateTime($request->date, $request->end_at);

        $startTimeObj = new DateTime($start_at);
        $endTimeObj = new DateTime($end_at);
        $currentDateTime = new DateTime();
        $timeDifference = $startTimeObj->getTimestamp() -$currentDateTime->getTimestamp();

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

        // Repeat part
        if($request->repeat != 'none') {
            $book->freq = strstr($request->repeat, "monthly") ? "monthly": $request->repeat;
            $book->interval = $request->interval;

            if($request->rend == 'until') {
                $book->until = $request->until;
            }
            if($request->rend == 'count') {
                $book->count = $request->count;
            }

            $weekdays = ['su', 'mo', 'tu', 'we', 'th', 'fr', 'sa'];
            $byweekday = "";
            foreach ($weekdays as $weekday) {
                if (isset($request->$weekday)) {
                    $byweekday .= $request->$weekday . ",";
                }
            }
            $book->byweekday = rtrim($byweekday, ",");

            if(isset($request->byweekday)) {
                $book->byweekday = $request->byweekday;
            }
            if(isset($request->bymonthday)) {
                $book->bymonthday = $request->bymonthday;
            }
            if(isset($request->bysetpos)) {
                $book->bysetpos = $request->bysetpos;
            }
        }

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
