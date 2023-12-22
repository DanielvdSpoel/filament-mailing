<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inbox_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('inbox_templates');
    }
};
