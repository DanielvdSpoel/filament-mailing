<?php

namespace App\Support\Imap;

use Illuminate\Support\Collection;

class Connection
{
    public string $host;
    public int $port;
    public string $encryption;
    public string $username;
    public string $password;
    public \IMAP\Connection|bool $internal_connection;

    public function __construct(string $host, int $port, string $encryption, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->encryption = $encryption;
        $this->username = $username;
        $this->password = $password;
    }

    public function open(?string $connection_string = null): bool
    {
        $this->internal_connection = imap_open(($connection_string ?? $this->getConnectionString()), $this->username, $this->password);
        return $this->internal_connection !== false;
    }

    public function close(): bool
    {
        $result = imap_close($this->internal_connection);
        $this->internal_connection = false;
        return $result;
    }

    public function isConnected(): bool
    {
        return $this->internal_connection !== false;
    }

    public function getConnectionString(): string
    {
        return '{' . $this->host . ':' . $this->port . '/' . $this->encryption . '}';
    }

    /**
     * @return Collection<Folder>
     */
    public function getFolders(): Collection
    {
        $this->open();
        $folders = imap_list($this->internal_connection, $this->getConnectionString(), '*');
        $this->close();
        return collect($folders)->map(function (string $folder) {
            return new Folder($this, $folder);
        });
    }

}
