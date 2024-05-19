<?php

// config for MohammedManssour/FileCast
return [
    /** Default storage disk */
    'disk' => env('FILE_CAST_DISK', 'public'),

    /** Automatically delete old files */
    'auto_delete' => env('FILE_CAST_AUTO_DELETE', true),
];
