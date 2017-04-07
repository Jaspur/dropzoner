<?php

namespace Jaspur\Dropzoner\Events;

class FileWasUploaded extends Event
{
    public $original_filename;
    public $server_filename;
    public $extension;

    public function __construct($original_filename, $server_filename, $extension)
    {
        $this->original_filename = $original_filename;
        $this->server_filename   = $server_filename;
        $this->extension         = $extension;
    }
}
