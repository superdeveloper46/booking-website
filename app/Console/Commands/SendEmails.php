<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        Mail::to('topwebdev46@gmail.com')->send(new \App\Mail\ExampleEmail());

        $this->info('Email sent successfully.');
    }
}
