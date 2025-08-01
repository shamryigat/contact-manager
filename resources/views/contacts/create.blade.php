<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add Contact') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6">
            <form id="contactForm" method="POST" action="{{ route('contacts.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                    <input type="text" name="company" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="w-full text-sm border rounded-lg p-2 bg-gray-50">
                    <div id="preview-container" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-1">Preview:</p>
                        <img id="preview-image" class="h-20 w-20 rounded-full object-cover border">
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="4" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Save Contact</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Profile Picture Preview Script -->
    <script>
        document.getElementById("profile_picture").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const previewContainer = document.getElementById("preview-container");
            const previewImage = document.getElementById("preview-image");

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
