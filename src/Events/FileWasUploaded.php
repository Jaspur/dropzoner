<?php

namespace Jaspur\Dropzoner\Events;

class FileWasUploaded extends Event
{
    public $original_filename;
    public $server_filename;
    public $extension;
    public $id;
    public $user;

    public function __construct($original_filename, $server_filename, $extension, $id, $user)
    {
        $this->original_filename = $original_filename;
        $this->server_filename   = $server_filename;
        $this->extension         = $extension;
        $this->id                = $id;
        $this->user              = $user;
    }
}
