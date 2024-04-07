<?php

namespace App\Console\Commands;

use App\Mail\Birthday;
use Illuminate\Console\Command;
use App\Models\Contact;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Mail;

class BirthdayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Birthday Reminders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contacts = Contact::whereMonth('birthday', Carbon::now()->month)->whereDay('birthday', Carbon::now()->day)->get();
        $today = new DateTime();
        foreach ($contacts as $contact) {
            Mail::to($contact->email)->send(new Birthday($contact->name));
        }
        return Command::SUCCESS;
    }
}
