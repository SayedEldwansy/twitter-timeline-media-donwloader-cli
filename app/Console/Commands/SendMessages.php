<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMessages extends Command
{

    protected $signature = 'messages:send';


    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        //
    }
}
