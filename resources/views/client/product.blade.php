@extends('client.index')

@section('content')
    <div class="row mt-3 mb-3">
        <div class="col-md-5">
            <h3 class="mb-4">Products</h3>
            <ul class="list-group">
                @foreach ($products as $product)
                    <li class="list-group-item">
                        <a href="{{route('client.product-variant', $product->id)}}" class="text-decoration-none">{{ $product->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
