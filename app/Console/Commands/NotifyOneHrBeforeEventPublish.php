<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EventController;


class NotifyOneHrBeforeEventPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:one-hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
        $event = new EventController();
        $event->sendNotifyOneHrBeforeEventPublish();
        return 0;
    }
}
