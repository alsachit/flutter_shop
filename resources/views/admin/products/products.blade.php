@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Products') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4 text-center">
                                    <div class="alert alert-primary">
                                        <h5>{{ $product->title }}</h5>
                                        <p>Category: {{ $product->category->name }}</p>
                                        <p>Price: {{ $currency_code }}{{ $product->price }}</p>
                                        {!! (count($product->images) > 0) ? '<img class="img-thumbnail img-fluid card-img" src="'. $product->images[0]->url .'"/> ' : '<img class="img-thumbnail" src="https://www.eduprizeschools.net/wp-content/uploads/2016/06/No_Image_Available.jpg"/>' !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
