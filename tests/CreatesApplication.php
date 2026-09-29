<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        if ($app->environment('testing')) {
            $connection = (string) config('database.default');
            $database = (string) config("database.connections.{$connection}.database");
            $usesSafeInMemoryDatabase = $connection === 'sqlite' && $database === ':memory:';
            $usesDedicatedTestingDatabase = str_ends_with(strtolower($database), '_testing');

            if (! $usesSafeInMemoryDatabase && ! $usesDedicatedTestingDatabase) {
                throw new \RuntimeException(
                    "Tes dibatalkan: database '{$database}' bukan database testing yang aman. " .
                    'Gunakan SQLite :memory: atau nama database yang diakhiri _testing.'
                );
            }
        }

        return $app;
    }
}
