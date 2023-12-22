<?php

namespace App\Models;

use App\Support\Imap\Connection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Inbox extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'template_id',
        'username',
        'password',
        'imap_host',
        'imap_port',
        'imap_encryption',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
    ];

    protected $casts = [
        'username' => 'encrypted',
        'password' => 'encrypted',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(InboxTemplate::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    public function getImapConnection(): Connection
    {
        return new Connection(
            host: $this->imap_host,
            port: $this->imap_port,
            encryption: $this->imap_encryption,
            username: $this->username,
            password: $this->password,
        );
    }


    protected function imapHost(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->imap_host,
        );
    }

    protected function imapPort(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->imap_port,
        );
    }

    protected function imapEncryption(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->imap_encryption,
        );
    }

    protected function smtpHost(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->smtp_host,
        );
    }

    protected function smtpPort(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->smtp_port,
        );
    }

    protected function smtpEncryption(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? optional($this->template)->smtp_encryption,
        );
    }
}
