<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Contact') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- 🔹 Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Name *</label>
                        <input type="text" name="name" value="{{ old('name', $contact->name) }}"
                               class="w-full border rounded-lg px-3 py-2" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email', $contact->email) }}"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <!-- Company -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Company</label>
                        <input type="text" name="company" value="{{ old('company', $contact->company) }}"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('notes', $contact->notes) }}</textarea>
                    </div>

                    <!-- Current Photo -->
                    @if ($contact->photo_path)
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Current Photo</label>
                            <img src="{{ asset('storage/'.$contact->photo_path) }}" 
                                 class="w-20 h-20 rounded-full object-cover mb-2">
                        </div>
                    @endif

                    <!-- New Photo -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Replace Photo</label>
                        <input type="file" name="photo" 
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between">
                        <a href="{{ route('contacts.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</a>

                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update Contact</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
