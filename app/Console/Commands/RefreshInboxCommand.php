<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Email;
use App\Models\Inbox;
use App\Models\InboxTemplate;
use Illuminate\Console\Command;
use Str;

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
        Inbox::updateOrCreate([
            'name' => 'Soverin',
        ], [
            'template_id' => InboxTemplate::where('name', 'Soverin')->firstOrFail()->id,
            'account_id' => Account::first()->id,
            'username' => env('SOVERIN_USERNAME'),
            'password' => env('SOVERIN_PASSWORD'),
        ]);


        $inboxes = $this->option('inbox');
        if (empty($inboxes)) {
            $inboxes = Inbox::all();
        } else {
            $inboxes = Inbox::whereIn('id', $inboxes)->get();
        }

        $this->info('Refreshing ' . $inboxes->count() . ' inboxes');
        $bar = $this->output->createProgressBar($inboxes->count());

        $inboxes->each(function (Inbox $inbox) use ($bar) {
            Email::where('inbox_id', $inbox->id)->forceDelete();

            $connection = $inbox->getImapConnection();
            $connection->open();

            $folder_list = $connection->getFolders();
            $emails = collect();
            foreach ($folder_list as $folder) {
                $messages = $folder->getMessages();

                foreach ($messages as $message) {
                    $emails->push([
                        'inbox_id' => $inbox->id,
                        'message_uid' => $message->message_uid,
                        'subject' => $message->subject,
//                        'text_body' => Str::limit($message->text_body, 1000)
//                        'html_body' => $message->html_body,
                    ]);
//                    ray($message->text_body);
                }
            }
            dump($emails->count() . ' emails found for ' . $inbox->name);

            foreach ($emails->chunk(100) as $chunk) {
                Email::insert($chunk->toArray());
            }
            $bar->advance();
        });
        $bar->finish();
        $this->info('Done');

        return 0;
    }
}
