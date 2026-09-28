param(
    [Parameter(Mandatory = $true)]
    [string]$BackupFile,
    [string]$DatabaseName = 'perpus_digital_sman1_cikampek',
    [switch]$Force
)

$ErrorActionPreference = 'Stop'

if (-not (Test-Path $BackupFile)) {
    throw "File backup tidak ditemukan: $BackupFile"
}

if (-not $Force) {
    throw "Restore database destruktif. Tambahkan parameter -Force dan konfirmasi manual agar tidak menghapus database sembarangan. Contoh: .\scripts\restore-db.ps1 -BackupFile .\backups\nama.sql -Force"
}

$confirmation = Read-Host "Ketik: RESTORE DATABASE $DatabaseName untuk melanjutkan"
if ($confirmation -ne "RESTORE DATABASE $DatabaseName") {
    throw "Restore dibatalkan. Database tidak dihapus."
}

mysql --user=root -e "DROP DATABASE IF EXISTS `$DatabaseName; CREATE DATABASE `$DatabaseName;"
Get-Content $BackupFile | mysql --user=root $DatabaseName

Write-Host "Database berhasil direstore dari $BackupFile" -ForegroundColor Green
