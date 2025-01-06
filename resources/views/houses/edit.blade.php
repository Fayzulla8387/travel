@extends('adminpanel.master')
@section('title', 'Houses Edit')
@section('admin')

    <div class="container">
        <h1>Edit House</h1>

        <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $house->address }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $house->price }}" required>
            </div>

            <div class="mb-3">
                <label for="size" class="form-label">Size (m²)</label>
                <input type="number" class="form-control" id="size" name="size" value="{{ $house->size }}" required>
            </div>

            <div class="mb-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ $house->bedrooms }}" required>
            </div>

            <div class="mb-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ $house->bathrooms }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $house->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                @if($house->image)
                    <img src="{{ asset('storage/' . $house->image) }}" alt="Current Image" class="img-thumbnail mt-2" style="max-height: 200px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

