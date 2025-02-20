<?php

namespace App\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QueueService
{

    public function insertUpdate($window_no)
    {
        $type = ($window_no == 2 || $window_no == 3) ? 2 : $window_no;

        // Get the last ticket_no globally across all windows
        $lastTicket = DB::table('qr_tracker.queuing_tickets')
            ->where('type', $type)
            ->orderBy('ticket_no', 'desc')
            ->first();

        // Determine the ticket_no to insert (either 1 or increment the last ticket_no)
        $ticket_no = $lastTicket ? $lastTicket->ticket_no + 1 : 1;

        // Ensure the ticket_no does not exceed the maximum of 20
        if ($ticket_no > 50) {
            $ticket_no = 1; // Reset ticket_no to 1 when it exceeds 20
        }

        DB::table('qr_tracker.queuing_tickets')->updateOrInsert(
            [
                'window_no' => $window_no,
                'type' => $type
            ], // Condition to check existing record
            [
                'ticket_no' => $ticket_no, // Use the incremented ticket_no
                'updated_at' => Carbon::now(), // Update timestamp
                'created_at' => DB::raw('COALESCE(created_at, NOW())') // Keep original created_at if exists
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
            ->select('ticket_no', 'window_no')
            ->get();
    }

    public function truncateTicket()
    {
        DB::table('queuing_tickets')->truncate();
        return 'Table truncated successfully';
    }
}
