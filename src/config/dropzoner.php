<?php

return [
    'upload-path'        => env('DROPZONER_UPLOAD_PATH', 'files'),
    'validator'          => [
        'file' => 'required',
    ],
    'validator-messages' => [
        'file.required' => 'Image is required',
    ],
];
