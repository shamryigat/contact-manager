<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">Photo</th>
                <th class="border p-3">Name</th>
                <th class="border p-3">Phone</th>
                <th class="border p-3">Email</th>
                <th class="border p-3">Company</th>
                <th class="border p-3">Address</th> <!-- ✅ Added -->
                <th class="border p-3">Notes</th>
                <th class="border p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td class="border p-3 text-center">
                        @if($contact->profile_picture)
                            <img src="{{ asset('storage/'.$contact->profile_picture) }}" class="h-10 w-10 rounded-full">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">👤</div>
                        @endif
                    </td>
                    <td class="border p-3">{{ $contact->name }}</td>
                    <td class="border p-3">{{ $contact->phone ?? '-' }}</td>
                    <td class="border p-3">{{ $contact->email ?? '-' }}</td>
                    <td class="border p-3">{{ $contact->company ?? '-' }}</td>
                    <td class="border p-3">
                        {{ $contact->address ?? '-' }}
                        @if($contact->address)
                            <button onclick="showMapModal('{{ $contact->address }}')" 
                                    class="text-blue-500 underline ml-1">View Map</button>
                        @endif
                    </td>
                    <td class="border p-3">{{ $contact->notes ?? '-' }}</td>
                    <td class="border p-3 flex flex-col gap-1">
                        <a href="{{ route('contacts.edit',$contact) }}" class="text-blue-500">Edit</a>

                        <form action="{{ route('contacts.destroy',$contact) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this contact?')" 
                                    class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="border p-3 text-center">No contacts found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-3 border-t">
        @if($contacts instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $contacts->links() }}
        @endif
    </div>
</div>

<!-- 📍 Google Maps Modal -->
<div id="mapModal" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-4 rounded shadow-lg w-96 relative">
        <button onclick="closeMapModal()" 
                class="absolute top-2 right-2 text-gray-500">✖</button>
        <h3 class="text-lg font-bold mb-2">Contact Location</h3>
        <div id="map" style="width: 100%; height: 300px;"></div>
    </div>
</div>

<!-- Google Maps Script -->
<script>
    let mapModal = document.getElementById("mapModal");

    function showMapModal(address) {
        if (!address) {
            alert("No address available for this contact.");
            return;
        }

        mapModal.classList.remove("hidden");
        mapModal.classList.add("flex");

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, function(results, status) {
            if (status === "OK") {
                let map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: results[0].geometry.location
                });
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert("Geocode failed: " + status);
            }
        });
    }

    function closeMapModal() {
        mapModal.classList.add("hidden");
        mapModal.classList.remove("flex");
    }
</script>
