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

                <!-- Address with Map Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <div class="flex gap-2">
                        <input type="text" id="address-input" name="address" 
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        <button type="button" id="find-address" 
                            class="bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600">Find</button>
                    </div>
                    <div id="map-preview" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-1">Map Preview:</p>
                        <div id="map" style="width: 100%; height: 300px;" class="border rounded-lg"></div>
                    </div>
                </div>

                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture [jpg,jpeg,png|max:2048]</label>
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

    <script>
        let map, geocoder, marker;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: { lat: 3.139, lng: 101.6869 } // Default to Kuala Lumpur
            });
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

        // Initialize Map when page loads
        window.onload = initMap;

        // Profile Picture Preview
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
