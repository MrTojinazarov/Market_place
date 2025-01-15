@extends('admin.index')

@section('name', 'Product Variants')

@section('content')
<div class="container">
    <h2>Product Variants</h2>

    <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create Variant</button>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Attribute Name</th>
                <th>Attribute Value</th>
                <th>Price Difference</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productVariants as $variant)
            <tr>
                <td>{{ $variant->id }}</td>
                <td>{{ $variant->product->name }}</td>
                <td>{{ $variant->attribute_name }}</td>
                <td>{{ $variant->attribute_value }}</td>
                <td>{{ $variant->price_difference }} $</td>
                <td>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $variant->id }}">Edit</button>
                    <form action="{{ route('product_variant.destroy', $variant->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $variant->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Variant</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('product_variant.update', $variant->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="attribute_name">Attribute Name</label>
                                    <input type="text" class="form-control" name="attribute_name" value="{{ $variant->attribute_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="attribute_value">Attribute Value</label>
                                    <input type="text" class="form-control" name="attribute_value" value="{{ $variant->attribute_value }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="price_difference">Price Difference</label>
                                    <input type="number" step="0.01" class="form-control" name="price_difference" value="{{ $variant->price_difference }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('product_variant.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select name="product_id" class="form-control" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="attribute_name">Attribute Name</label>
                            <input type="text" class="form-control" name="attribute_name" >
                        </div>
                        <div class="form-group">
                            <label for="attribute_value">Attribute Value</label>
                            <input type="text" class="form-control" name="attribute_value" required>
                        </div>
                        <div class="form-group">
                            <label for="price_difference">Price Difference</label>
                            <input type="number" step="0.01" class="form-control" name="price_difference" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
