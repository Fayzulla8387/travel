@extends('adminpanel.master')

@section('title', 'Houses List')

@section('admin')
    <div class="d-flex justify-content-between align-items-center mb-4 container">
        <h1>Houses List</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHouseModal">Add New House</button>
    </div>
    <div id="alertPlaceholder"></div>
    <table class="table table-bordered container">
        <thead>
        <tr>
            <th>#</th>
            <th>Address</th>
            <th>Price</th>
            <th>Size</th>
            <th>Bedrooms</th>
            <th>Bathrooms</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($houses as $index => $house)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $house->address }}</td>
                <td>{{ $house->price }} $</td>
                <td>{{ $house->size }} m<sup>2</sup></td>
                <td>{{ $house->bedrooms }}</td>
                <td>{{ $house->bathrooms }}</td>
                <td>
                    @if ($house->image)
                        <img src="{{ asset('storage/' . $house->image) }}" alt="House Image" width="100">
                    @else
                        <span>No Image</span>
                    @endif

                </td>
                <td class="text-center">
                    <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning btn-sm">Edit</a>
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



@endsection

@section('scripts')
    <script>

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
                        return response.json();
                    })
                    .then(data => {
                        // Remove the house row from the table
                        const row = document.querySelector(`button[onclick="confirmDelete(${id})"]`).closest('tr');
                        row.remove();

                        // Show a success alert
                        showAlert('House deleted successfully.', 'success');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('There was an error deleting the house.', 'danger');
                    });
            }
        }

        function showAlert(message, type) {
            const alertPlaceholder = document.getElementById('alertPlaceholder');
            const alert = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            alertPlaceholder.innerHTML = alert;
            setTimeout(() => {
                const alertElement = alertPlaceholder.querySelector('.alert');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 1000); // Auto-dismiss after 5 seconds
        }



    </script>
@endsection





