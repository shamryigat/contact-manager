<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactListsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Contact::all();
    }

    public function map($contact): array
    {
        return [
            $contact->name,
            $contact->email,
            $contact->phone,
            $contact->company,
            $contact->address,
            $contact->notes,
            $contact->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Company', 'Notes', 'Created At'];
    }
}
