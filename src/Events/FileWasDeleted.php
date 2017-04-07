<?php

namespace Jaspur\Dropzoner\Events;

class FileWasDeleted extends Event
{
    public $server_filename;

    public function __construct($server_filename)
    {
        $this->server_filename = $server_filename;
    }
}
