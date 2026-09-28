<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--output= : Output filename} {--retention=10 : Number of backups to keep}';

    protected $description = 'Backup database MySQL safely and keep recent copies in a secure local directory.';

    public function handle(): int
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');

        if (! $database) {
            $this->error('Database name is not configured.');

            return self::FAILURE;
        }

        $projectBackupDir = base_path('backups');
        $storageBackupDir = storage_path('app/backups');

        foreach ([$projectBackupDir, $storageBackupDir] as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        }

        $timestamp = now()->format('Ymd-His');
        $filename = $this->option('output') ?: $database . '-' . $timestamp . '.sql';
        $projectFile = $projectBackupDir . DIRECTORY_SEPARATOR . $filename;
        $storageFile = $storageBackupDir . DIRECTORY_SEPARATOR . $filename;

        $command = ['mysqldump', '--host=' . $host, '--port=' . $port, '--user=' . $username];

        if ($password !== null && $password !== '') {
            $command[] = '--password=' . $password;
        }

        $command[] = $database;

        $process = new Process($command);
        $process->setTimeout(0);

        $process->run(function ($type, $buffer) use ($projectFile, $storageFile) {
            if (Process::ERR === $type) {
                $this->error($buffer);

                return;
            }

            file_put_contents($projectFile, $buffer, FILE_APPEND);
            file_put_contents($storageFile, $buffer, FILE_APPEND);
        });

        if (! $process->isSuccessful()) {
            $this->error('Database backup failed.');

            return self::FAILURE;
        }

        $retention = max(1, (int) $this->option('retention'));
        $this->pruneBackups($projectBackupDir, $retention);
        $this->pruneBackups($storageBackupDir, $retention);

        $this->info('Database backup created: ' . $projectFile);
        $this->info('Backup mirror saved to: ' . $storageFile);

        return self::SUCCESS;
    }

    protected function pruneBackups(string $directory, int $retention): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $files = glob($directory . DIRECTORY_SEPARATOR . '*.sql');
        if (! is_array($files) || $files === []) {
            return;
        }

        usort($files, static fn ($a, $b) => filemtime($a) <=> filemtime($b));

        foreach (array_slice($files, 0, max(0, count($files) - $retention)) as $oldFile) {
            @unlink($oldFile);
        }
    }
}
