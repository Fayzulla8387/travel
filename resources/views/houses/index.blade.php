@extends('adminpanel.master')

@section('title', 'Houses List')

@section('admin')
    <h1 class="mb-4">Houses List</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createHouseModal">Add New House</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Address</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($houses as $house)
            <tr>
                <td>{{ $house->id }}</td>
                <td>{{ $house->address }}</td>
                <td>${{ $house->price }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editHouseModal" onclick="openEditModal({{ $house->id }})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $house->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Create Modal -->
    <div class="modal fade" id="createHouseModal" tabindex="-1" aria-labelledby="createHouseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createHouseModalLabel">Add New House</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="size" class="form-label">Size (sqm)</label>
                            <input type="number" class="form-control" id="size" name="size" required>
                        </div>
                        <div class="mb-3">
                            <label for="bedrooms" class="form-label">Bedrooms</label>
                            <input type="number" class="form-control" id="bedrooms" name="bedrooms" required>
                        </div>
                        <div class="mb-3">
                            <label for="bathrooms" class="form-label">Bathrooms</label>
                            <input type="number" class="form-control" id="bathrooms" name="bathrooms" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editHouseModal" tabindex="-1" aria-labelledby="editHouseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHouseModalLabel">Edit House</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="editImage" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="editSize" class="form-label">Size (sqm)</label>
                            <input type="number" class="form-control" id="editSize" name="size" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBedrooms" class="form-label">Bedrooms</label>
                            <input type="number" class="form-control" id="editBedrooms" name="bedrooms" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBathrooms" class="form-label">Bathrooms</label>
                            <input type="number" class="form-control" id="editBathrooms" name="bathrooms" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openEditModal(id) {
            fetch(`/houses/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch house data');
                    }
                    return response.json();
                })
                .then(data => {
                    const form = document.getElementById('editForm');
                    form.action = `/houses/${id}`;
                    document.getElementById('editAddress').value = data.address;
                    document.getElementById('editPrice').value = data.price;
                    document.getElementById('editSize').value = data.size;
                    document.getElementById('editBedrooms').value = data.bedrooms;
                    document.getElementById('editBathrooms').value = data.bathrooms;
                    document.getElementById('editDescription').value = data.description;

                    const modal = new bootstrap.Modal(document.getElementById('editHouseModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this house?')) {
                fetch(`/houses/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to delete house');
                        }
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }

    </script>
@endsection





