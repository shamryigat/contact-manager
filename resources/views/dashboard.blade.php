<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 📊 Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @php
                    $stats = [
                        ['icon' => '👥', 'label' => 'Total Contacts', 'value' => $contactsCount ?? 0, 'color' => 'blue'],
                        ['icon' => '➕', 'label' => 'Added Today', 'value' => $contactsAddedToday, 'color' => 'green'],
                        ['icon' => '⏰', 'label' => 'Last Updated', 'value' => $lastUpdatedContact ? $lastUpdatedContact->updated_at->diffForHumans() : 'N/A', 'color' => 'yellow'],
                        ['icon' => '👤', 'label' => 'Last Updated Contact', 'value' => $lastUpdatedContact->name ?? 'N/A', 'color' => 'purple'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="bg-white p-4 rounded-lg shadow flex items-center gap-3">
                        <div class="p-3 rounded-full bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600 text-xl">
                            {{ $stat['icon'] }}
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                            <p class="text-xl font-semibold break-words">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 🔍 Search, Sort & Buttons -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <!-- Search + Sort -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-2">
                        <input type="text" name="search" placeholder="Search..."
                            value="{{ request('search') }}"
                            class="border rounded-lg p-2 w-full sm:w-48 lg:w-64">

                        <select name="sort" class="border rounded-lg p-2 w-full sm:w-40">
                            <option value="name" {{ request('sort')=='name'?'selected':'' }}>Sort by Name</option>
                            <option value="email" {{ request('sort')=='email'?'selected':'' }}>Sort by Email</option>
                            <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Sort by Created</option>
                        </select>

                        <select name="direction" class="border rounded-lg p-2 w-full sm:w-40">
                            <option value="asc" {{ request('direction')=='asc'?'selected':'' }}>Ascending</option>
                            <option value="desc" {{ request('direction')=='desc'?'selected':'' }}>Descending</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 w-full sm:w-auto">
                            Apply
                        </button>
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('contacts.create') }}"
                           class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 w-full sm:w-auto text-center">
                            Add Contact
                        </a>
                        <a href="{{ route('contacts.export') }}"
                           class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 w-full sm:w-auto text-center">
                            Export to Excel
                        </a>
                    </div>
                </div>
            </div>

            <!-- 📋 Contacts Table -->
            <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                @include('contacts.partials.table', ['contacts' => $contacts])
            </div>

        </div>
    </div>
</x-app-layout>
