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
                <label class="block font-medium">Profile Picture [jpg,jpeg,png|max:2048]</label>

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
    </script>
</x-app-layout>
