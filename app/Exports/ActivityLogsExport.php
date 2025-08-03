<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ActivityLog::latest()->get();
    }

    public function map($log): array
    {
        // Decode details JSON
        $details = is_string($log->details) 
            ? json_decode($log->details, true) 
            : $log->details;

        $old = $details['old'] ?? [];
        $new = $details['new'] ?? [];

        return [
            $log->action,
            $old['name'] ?? '',
            $old['email'] ?? '',
            $old['phone'] ?? '',
            $old['company'] ?? '',
            $old['address'] ?? '',
            $old['notes'] ?? '',
            $new['name'] ?? '',
            $new['email'] ?? '',
            $new['phone'] ?? '',
            $new['company'] ?? '',
            $new['address'] ?? '',
            $new['notes'] ?? '',
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'Action',
            'Old Name',
            'Old Email',
            'Old Phone',
            'Old Company',
            'Old Address',
            'Old Notes',
            'New Name',
            'New Email',
            'New Phone',
            'New Company',
            'New Address',
            'New Notes',
            'Timestamp',
        ];
    }
}
