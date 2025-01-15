@extends('client.index')

@section('content')
    <div class="row mt-3 mb-3">
        <div class="col-5">
            <h3 class="mb-4">Products</h3>
            <a href="{{route('back.product')}}" class="btn btn-primary mb-3">Back</a>
            <ul class="list-group">
                @foreach ($product_variants as $product_variant)
                    <li class="list-group-item">
                        <a href="" class="text-decoration-none">{{ $product_variant->attribute_name }}</a>
                        <h4>{{$product_variant->price_difference}} $</h4>
                        <h4>{{$product_variant->attribute_value}} </h4>
                    </li>
                    <div style="overflow-x: auto; white-space: nowrap; max-width: 100%; border: 1px solid #ccc; padding: 10px;">
                        @foreach ($product_variant->images as $image)
                            <img src="{{ asset($image->image_url) }}" width="200px" class="mt-3 d-inline-block">
                        @endforeach
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
