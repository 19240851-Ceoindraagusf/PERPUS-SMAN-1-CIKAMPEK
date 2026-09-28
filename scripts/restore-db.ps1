param(
    [Parameter(Mandatory = $true)]
    [string]$BackupFile
)

$ErrorActionPreference = 'Stop'

if (-not (Test-Path $BackupFile)) {
    throw "File backup tidak ditemukan: $BackupFile"
}

$database = 'perpus_digital_sman1_cikampek'

mysql --user=root -e "DROP DATABASE IF EXISTS `$database; CREATE DATABASE `$database;"
Get-Content $BackupFile | mysql --user=root $database

Write-Host "Database berhasil direstore dari $BackupFile"
