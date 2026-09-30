<?php

return [
    /* Access logs are retained for analytics, then removed to limit personal-data storage. */
    'access_log_retention_days' => (int) env('ACCESS_LOG_RETENTION_DAYS', 90),
];
