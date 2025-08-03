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

            <!-- Address -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <div class="flex gap-2">
                    <input type="text" id="address-input" name="address" 
                            value="{{ old('address', $contact->address) }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="find-address" 
                            class="bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600">Find</button>
                </div>
                <div id="map-preview" class="mt-3 {{ $contact->address ? '' : 'hidden' }}">
                    <p class="text-sm text-gray-600 mb-1">Map Preview:</p>
                    <div id="map" style="width: 100%; height: 300px;" class="border rounded-lg"></div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <label class="block font-medium">Notes</label>
                <textarea name="notes" class="border rounded w-full p-2">{{ old('notes', $contact->notes) }}</textarea>
            </div>

            <!-- Profile Picture -->
            <div class="mb-4">
                <label class="block font-medium">Profile Picture [jpg,jpeg,png|max:5MB]</label>

                @if($contact->profile_picture)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $contact->profile_picture) }}" 
                            class="h-20 w-20 rounded-full object-cover border">
                    </div>

                    <!-- Remove Picture Checkbox -->
                    <label class="flex items-center gap-2 text-sm text-red-600">
                        <input type="checkbox" name="remove_picture" value="1">
                        Remove Current Picture
                    </label>
                @endif

                <input type="file" name="profile_picture" id="profile_picture" class="border rounded w-full p-2">
                <button type="button" id="remove-selected" 
                    class="mt-2 px-3 py-1 bg-red-500 text-white text-sm rounded hidden">
                    Remove Selected Picture
                </button>

                <div id="preview-container" class="mt-3 hidden">
                    <p class="text-sm text-gray-600 mb-1">Preview:</p>
                    <img id="preview-image" class="h-20 w-20 rounded-full object-cover border">
                </div>
            </div>

            <!-- Backend Validation Error -->
            @error('profile_picture')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Custom Frontend Error -->
            <p id="profile-error" class="text-red-500 text-sm mt-1 hidden"></p>

            <!-- Preview -->
            <div id="preview-container" class="mt-3 hidden">
                <p class="text-sm text-gray-600 mb-1">Preview:</p>
                <img id="preview-image" class="h-20 w-20 rounded-full object-cover border">
            </div>
            {{-- </div> --}}

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Contact</button>
                <a href="{{ route('dashboard') }}" class="bg-gray-300 px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        let map, geocoder, marker;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: { lat: 3.139, lng: 101.6869 }
            });

            // If contact already has an address, show it
            const existingAddress = document.getElementById("address-input").value;
            if (existingAddress) {
                geocoder.geocode({ address: existingAddress }, function (results, status) {
                    if (status === "OK") {
                        map.setCenter(results[0].geometry.location);
                        marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                    }
                });
            }
        }

        document.getElementById("find-address").addEventListener("click", function () {
            const address = document.getElementById("address-input").value;
            if (!address) {
                alert("Please enter an address.");
                return;
            }

            geocoder.geocode({ address: address }, function (results, status) {
                if (status === "OK") {
                    document.getElementById("map-preview").classList.remove("hidden");
                    map.setCenter(results[0].geometry.location);

                    if (marker) marker.setMap(null);
                    marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert("Geocode failed: " + status);
                }
            });
        });

        window.onload = initMap;

        document.getElementById("profile_picture").addEventListener("change", function (event) {
            const file = event.target.files[0];
            const removeBtn2 = document.getElementById("remove-selected");
            const errorMsg = document.getElementById("profile-error");
            const previewContainer = document.getElementById("preview-container");
            const previewImage = document.getElementById("preview-image");

            fileInput2.addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage2.src = e.target.result;
                    previewContainer2.classList.remove("hidden");
                    removeBtn2.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            });

            removeBtn2.addEventListener("click", function () {
                fileInput2.value = "";
                previewContainer2.classList.add("hidden");
                removeBtn2.classList.add("hidden");
            });

            // Reset
            errorMsg.classList.add("hidden");
            errorMsg.textContent = "";
            previewContainer.classList.add("hidden");

            if (!file) return;

            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                errorMsg.textContent = "Invalid file format. Please upload jpg, jpeg, or png.";
                errorMsg.classList.remove("hidden");
                event.target.value = "";
                return;
            }

            if (file.size > maxSize) {
                errorMsg.textContent = "File size exceeds 5MB limit.";
                errorMsg.classList.remove("hidden");
                event.target.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
