<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('access_logs')
            ->whereNotNull('ip_address')
            ->orderBy('id')
            ->chunkById(200, function ($accessLogs): void {
                foreach ($accessLogs as $accessLog) {
                    DB::table('access_logs')
                        ->where('id', $accessLog->id)
                        ->update(['ip_address' => $this->anonymizeIpAddress($accessLog->ip_address)]);
                }
            });
    }

    public function down(): void
    {
        // Original IP addresses cannot be reconstructed after anonymization.
    }

    private function anonymizeIpAddress(?string $ipAddress): ?string
    {
        if (! $ipAddress || ! filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            return null;
        }

        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ipAddress);
            $parts[3] = '0';

            return implode('.', $parts);
        }

        $packedAddress = inet_pton($ipAddress);

        if ($packedAddress === false) {
            return null;
        }

        return inet_ntop(substr($packedAddress, 0, 6).str_repeat("\0", 10));
    }
};
