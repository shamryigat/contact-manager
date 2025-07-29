<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- 🔹 Cache Info -->
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-gray-500">
                    <strong>Last Updated:</strong> {{ $lastUpdated }}
                </p>
                <a href="{{ route('dashboard.refresh') }}" 
                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                    Refresh Cache
                </a>
            </div>

            <!-- 🔹 Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-gray-500 text-sm">Total Contacts</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalContacts }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-gray-500 text-sm">Recently Added</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $recentContacts->count() }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-gray-500 text-sm">Last Updated</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ $recentContacts->first()?->name ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- 🔹 Recent Contacts Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold">Recent Contacts</h3>
                </div>

                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-left">Photo</th>
                            <th class="border p-3 text-left">Name</th>
                            <th class="border p-3 text-left">Email</th>
                            <th class="border p-3 text-left">Company</th>
                            <th class="border p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentContacts as $contact)
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
                                <td class="border p-3">{{ $contact->email ?? '-' }}</td>
                                <td class="border p-3">{{ $contact->company ?? '-' }}</td>
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
                                <td colspan="5" class="border p-4 text-center text-gray-500">No recent contacts.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Quick Actions -->
            <div class="mt-4">
                <a href="{{ route('contacts.create') }}" 
                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">+ Add New Contact</a>
                <a href="{{ route('contacts.index') }}" 
                   class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">View All Contacts</a>
            </div>
        </div>
    </div>
</x-app-layout>
