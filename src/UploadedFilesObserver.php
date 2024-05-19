<?php

namespace MohammedManssour\FileCast;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Database\Eloquent\Model;

class UploadedFilesObserver implements ShouldHandleEventsAfterCommit
{
    public function updated(Model $model): void
    {
        if (! config('file-cast.auto_delete', true)) {
            return;
        }

        if (! $model->wasChanged()) {
            return;
        }
        $columns = $this->getFileCastedColumns($model);
        foreach ($columns as $column) {
            if (! $model->wasChanged($column)) {
                continue;
            }

            $model->getOriginal($column)?->delete();
        }
    }

    public function deleted(Model $model)
    {
        if (! config('file-cast.auto_delete', true)) {
            return;
        }

        $columns = $this->getFileCastedColumns($model);
        foreach ($columns as $column) {
            $model->getAttribute($column)?->delete();
        }
    }

    protected function getFileCastedColumns(Model $model)
    {
        $columns = [];
        foreach ($model->getCasts() as $key => $cast) {
            if (! str_starts_with($cast, FileCast::class)) {
                continue;
            }

            $columns[] = $key;
        }

        return $columns;
    }
}
