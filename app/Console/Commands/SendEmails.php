<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use DateTime;
use RRule\RRule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Book Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentYear = now()->year;
        $bookings = Booking::where('status', '1')
                            ->where('can_send', '0')
                            ->whereYear('start_at', $currentYear)
                            ->get();

        foreach($bookings as $booking) {
            $target_time = new DateTime($booking->start_at);
            if($booking->repeat == "none") {
                $current_time = new DateTime();
                $current_time->modify('+1 hour');
                $target_time = new DateTime($booking->start_at);
                if ($current_time > $target_time) {
                    Mail::to($booking->email)->send(new \App\Mail\BookNotification(substr($booking->start_at, 11, 5), substr($booking->end_at, 11, 5)));
                    $booking->can_send = 1;
                    $booking->sent_date = $current_time;
                    $booking->save();
                    Log::info('Success');
                }
            }else {
                $rrule_array = [
                    'FREQ' => $booking->freq,
                    'DTSTART' => $booking->start_at,
                    'INTERVAL' => $booking->interval,
                ];

                if(isset($booking->until)) $rrule_array['UNTIL'] = $booking->until;
                if(isset($booking->count)) $rrule_array['COUNT'] = $booking->count;
                if(isset($booking->byweekday) || $booking->byweekday == "") $rrule_array['BYDAY'] = $booking->byweekday;
                if(isset($booking->bymonthday)) $rrule_array['BYMONTHDAY'] = $booking->bymonthday;
                if(isset($booking->bysetpos)) $rrule_array['BYSETPOS'] = $booking->bysetpos;

                $rrule = new RRule($rrule_array);

                $count = 0;
                foreach ($rrule as $occurrence) {
                    $current_time = new DateTime();
                    if($occurrence->format('Y-m-d') == $current_time->format('Y-m-d') && ($booking->sent_date == null || $occurrence->format('Y-m-d') != $booking->sent_date->format('Y-m-d'))) {
                        $current_time->modify('+1 hour');
                        $count = 1;
                        if ($current_time > $occurrence) {
                            Mail::to($booking->email)->send(new \App\Mail\BookNotification(substr($booking->start_at, 11, 5), substr($booking->end_at, 11, 5)));
                            Log::info('Success');
                            $booking->sent_date = new DateTime();
                            $booking->save();
                        }
                        break;
                    }
                }
                if($count == 0 && isset($booking->until)) {
                    $booking->can_send = 1;
                    $booking->sent_date = new DateTime();
                    $booking->save();
                }
            }
        }
        Log::info('This is an informational message for cron job');
    }
}
