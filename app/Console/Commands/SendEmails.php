<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

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
                            ->where('mail_sent', '0')
                            ->whereYear('start_at', $currentYear)
                            ->get();

        foreach($bookings as $booking) {
            $target_time = new DateTime($booking->start_at);
            if($booking->repeat == "none") {
                $current_time = new DateTime();
                $current_time->modify('+1 hour');
                $target_time = new DateTime($booking->start_at);
                if ($current_time > $target_time) {
                    // Mail::to($booking->email)->send(new \App\Mail\BookNotification($booking->start_at, $booking->end_at));
                    $updateBooking = Booking::find($booking->id);
                    $booking->mail_sent = 1;
                    $booking->save();
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
                    $current_time->modify('+1 hour');
                    if($occurrence->format('Y-m-d') == $target_time->format('Y-m-d')) {
                        echo $booking->email;
                        $count = 1;
                        if ($current_time > $occurrence) {
                            // Mail::to($booking->email)->send(new \App\Mail\BookNotification($booking->start_at, $booking->end_at));
                        }
                        break;
                    }
                }
                var_dump(isset($booking->until));
                if($count == 0 && isset($booking->until)) {
                    $updateBooking = Booking::find($booking->id);
                    $booking->mail_sent = 1;
                    $booking->save();
                }
            }
        }

        $this->info('Email sent successfully.');
    }
}
