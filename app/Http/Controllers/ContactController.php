<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactListsExport;
use Illuminate\Support\Facades\Cache;

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

        // ✅ Cache Dashboard Stats for 10 minutes
        $contactsCount = Cache::remember('contacts_count', 600, fn() => Contact::count());
        $contactsAddedToday = Cache::remember('contacts_added_today', 600, fn() => Contact::whereDate('created_at', today())->count());
        $lastUpdatedContact = Cache::remember('last_updated_contact', 600, fn() => Contact::latest('updated_at')->first());

        return view('dashboard', [
            'contacts' => $contacts,
            'contactsCount' => $contactsCount,
            'contactsAddedToday' => $contactsAddedToday,
            'lastUpdatedContact' => $lastUpdatedContact,
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
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->storeAs(
                'profile_pictures',
                uniqid() . '.' . $request->file('profile_picture')->getClientOriginalExtension(),
                'public'
            );
        }

        $contact = Contact::create($data);

        // ✅ Log + Send Email
        ActivityLogger::log('Added Contact', [
            'old' => null,
            'new' => $contact->only(['name', 'email', 'phone', 'company', 'address', 'notes']),
        ], $contact);

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
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $oldData = $contact->only(['name', 'email', 'phone', 'company', 'address', 'notes']);

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

        if ($request->has('remove_picture') && $request->remove_picture == '1') {
            if ($contact->profile_picture) {
                Storage::disk('public')->delete($contact->profile_picture);
                $data['profile_picture'] = null; // Remove from DB
            }
        }

        $contact->update($data);

        // ✅ Only log changed fields
        $newData = $contact->only(['name', 'email', 'phone', 'company', 'address', 'notes']);
        $changedOld = [];
        $changedNew = [];

        foreach ($newData as $key => $value) {
            if ($oldData[$key] !== $value) {
                $changedOld[$key] = $oldData[$key];
                $changedNew[$key] = $value;
            }
        }

        if (!empty($changedNew)) {
            ActivityLogger::log('Edited Contact', [
                'old' => $changedOld,
                'new' => $changedNew,
            ], $contact);
        }

        return redirect()->route('dashboard')->with('success', 'Contact updated!');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->profile_picture) {
            Storage::disk('public')->delete($contact->profile_picture);
        }

        $oldData = $contact->only(['name', 'email', 'phone', 'company', 'address', 'notes']);

        // ✅ Log + Email before deletion
        ActivityLogger::log('Deleted Contact', [
            'old' => $oldData,
            'new' => null,
        ], $contact);

        $contact->delete();

        return redirect()->route('dashboard')->with('success', 'Contact deleted!');
    }

    public function export()
    {
        return Excel::download(new ContactListsExport, 'contacts.xlsx');
    }
}
