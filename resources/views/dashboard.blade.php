@php
$cards = \App\Models\Card::all();
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ "COD shop Dashboard " }}<small>made by salman osama</small>
            </h2>
            <a href="{{ route('site') }}" class="text-xl font-italic text-gray-800 dark:text-gray-200 hover:text-blue-500">
                {{ "Visit COD shop Site" }}
            </a>
        </div>
    </x-slot>
    <style>
        html, body {
            background-color: #000 !important;
        }

        .cod-container {
            background-color: #0a0a0a;
            border: 1px solid #1f1f1f;
        }

        .cod-header {
            color: #00ffc8;
        }

        .cod-btn {
            background-color: #00ffc8;
            color: #000;
            font-weight: bold;
        }

        .cod-btn:hover {
            background-color: #00dab1;
        }

        .cod-table th {
            background-color: #111;
            color: #00ffc8;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .cod-table td {
            background-color: #0f0f0f;
            color: #eaeaea;
        }

        .edit-btn {
            background-color: #ffc400;
            color: #000;
            font-weight: bold;
        }

        .edit-btn:hover {
            background-color: #e6ad00;
        }

        .delete-btn {
            background-color: #ff3d3d;
            color: #fff;
            font-weight: bold;
        }

        .delete-btn:hover {
            background-color: #cc2e2e;
        }

        .no-data {
            color: #666;
        }
    </style>

    <div class="py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="cod-container shadow-xl rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold cod-header">Your COD Point Packages</h3>
                    <button id="createCardBtn" class="cod-btn px-4 py-2 rounded shadow hover:shadow-md transition">
                        + New Package
                    </button>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-800 cod-table text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">COD Points</th>
                                <th class="px-4 py-3 text-left">Price</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-900" id="cardsTableBody">
                            @foreach ($cards as $card)
                                <tr data-card-id="{{ $card->id }}" class="text-centre">
                                    <td class="px-4 py-2 text-center">{{ $card->id }}</td>
                                    <td class="px-4 py-2 card-value text-center">{{ $card->value }}</td>
                                    <td class="px-4 py-2 card-price text-center">${{ number_format($card->price, 2) }}</td>
                                    <td class="px-4 py-2 space-x-2 text-center">
                                        <button class="edit-btn px-3 py-1 rounded hover:shadow" onclick="openEditModal({{ $card->id }}, '{{ $card->value }}', '{{ $card->price }}')">Edit</button>
                                        <button class="delete-btn px-3 py-1 rounded hover:shadow" onclick="confirmDelete({{ $card->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                

                @if($cards->isEmpty())
                    <div class="mt-6 text-center no-data">No COD Point packages found.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createPackageModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-black p-6 rounded-lg shadow-xl">
            <h3 class="text-xl font-semibold text-white">Create New Package</h3>
            <form method="POST" action="{{ route('cards.store') }}">
                @csrf
                <div class="mt-4">
                    <label for="value" class="text-white">COD Points</label>
                    <input type="number" name="value" id="value" required class="mt-1 block w-full p-2 bg-gray-800 text-white rounded-md">
                </div>
                <div class="mt-4">
                    <label for="price" class="text-white">Price</label>
                    <input type="number" name="price" id="price" required class="mt-1 block w-full p-2 bg-gray-800 text-white rounded-md">
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" class="text-gray-500" onclick="closeModal('createPackageModal')">Cancel</button>
                    <button type="submit" class="cod-btn px-4 py-2">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editPackageModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-black p-6 rounded-lg shadow-xl">
            <h3 class="text-xl font-semibold text-white">Edit Package</h3>
            <form id="editCardForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <label for="edit_value" class="text-white">COD Points</label>
                    <input type="number" name="value" id="edit_value" required class="mt-1 block w-full p-2 bg-gray-800 text-white rounded-md">
                </div>
                <div class="mt-4">
                    <label for="edit_price" class="text-white">Price</label>
                    <input type="number" name="price" id="edit_price" required class="mt-1 block w-full p-2 bg-gray-800 text-white rounded-md">
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" class="text-gray-500" onclick="closeModal('editPackageModal')">Cancel</button>
                    <button type="submit" class="cod-btn px-4 py-2">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('createCardBtn').addEventListener('click', function () {
            document.getElementById('createPackageModal').classList.remove('hidden');
        });

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openEditModal(id, value, price) {
            document.getElementById('edit_value').value = value;
            document.getElementById('edit_price').value = price;
            const form = document.getElementById('editCardForm');
            form.action = `/cards/${id}`;
            document.getElementById('editPackageModal').classList.remove('hidden');
        }

        function confirmDelete(cardId) {
            if (confirm('Are you sure?')) {
                fetch(`/cards/${cardId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.ok ? location.reload() : alert('Failed'));
            }
        }
    </script>

</x-app-layout>
