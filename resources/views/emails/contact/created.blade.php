@component('mail::message')
# New Contact Created 🎉

A new contact has been added:

- **Name:** {{ $contact->name }}
- **Email:** {{ $contact->email ?? '-' }}
- **Phone:** {{ $contact->phone ?? '-' }}
- **Company:** {{ $contact->company ?? '-' }}

@component('mail::button', ['url' => url('/contacts/'.$contact->id.'/edit')])
View Contact
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
