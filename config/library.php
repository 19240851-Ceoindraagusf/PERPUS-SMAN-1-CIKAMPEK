<?php

return [
    /* Access logs are retained for analytics, then removed to limit personal-data storage. */
    'access_log_retention_days' => (int) env('ACCESS_LOG_RETENTION_DAYS', 90),
    'location' => env('LIBRARY_LOCATION', 'SMAN 1 Cikampek'),
    'service_hours' => env('LIBRARY_SERVICE_HOURS', 'Senin–Jumat, saat jam sekolah'),
    'contact' => env('LIBRARY_CONTACT', 'Tanyakan kepada petugas perpustakaan di sekolah'),
];
