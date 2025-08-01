<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(string $action, array $details = [])
    {
        // Ensure details always has 'old' and 'new' keys
        $structuredDetails = [
            'old' => $details['old'] ?? null,
            'new' => $details['new'] ?? null,
        ];

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'details' => $structuredDetails,
        ]);
    }
}
