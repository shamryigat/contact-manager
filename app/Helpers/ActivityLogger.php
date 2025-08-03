<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use App\Mail\ContactNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    public static function log(string $action, array $details = [], $contact = null, $sendEmail = true)
    {
        $structuredDetails = [
            'old' => $details['old'] ?? null,
            'new' => $details['new'] ?? null,
        ];

        // ✅ Save to database
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'details' => $structuredDetails,
        ]);

        // ✅ Save to log file
        Log::channel('contact')->info(json_encode([
            'user_id' => auth()->id(),
            'action' => $action,
            'details' => $structuredDetails,
            'contact_id' => $contact?->id,
            'timestamp' => now()->toDateTimeString(),
        ]));

        // ✅ Send email if enabled
        if ($sendEmail && $contact) {
            Mail::to(auth()->user()->email)
                ->send(new ContactNotificationMail($contact, $action, $structuredDetails['old']));
        }
    }
}
