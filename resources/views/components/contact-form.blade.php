<div id="contactFormWrapper">
    <div id="errorMessage" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded-lg"></div>
    <div id="successMessage" class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded-lg"></div>

    <form id="contactForm" enctype="multipart/form-data">
        <!-- Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Name *</label>
            <input type="text" id="name" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Email</label>
            <input type="email" id="email" class="w-full border rounded-lg px-3 py-2">
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Phone</label>
            <input type="text" id="phone" class="w-full border rounded-lg px-3 py-2">
        </div>

        <!-- Company -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Company</label>
            <input type="text" id="company" class="w-full border rounded-lg px-3 py-2">
        </div>

        <!-- Notes -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Notes</label>
            <textarea id="notes" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>

        <!-- Photo -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Photo</label>
            <input type="file" id="photo" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex justify-between">
            <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</a>
            <button type="submit" id="submitBtn" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Save Contact
            </button>
        </div>
    </form>
</div>
