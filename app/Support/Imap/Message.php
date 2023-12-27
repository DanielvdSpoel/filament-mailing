<?php

namespace App\Support\Imap;

class Message
{
    public Folder $folder;
    public Connection $connection;
    public string $subject;
    public ?string $text_body;
    public ?string $html_body;
    public $original_structure;
    public $structure;
    public $header;

    public int $message_uid;

    public function __construct(Folder $folder, Connection $connection, int $message_uid)
    {
        $this->folder = $folder;
        $this->connection = $connection;
        $this->message_uid = $message_uid;
        $this->subject = $this->getSubject();
//        $this->text_body = $this->getTextBody();
//        $this->html_body = $this->getHtmlBody();
        $this->fetchStructure();
//        ray($this->structure)
    }

    /**
     * @throws \Exception
     */
    private function fetchStructure(): void
    {
        if (!$this->connection->isConnected()) {
            throw new \Exception('Connection not open');
        }

        $structure = imap_fetchstructure($this->connection->internal_connection, $this->message_uid, FT_UID);
        $this->original_structure = $structure;
        $this->structure = $this->addIndexesToStructure($structure, '1');
    }



    private function addIndexesToStructure($structure, $currentIndex = ''): array
    {
        $result = [];
        $result[$currentIndex] = $structure;

        // If the structure has parts, process them recursively
        if (isset($structure->parts)) {
            foreach ($structure->parts as $index => $part) {
                $partKey = $currentIndex . ($currentIndex ? '.' : '') . ($index + 1);

                // Recursively process nested parts
                $nestedResult = $this->addIndexesToStructure($part, $partKey);

                // Merge the current result with nested result
                $result = array_merge($result, $nestedResult);
            }
        }

        // Add current part to the result with the calculated index
//        $result[$currentIndex] = $structure;

//        ray($result);
        return $result;
    }

    private function fetchHeader(): void
    {
        if (!$this->connection->isConnected()) {
            throw new \Exception('Connection not open');
        }
        $this->header = imap_fetchheader($this->connection->internal_connection, $this->message_uid, FT_UID);
    }

    private function getSubject(): string
    {
        if (!isset($this->header)) {
            $this->fetchHeader();
        }

        return isset($this->header->subject) ? iconv_mime_decode($this->header->subject) : 'no subject';
    }

    private function getTextBody(): ?string
    {
        if (!isset($this->structure)) {
            ray('fetching structure for ' . $this->message_uid);
            $this->fetchStructure();
        }

        foreach ($this->structure as $index => $part) {
            if ($part->type === 0 && $part->subtype === 'PLAIN') {
                return $this->getPartContent($part, $index);
            }
        }
        return null;
    }

    private function getHtmlBody(): string
    {
        if (!isset($this->structure)) {
            $this->fetchStructure();
        }

        $html = '';
        if ($this->structure->type === 1 && isset($this->structure->parts[1])) {
            $html = $this->getPartContent($this->structure->parts[1]);
        }

        return $html;
    }

    private function getPartContent(object $part, string $index): string
    {
        ray($this->original_structure);
        ray($index);
        $content = imap_fetchbody($this->connection->internal_connection, $this->message_uid, $index, FT_UID);

//        if ($part->encoding === 0) {
//            $content = imap_body($this->connection->internal_connection, $this->message_uid, FT_UID);
//            ray($content);
//        } else
        if (in_array($part->encoding, [1, 2, 3])) {
            switch ($part->encoding) {
                case 1:
                    $content = imap_8bit(imap_fetchbody($this->connection->internal_connection, $this->message_uid, $index, FT_UID));
                    break;
                case 2:
                    $content = imap_binary(imap_fetchbody($this->connection->internal_connection, $this->message_uid, $index, FT_UID));
                    break;
                case 3:
                    $content = imap_base64(imap_fetchbody($this->connection->internal_connection, $this->message_uid, $index, FT_UID));
                    break;
            }
            // Decoding methods for 7bit, 8bit, and binary encoding
//            $content = imap_base64(imap_binary(imap_8bit(imap_qprint(imap_fetchbody($this->connection->internal_connection, $this->message_uid, $part->encoding, FT_UID)))));
        }

        if ($part->ifparameters) {
            foreach ($part->parameters as $parameter) {
                if ($parameter->attribute === 'charset') {
                    $charset = $parameter->value;
                    $content = mb_convert_encoding($content, 'UTF-8', $charset);
                    break;
                }
            }
        }
        ray($content);

        return $content;
    }
}
