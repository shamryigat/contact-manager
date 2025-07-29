<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalContacts = Contact::count();
        $recentContacts = Contact::latest()->take(5)->get();

        return view('dashboard', compact('totalContacts', 'recentContacts'));
    }

    // List contacts
    public function index(Request $request)
    {
        $search = $request->query('search');
        $contacts = Contact::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('contacts.index', compact('contacts', 'search'));
    }

    // Show create form
    public function create()
    {
        return view('contacts.create');
    }

    // Store new contact
    public function store(ContactRequest $request){
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact = Contact::create($data);

        // Send email notification
        \Mail::to(auth()->user()->email)->send(new \App\Mail\ContactCreatedMail($contact));

        // Log the event
        \Log::channel('contact')->info('New contact created', [
            'user' => auth()->user()->email,
            'contact_id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    // Show edit form
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    // Update contact
    public function update(ContactRequest $request, Contact $contact)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($contact->photo_path) {
                Storage::disk('public')->delete($contact->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact->update($data);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    // Delete contact
    public function destroy(Contact $contact)
    {
        if ($contact->photo_path) {
            Storage::disk('public')->delete($contact->photo_path);
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
