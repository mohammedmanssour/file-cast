<?php

namespace MohammedManssour\FileCast\Tests\stubs\Providers;

use Illuminate\Support\ServiceProvider;
use MohammedManssour\FileCast\Tests\stubs\Models\File;
use MohammedManssour\FileCast\UploadedFilesObserver;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // File::observe(UploadedFilesObserver::class);
    }
}
