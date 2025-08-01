<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div id="alertBox" class="hidden mb-4 p-3 rounded-lg"></div>

            <div class="flex justify-between mb-4">
                <input type="text" id="searchInput" placeholder="Search name or email" class="border rounded-l-lg px-3 py-2 w-64">
                <button id="searchBtn" class="bg-blue-500 text-white px-4 rounded-r-lg">Search</button>

                <a href="{{ route('contacts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">+ Add Contact</a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-left">Photo</th>
                            <th class="border p-3 text-left">Name</th>
                            <th class="border p-3 text-left">Email</th>
                            <th class="border p-3 text-left">Phone</th>
                            <th class="border p-3 text-left">Company</th>
                            <th class="border p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contactsTable"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function fetchContacts(query = "") {
            let token = localStorage.getItem("token");
            if (!token) {
                alert("Not logged in.");
                window.location.href = "/login";
                return;
            }

            let response = await fetch(`/api/contacts?search=${query}`, {
                headers: { "Authorization": "Bearer " + token }
            });
            let data = await response.json();

            let tbody = document.getElementById("contactsTable");
            tbody.innerHTML = "";

            if (data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-gray-500">No contacts found.</td></tr>`;
                return;
            }

            data.data.forEach(contact => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">${contact.photo_path ? `<img src="/storage/${contact.photo_path}" class="w-10 h-10 rounded-full object-cover">` : `<span class="text-gray-400">No Photo</span>`}</td>
                        <td class="border p-3">${contact.name}</td>
                        <td class="border p-3">${contact.email || "-"}</td>
                        <td class="border p-3">${contact.phone || "-"}</td>
                        <td class="border p-3">${contact.company || "-"}</td>
                        <td class="border p-3 text-center">
                            <a href="/contacts/${contact.id}/edit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                            <button onclick="deleteContact(${contact.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </td>
                    </tr>
                `;
            });
        }

        async function deleteContact(id) {
            if (!confirm("Delete this contact?")) return;

            let token = localStorage.getItem("token");
            let response = await fetch(`/api/contacts/${id}`, {
                method: "DELETE",
                headers: { "Authorization": "Bearer " + token }
            });

            if (response.ok) {
                fetchContacts();
            } else {
                alert("Failed to delete contact");
            }
        }

        document.getElementById("searchBtn").addEventListener("click", () => {
            let query = document.getElementById("searchInput").value;
            fetchContacts(query);
        });

        fetchContacts();
    </script>
</x-app-layout>
