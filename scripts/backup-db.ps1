$ErrorActionPreference = 'Stop'

$database = 'perpus_digital_sman1_cikampek'
$timestamp = Get-Date -Format 'yyyy-MM-dd_HHmmss'
$backupDir = Join-Path $PSScriptRoot '..\backups'
$backupPath = Join-Path $backupDir "$database`_$timestamp.sql"

New-Item -ItemType Directory -Path $backupDir -Force | Out-Null

mysqldump --user=root --databases $database > $backupPath

if (-not (Test-Path $backupPath)) {
    throw "Backup gagal dibuat: $backupPath"
}

Write-Host "Backup database berhasil dibuat: $backupPath"
Write-Host "Ukuran file: $((Get-Item $backupPath).Length) bytes"
