$ErrorActionPreference = 'Stop'

param(
    [int]$Retention = 10,
    [switch]$Force = $false
)

$database = 'perpus_digital_sman1_cikampek'
$timestamp = Get-Date -Format 'yyyy-MM-dd_HHmmss'
$projectBackupDir = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..\backups'))
$externalBackupDir = Join-Path $HOME 'PerpusBackups'
$backupPath = Join-Path $projectBackupDir "$database`_$timestamp.sql"
$externalBackupPath = Join-Path $externalBackupDir "$database`_$timestamp.sql"

New-Item -ItemType Directory -Path $projectBackupDir -Force | Out-Null
New-Item -ItemType Directory -Path $externalBackupDir -Force | Out-Null

if (-not $Force) {
    Write-Host 'Backup aman dijalankan tanpa penghapusan data. Gunakan -Force hanya jika Anda ingin mengaktifkan mode backup manual.' -ForegroundColor Yellow
}

mysqldump --user=root --databases $database > $backupPath
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
