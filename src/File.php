<?php

namespace MohammedManssour\FileCast;

use Illuminate\Support\Facades\Storage;

class File
{
    public function __construct(public string $path, public string $disk)
    {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function fullPath(): string
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path());
    }

    public function name(): string
    {
        return basename($this->path);
    }

    public function size(): string
    {
        return Storage::disk($this->disk)->size($this->path);
    }

    public function delete(): bool
    {
        if (! $this->exists()) {
            return false;
        }

        return Storage::disk($this->disk)->delete($this->path);
    }

    public function exists()
    {
        return Storage::disk($this->disk)->exists($this->path);
    }
}
