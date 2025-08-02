<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use App\Mail\ContactNotificationMail;
use Illuminate\Support\Facades\Mail;

class ActivityLogger
{
    public static function log(string $action, array $details = [], $contact = null, $sendEmail = true)
    {
        // Ensure details always has 'old' and 'new' keys
        $structuredDetails = [
            'old' => $details['old'] ?? null,
            'new' => $details['new'] ?? null,
        ];

        // ✅ Save log to database
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'details' => $structuredDetails,
        ]);

        // ✅ Send email if enabled and contact is provided
        if ($sendEmail && $contact) {
            Mail::to(config('mail.admin_email', 'your-admin@example.com'))
                ->send(new ContactNotificationMail($contact, $action, $structuredDetails['old']));
        }
    }
}
