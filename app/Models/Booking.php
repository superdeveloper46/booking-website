<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    protected $fillable = ['start_at', 'end_at'];

    public static function findOverlappingBookings($startTime, $endTime)
    {
        $query = "SELECT * FROM bookings WHERE status=1 AND";
        $bindings = [];

        $query .= "(";
        $query .= "(start_at >= ? AND start_at < ?) OR ";
        $query .= "(end_at > ? AND end_at <= ?) OR ";
        $query .= "(start_at < ? AND end_at > ?)";
        $query .= ")";

        $bindings = array_merge($bindings, [$startTime, $endTime, $startTime, $endTime, $startTime, $endTime]);

        return DB::select($query, $bindings);
    }
}
