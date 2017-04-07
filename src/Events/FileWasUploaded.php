<?php

namespace Jaspur\Dropzoner\Events;

class FileWasUploaded extends Event
{
    public $original_filename;

    public $server_filename;

    public function __construct($original_filename, $server_filename)
    {
        $this->original_filename = $original_filename;
        $this->server_filename   = $server_filename;
    }
}
