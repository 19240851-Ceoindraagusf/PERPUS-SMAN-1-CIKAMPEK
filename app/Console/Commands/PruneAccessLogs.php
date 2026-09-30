<?php

namespace App\Console\Commands;

use App\Models\AccessLog;
use Illuminate\Console\Command;

class PruneAccessLogs extends Command
{
    protected $signature = 'access-logs:prune {--days= : Keep logs from this many most recent days}';

    protected $description = 'Remove access logs that are older than the configured retention period.';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?? config('library.access_log_retention_days'));

        if ($days < 1) {
            $this->error('The retention period must be at least one day.');

            return self::FAILURE;
        }

        $deleted = AccessLog::query()
            ->where('accessed_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Deleted {$deleted} access log(s) older than {$days} days.");

        return self::SUCCESS;
    }
}
