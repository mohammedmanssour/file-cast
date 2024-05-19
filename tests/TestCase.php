<?php

namespace MohammedManssour\FileCast\Tests;

use MohammedManssour\FileCast\FileCastServiceProvider;
use MohammedManssour\FileCast\Tests\stubs\Providers\WorkbenchServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase as Orchestra;

#[WithEnv('DB_CONNECTION', 'testing')]
class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FileCastServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/stubs/database/migrations/create_file_cast_table.php');
    }
}
