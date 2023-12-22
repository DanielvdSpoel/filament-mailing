<?php

use App\Models\Account;
use App\Models\InboxTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(InboxTemplate::class, 'template_id')->nullable()->constrained('inbox_templates')->cascadeOnDelete();
            $table->foreignIdFor(Account::class)->nullable()->constrained()->cascadeOnDelete();
            $table->text('username');
            $table->text('password');
            $table->string('imap_host')->nullable();
            $table->string('imap_port')->nullable();
            $table->string('imap_encryption')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inboxes');
    }
};
