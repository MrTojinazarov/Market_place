@extends('admin.index')

@section('name', 'Product Images')

@section('content')
<div class="container">
    <h2>Product Images</h2>
    
    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Add Image</button>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <strong>{{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Variant</th>
                <th>Image</th>
                <th>Is Main</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
            <tr>
                <td>{{ $image->id }}</td>
                <td>{{ $image->product_variant->attribute_name ?? 'Unknown' }}</td>
                <td><img src="{{ asset($image->image_url) }}" alt="Image" style="width: 80px;"></td>
                <td>{{ $image->is_main ? 'Yes' : 'No' }}</td>
                <td>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $image->id }}">Edit</button>
                    <form action="{{ route('product_image.destroy', $image->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="editModal{{ $image->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('product_image.update', $image->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5>Edit Image</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="product_variant_id">Product Variant</label>
                                    <select name="product_variant_id" class="form-control">
                                        @foreach($variants as $variant)
                                        <option value="{{ $variant->id }}" {{ $variant->id == $image->product_variant_id ? 'selected' : '' }}>{{ $variant->attribute_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image_url">Image</label>
                                    <input type="file" class="form-control mb-2" name="image_url">
                                    <input type="hidden" name="old_img" value="{{$image->image_url}}">
                                    <img src="{{ asset($image->image_url) }}" alt="Image" style="width: 80px;">
                                </div>
                                <div class="form-group">
                                    <label for="is_main">Is Main</label>
                                    <input type="checkbox" name="is_main" {{ $image->is_main ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('product_image.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5>Add New Image</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_variant_id">Product Variant</label>
                            <select name="product_variant_id" class="form-control" required>
                                @foreach($variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->attribute_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image_url">Image</label>
                            <input type="file" class="form-control" name="image_url" required>
                        </div>
                        <div class="form-group">
                            <label for="is_main">Is Main</label>
                            <input type="checkbox" name="is_main" value="1">
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
