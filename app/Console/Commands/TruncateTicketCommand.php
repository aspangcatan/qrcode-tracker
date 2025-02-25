<?php

namespace App\Console\Commands;

use App\Services\QueueService;
use Illuminate\Console\Command;

class TruncateTicketCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:truncate'; // Command name to run in terminal

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the queuing_tickets table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(QueueService $queueService)
    {
        parent::__construct();
        $this->queueService = $queueService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = $this->queueService->truncateTicket();
        $this->info($result);
    }
}
