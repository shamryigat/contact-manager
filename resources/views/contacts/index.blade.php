<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 🔹 Flash Message -->
            @if(session('success'))
                <div class="mb-4 p-3 text-green-800 bg-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- 🔹 Search Bar + Add Button -->
            <div class="flex justify-between mb-4">
                <form method="GET" action="{{ route('contacts.index') }}" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="border rounded-l-lg px-3 py-2 w-64"
                        placeholder="Search name or email">
                    <button class="bg-blue-500 text-white px-4 rounded-r-lg">Search</button>
                </form>

                <a href="{{ route('contacts.create') }}" 
                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    + Add Contact
                </a>
            </div>

            <!-- 🔹 Contacts Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-left">Photo</th>
                            <th class="border p-3 text-left">Name</th>
                            <th class="border p-3 text-left">Email</th>
                            <th class="border p-3 text-left">Phone</th>
                            <th class="border p-3 text-left">Company</th>
                            <th class="border p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">
                                    @if($contact->photo_path)
                                        <img src="{{ asset('storage/'.$contact->photo_path) }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span class="text-gray-400">No Photo</span>
                                    @endif
                                </td>
                                <td class="border p-3">{{ $contact->name }}</td>
                                <td class="border p-3">{{ $contact->email }}</td>
                                <td class="border p-3">{{ $contact->phone }}</td>
                                <td class="border p-3">{{ $contact->company }}</td>
                                <td class="border p-3 text-center">
                                    <a href="{{ route('contacts.edit', $contact) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                                    <form action="{{ route('contacts.destroy', $contact) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this contact?')" 
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-4 text-center text-gray-500">No contacts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Pagination -->
            <div class="mt-4">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
