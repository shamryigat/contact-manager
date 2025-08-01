<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">Photo</th>
                <th class="border p-3">Name</th>
                <th class="border p-3">Phone</th>
                <th class="border p-3">Email</th>
                <th class="border p-3">Company</th>
                <th class="border p-3">Notes</th>
                <th class="border p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td class="border p-3 text-center">
                        @if($contact->profile_picture)
                            <img src="{{ asset('storage/'.$contact->profile_picture) }}" class="h-10 w-10 rounded-full">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">👤</div>
                        @endif
                    </td>
                    <td class="border p-3">{{ $contact->name }}</td>
                    <td class="border p-3">{{ $contact->phone ?? '-' }}</td>
                    <td class="border p-3">{{ $contact->email ?? '-' }}</td>
                    <td class="border p-3">{{ $contact->company ?? '-' }}</td>
                    <td class="border p-3">{{ $contact->notes ?? '-' }}</td>
                    <td class="border p-3">
                        <a href="{{ route('contacts.edit',$contact) }}" class="text-blue-500">Edit</a>
                        <form action="{{ route('contacts.destroy',$contact) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this contact?')" class="text-red-500 ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="border p-3 text-center">No contacts found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-3 border-t">
        @if($contacts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $contacts->links() }}
        @endif
    </div>
</div>
