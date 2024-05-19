<?php

namespace MohammedManssour\FileCast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FileCast implements CastsAttributes
{
    public bool $withoutObjectCaching = true;

    public ?string $path;

    public string $disk;

    public string $visibility;

    public function __construct(?string $disk = null, ?string $path = null, ?string $visibility = 'public')
    {
        $this->disk = $disk ?: config('file-cast.disk');
        $this->path = $path;
        $this->visibility = $visibility;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (! $value) {
            return $value;
        }

        return new File($value, $this->disk);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        // if the provided is not a file. then we'll save the value as is. It's up to the developer here
        if (! ($value instanceof UploadedFile)) {
            return $value;
        }

        $path = $this->getPath($model);

        return $value->store(
            $path,
            options: [
                'disk' => $this->disk,
                'visibility' => $this->visibility,
            ]
        );
    }

    /**
     * Get the path that we'll use to store the file on disk
     */
    protected function getPath(Model $model): string
    {
        if ($this->path) {
            return $this->path;
        }

        return $model->getTable();
    }
}
