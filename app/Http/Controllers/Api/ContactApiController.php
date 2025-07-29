<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactApiController extends Controller
{
    public function index()
    {
        return response()->json(Contact::latest()->paginate(10));
    }

    public function store(ContactRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact = Contact::create($data);

        return response()->json(['message' => 'Contact created', 'contact' => $contact], 201);
    }

    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact->update($data);

        return response()->json(['message' => 'Contact updated', 'contact' => $contact]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json(['message' => 'Contact deleted']);
    }
}
