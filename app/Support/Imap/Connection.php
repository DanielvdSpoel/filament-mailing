<?php

namespace App\Support\Imap;

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

    public function open(): bool
    {
        $this->internal_connection = imap_open($this->getConnectionString(), $this->username, $this->password);
        return $this->internal_connection !== false;
    }

    public function close(): bool
    {
        return imap_close($this->internal_connection);
    }

    public function getConnectionString(): string
    {
        return '{' . $this->host . ':' . $this->port . '/' . $this->encryption . '}';
    }

    public function getFolders(): array
    {
        dd("Folders!");
    }

}
