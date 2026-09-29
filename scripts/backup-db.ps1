param(
    [ValidateRange(1, 100)]
    [int]$Retention = 10
)

$ErrorActionPreference = 'Stop'

$database = 'perpus_digital_sman1_cikampek'
$timestamp = Get-Date -Format 'yyyy-MM-dd_HHmmss'
$projectBackupDir = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..\backups'))
$externalBackupDir = Join-Path ([Environment]::GetFolderPath('MyDocuments')) 'PerpusBackups'
$backupPath = Join-Path $projectBackupDir "$database`_$timestamp.sql"
$externalBackupPath = Join-Path $externalBackupDir "$database`_$timestamp.sql"

New-Item -ItemType Directory -Path $projectBackupDir -Force | Out-Null
New-Item -ItemType Directory -Path $externalBackupDir -Force | Out-Null

& mysqldump --user=root --single-transaction --routines --events --databases $database "--result-file=$backupPath"

if ($LASTEXITCODE -ne 0) {
    Remove-Item -LiteralPath $backupPath -Force -ErrorAction SilentlyContinue
    throw 'Backup gagal dibuat oleh mysqldump. Database tidak diubah.'
}

if (-not (Test-Path $backupPath) -or (Get-Item -LiteralPath $backupPath).Length -lt 1024) {
    throw 'Backup tidak valid atau terlalu kecil. Database tidak diubah.'
}

if (-not (Select-String -LiteralPath $backupPath -Pattern 'CREATE DATABASE|CREATE TABLE' -Quiet)) {
    throw 'Backup tidak memuat struktur database yang valid. Database tidak diubah.'
}

Copy-Item -Path $backupPath -Destination $externalBackupPath -Force

if (-not (Test-Path $backupPath)) {
    throw "Backup gagal dibuat: $backupPath"
}

Get-ChildItem -Path $projectBackupDir -Filter "$database*_*.sql" |
    Sort-Object LastWriteTime |
    Select-Object -SkipLast $Retention |
    Remove-Item -Force -ErrorAction SilentlyContinue

Get-ChildItem -Path $externalBackupDir -Filter "$database*_*.sql" |
    Sort-Object LastWriteTime |
    Select-Object -SkipLast $Retention |
    Remove-Item -Force -ErrorAction SilentlyContinue

Write-Host "Backup database berhasil dibuat: $backupPath" -ForegroundColor Green
Write-Host "Backup cadangan juga disimpan di: $externalBackupPath" -ForegroundColor Green
Write-Host "Ukuran file: $((Get-Item $backupPath).Length) bytes" -ForegroundColor Cyan
Write-Host "SHA-256: $((Get-FileHash -LiteralPath $backupPath -Algorithm SHA256).Hash)" -ForegroundColor Cyan
