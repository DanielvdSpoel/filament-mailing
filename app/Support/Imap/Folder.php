<?php

namespace App\Support\Imap;

use Illuminate\Support\Collection;

class Folder
{
    public Connection $connection;
    public string $name;
    public string $connection_name;

    public function __construct(Connection $connection, string $connection_name)
    {
        $this->connection = $connection;
        $this->connection_name = $connection_name;
        $this->name = str_replace($this->connection->getConnectionString(), '', $connection_name);
    }

    /**
     * @return Collection<Message>
     */
    public function getMessages(): Collection
    {
        $this->connection->open($this->connection_name);
        ray('collecting messages in folder ' . $this->name);
        $messages = imap_search($this->connection->internal_connection, '');
        if (!$messages) {
            return collect();
        }
        $messages = collect($messages)->take(1)->map(function (string $message) use ($messages) {
            $uid = imap_uid($this->connection->internal_connection, $message);
            return new Message($this, $this->connection, $uid);
        });
        $this->connection->close();
        //filter out all nulls
        return $messages->filter();
    }



}
