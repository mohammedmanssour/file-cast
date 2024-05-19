<?php

namespace MohammedManssour\FileCast\Tests\stubs\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use MohammedManssour\FileCast\FileCast;
use MohammedManssour\FileCast\UploadedFilesObserver;

#[ObservedBy([UploadedFilesObserver::class])]
class File extends Model
{
    protected $table = 'file_cast_table';

    public $timestamps = false;

    public $casts = [
        'path' => FileCast::class.':fake_disk,path',
    ];

    public $fillable = ['id', 'path'];
}
