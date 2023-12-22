<?php

namespace Database\Seeders;

use App\Models\InboxTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InboxTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InboxTemplate::updateOrCreate([
            'name' => 'Gmail',
        ], [
            'imap_host' => 'imap.gmail.com',
            'imap_port' => '993',
            'imap_encryption' => 'ssl',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_encryption' => 'ssl',
        ]);

        InboxTemplate::updateOrCreate([
            'name' => 'Outlook',
        ], [
            'imap_host' => 'outlook.office365.com',
            'imap_port' => '993',
            'imap_encryption' => 'ssl',
            'smtp_host' => 'smtp.office365.com',
            'smtp_port' => '587',
            'smtp_encryption' => 'tls',
        ]);

        InboxTemplate::updateOrCreate([
            'name' => 'Soverin',
        ], [
            'imap_host' => 'imap.soverin.net',
            'imap_port' => '993',
            'imap_encryption' => 'ssl',
            'smtp_host' => 'smtp.soverin.net',
            'smtp_port' => '465',
            'smtp_encryption' => 'ssl',
        ]);
    }

}

