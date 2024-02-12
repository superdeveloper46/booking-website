<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function AllRoom(){
        $allroom = Room::all();
        return view('backend.room.all_room',compact('allroom'));
    }

    public function AddRoom(){
        return view('backend.room.add_room');
    }

    public function StoreRoom(Request $request){
        $room = new Room();
        $room->name = $request->name;
        $room->type = $request->type;
        $room->save();

        $notification = array(
            'message' => 'Room Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room')->with($notification);
    }


    public function EditRoom($id){
        $room = Room::find($id);
        return view('backend.room.edit_room',compact('room'));
    }

    public function UpdateRoom(Request $request,$id){
        $room = Room::find($id);
        $room->name = $request->name;
        $room->type = $request->type;
        $room->save();

        $notification = array(
            'message' => 'Room Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room')->with($notification);
    }


    public function DeleteRoom($id){
        $room = Room::find($id);
        if (!is_null($room)) {
            $room->delete();
        }

        $notification = array(
            'message' => 'Room Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
