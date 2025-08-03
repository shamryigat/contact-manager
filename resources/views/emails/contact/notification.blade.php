@component('mail::message')
# Contact {{ $action }}

@if($action === 'Added')
A new contact has been added:
@elseif($action === 'Updated')
A contact has been updated:
@elseif($action === 'Deleted')
A contact has been deleted:
@endif

@component('mail::panel')
### Contact Details
- **Name:** {{ $contact->name ?? '-' }}
- **Email:** {{ $contact->email ?? '-' }}
- **Phone:** {{ $contact->phone ?? '-' }}
- **Company:** {{ $contact->company ?? '-' }}
- **Address:** {{ $contact->address ?? '-' }}
- **Notes:** {{ $contact->notes ?? '-' }}
@endcomponent

@if($action === 'Updated' && $oldData)
### Old Data:
@foreach($oldData as $key => $value)
- **{{ ucfirst($key) }}:** {{ $value ?? '-' }}
@endforeach
@endif

@component('mail::button', ['url' => url('/contacts/'.$contact->id.'/edit')])
View Contact
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
