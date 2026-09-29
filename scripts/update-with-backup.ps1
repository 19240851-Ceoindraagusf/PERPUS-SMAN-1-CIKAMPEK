param(
    [switch]$SkipMaintenanceMode
)

$ErrorActionPreference = 'Stop'
$projectRoot = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..'))
Set-Location $projectRoot

Write-Host 'Membuat backup tervalidasi sebelum update database...' -ForegroundColor Cyan
& (Join-Path $PSScriptRoot 'backup-db.ps1')

if ($LASTEXITCODE -ne 0) {
    throw 'Update dibatalkan karena backup tidak berhasil dibuat.'
}

$maintenanceModeEnabled = $false

try {
    if (-not $SkipMaintenanceMode) {
        php artisan down
        if ($LASTEXITCODE -ne 0) {
            throw 'Gagal mengaktifkan maintenance mode.'
        }

        $maintenanceModeEnabled = $true
    }

    php artisan migrate --force
    if ($LASTEXITCODE -ne 0) {
        throw 'Migrasi gagal. Database tidak dihapus; periksa pesan error sebelum melanjutkan.'
    }

    php artisan optimize:clear
    if ($LASTEXITCODE -ne 0) {
        throw 'Migrasi selesai, tetapi cache aplikasi gagal dibersihkan.'
    }
}
finally {
    if ($maintenanceModeEnabled) {
        php artisan up
    }
}

Write-Host 'Update database selesai. Backup tervalidasi telah dibuat sebelum migrasi.' -ForegroundColor Green
