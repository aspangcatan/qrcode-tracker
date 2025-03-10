<?php

namespace App\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QueueService
{

    public function insertUpdate($window_no, $lane)
    {
        $type = ($window_no == 2 || $window_no == 3) ? 2 : $window_no;

        // Define the max ticket limits
        $maxTicket = ($lane == 1) ? 10 : 50; // Special lane (1) max is 10, regular max is 50

        // Get the last ticket_no for the given type and lane
        $lastTicket = DB::table('qr_tracker.queuing_tickets')
            ->where('type', $type)
            ->where('lane', $lane)
            ->orderBy('ticket_no', 'desc')
            ->first();

        // Determine the ticket_no to insert (either 1 or increment the last ticket_no)
        $ticket_no = $lastTicket ? $lastTicket->ticket_no + 1 : 1;

        // Ensure the ticket_no does not exceed the maximum
        if ($ticket_no > $maxTicket) {
            $ticket_no = 1; // Reset ticket_no when exceeding the max limit
        }

        DB::table('qr_tracker.queuing_tickets')->updateOrInsert(
            [
                'window_no' => $window_no,
                'type' => $type,
                'lane' => $lane // Ensure lane is part of the unique condition
            ],
            [
                'ticket_no' => $ticket_no,
                'updated_at' => Carbon::now(),
                'created_at' => DB::raw('COALESCE(created_at, NOW())')
            ]
        );

        return $ticket_no;
    }


    public function getWindowTicketNo($window_no)
    {
        return DB::table('qr_tracker.queuing_tickets')
            ->where('window_no', '=', $window_no)
            ->first();
    }

    public function getLastTicketNo()
    {
        return DB::table('qr_tracker.queuing_tickets')
            ->orderBy('updated_at', 'desc') // Orders by ID in descending order to get the latest one
            ->first();
    }

    public function getTicketsTv()
    {
        // Select only the ticket_no and window_no columns
        return DB::table('qr_tracker.queuing_tickets')
            ->select('ticket_no', 'window_no','lane')
            ->get();
    }

    public function truncateTicket()
    {
        DB::table('queuing_tickets')->truncate();
        return 'Ticket reset successfully';
    }
}
