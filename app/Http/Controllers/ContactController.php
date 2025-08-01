<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('company', 'like', "%{$request->search}%");
            });
        }

        // 🔽 Sorting
        $allowedSort = ['name', 'email', 'phone', 'company', 'created_at'];
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        if (!in_array($sort, $allowedSort)) $sort = 'name';
        if (!in_array($direction, ['asc', 'desc'])) $direction = 'asc';

        $contacts = $query->orderBy($sort, $direction)->paginate(10)->appends($request->query());

        return view('dashboard', [
            'contacts' => $contacts,
            'contactsCount' => Contact::count(),
            'contactsAddedToday' => Contact::whereDate('created_at', today())->count(),
            'lastUpdatedContact' => Contact::latest('updated_at')->first(),
            'sort' => $sort,
            'direction' => $direction,
            'search' => $request->search,
        ]);
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->storeAs(
                'profile_pictures',
                uniqid() . '.' . $request->file('profile_picture')->getClientOriginalExtension(),
                'public'
            );
        }

        Contact::create($data);

        return redirect()->route('dashboard')->with('success', 'Contact added!');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($contact->profile_picture) {
                Storage::disk('public')->delete($contact->profile_picture);
            }

            $data['profile_picture'] = $request->file('profile_picture')->storeAs(
                'profile_pictures',
                uniqid() . '.' . $request->file('profile_picture')->getClientOriginalExtension(),
                'public'
            );
        }

        $contact->update($data);

        return redirect()->route('dashboard')->with('success', 'Contact updated!');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->profile_picture) {
            Storage::disk('public')->delete($contact->profile_picture);
        }

        $contact->delete();

        return redirect()->route('dashboard')->with('success', 'Contact deleted!');
    }
}
