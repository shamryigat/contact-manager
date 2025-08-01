<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Contact') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('contacts.update', $contact) }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $contact->name) }}" class="border rounded w-full p-2" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="border rounded w-full p-2">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block font-medium">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="border rounded w-full p-2">
            </div>

            <!-- Company -->
            <div class="mb-4">
                <label class="block font-medium">Company</label>
                <input type="text" name="company" value="{{ old('company', $contact->company) }}" class="border rounded w-full p-2">
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <label class="block font-medium">Notes</label>
                <textarea name="notes" class="border rounded w-full p-2">{{ old('notes', $contact->notes) }}</textarea>
            </div>

            <!-- Profile Picture -->
            <div class="mb-4">
                <label class="block font-medium">Profile Picture</label>

                @if($contact->profile_picture)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $contact->profile_picture) }}" alt="Profile Picture" class="h-20 w-20 rounded-full object-cover border">
                    </div>
                @endif

                <input type="file" name="profile_picture" class="border rounded w-full p-2">
                <p class="text-sm text-gray-500 mt-1">Leave blank to keep the current picture.</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Contact</button>
                <a href="{{ route('dashboard') }}" class="bg-gray-300 px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
