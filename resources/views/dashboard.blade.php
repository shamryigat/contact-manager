<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ✅ Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">👥</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Contacts</p>
                        <p class="text-2xl font-bold">{{ $contactsCount ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">➕</div>
                    <div>
                        <p class="text-sm text-gray-500">Added Today</p>
                        <p class="text-2xl font-bold">{{ $contactsAddedToday }}</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">⏰</div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="text-lg font-semibold">
                            {{ $lastUpdatedContact ? $lastUpdatedContact->updated_at->diffForHumans() : 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-full">👤</div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated Contact</p>
                        <p class="text-lg font-semibold">
                            {{ $lastUpdatedContact->name ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            
<!-- ✅ Search, Sort, and Add Contact in One Row -->
<div class="mb-4 flex justify-between items-center">
    <!-- 🔍 Search & Sort -->
    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2">
        <input type="text" name="search" placeholder="Search..."
            value="{{ request('search') }}"
            class="border rounded-lg p-2 w-64">

        <select name="sort" class="border rounded-lg p-2 w-48">
            <option value="name" {{ request('sort')=='name'?'selected':'' }}>Sort by Name</option>
            <option value="email" {{ request('sort')=='email'?'selected':'' }}>Sort by Email</option>
            <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Sort by Created</option>
        </select>

        <select name="direction" class="border rounded-lg p-2 w-48">
            <option value="asc" {{ request('direction')=='asc'?'selected':'' }}>Ascending</option>
            <option value="desc" {{ request('direction')=='desc'?'selected':'' }}>Descending</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
            Apply
        </button>
    </form>

    <!-- ➕ Add Contact Button -->
    <a href="{{ route('contacts.create') }}"
       class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
        ➕ Add Contact
    </a>
</div>

            <!-- ✅ Contacts Table -->
            @include('contacts.partials.table', ['contacts' => $contacts])

        </div>
    </div>
</x-app-layout>
