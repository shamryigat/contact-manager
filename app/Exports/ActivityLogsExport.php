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
        return ActivityLog::latest()->get(); // Get all logs
    }

    public function map($log): array
    {
        // Convert JSON details into a readable string
        $details = $log->details;

        if (is_string($details)) {
            $details = json_decode($details, true) ?: [];
        }

        $detailsText = '';
        $name = isset($details['name']) ? $details['name'] : 'Unknown';

        if ($log->action === 'Edited Contact') {
            $fields = [];

            foreach ($details as $key => $value) {
                if ($key !== 'name') {
                    $fields[] = ucfirst($key);
                }
            }

            $fieldsText = implode(', ', $fields);
            $detailsText = "Edited [$fieldsText] on contact [$name]";

        } elseif ($log->action === 'Added Contact') {
            $detailsText = "Added new contact [$name]";

        } elseif ($log->action === 'Deleted Contact') {
            $detailsText = "Deleted contact [$name]";

        } else {
            $detailsText = json_encode($details);
        }

        return [
            $log->action,
            $detailsText,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['Action', 'Details', 'Date'];
    }
}
