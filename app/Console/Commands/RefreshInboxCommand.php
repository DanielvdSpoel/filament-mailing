<?php

namespace App\Console\Commands;

use App\Models\Inbox;
use Illuminate\Console\Command;

class RefreshInboxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inbox:refresh {--inbox=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inboxes = $this->option('inbox');
        if (empty($inboxes)) {
            $inboxes = Inbox::all();
        } else {
            $inboxes = Inbox::whereIn('id', $inboxes)->get();
        }

        $inboxes->each(function (Inbox $inbox) {
            $inbox->emails()->delete();

            $connection = $inbox->getConnection();

        });

    }
}
