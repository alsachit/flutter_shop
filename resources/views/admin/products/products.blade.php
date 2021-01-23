@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span class="add-btn">
                            <div class="row">
                                <div class="col-md-6 align-middle">
                                    <h5>{{ __('Products') }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('new-product') }}" class="btn btn-primary float-right">Add Product <i class="bi bi-plus"></i></a>
                                </div>
                            </div>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4">
                                    <div class="alert alert-primary">
                                        <h5>{{ $product->title }}</h5>
                                        <p>Category: {{ (is_object($product->category)) ? $product->category->name : 'No Category' }}</p>
                                        <p>Price: {{ $currency_code }}{{ $product->price }}</p>
                                        {!! (count($product->images) > 0) ? '<img class="img-thumbnail img-fluid card-img" src="'. $product->images[0]->url .'"/> ' : '<img class="img-thumbnail" src="https://www.eduprizeschools.net/wp-content/uploads/2016/06/No_Image_Available.jpg"/>' !!}

                                        @if(!is_null($product->options))
                                            <h5 class="mt-3">Options:</h5>

                                        <div class="row">
                                            @foreach($product->jsonOptions() as $key => $valus)
                                            <div class="form-group col-md-12">
                                                <label for="{{ $key }}">{{ $key }}</label>
                                                <select id="{{ $key }}" type="text" name="{{ $key }}" class="form-control">
                                                    @foreach($valus as $value)
                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                        <a class="btn btn-success mt-2" href="{{ route('update-product', ['id' => $product->id]) }}">Edit Product</a>

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

@section('scripts')
    @if(\Illuminate\Support\Facades\Session::has('success'))
        <script>
            toastr.success("{!! \Illuminate\Support\Facades\Session::get('success') !!}");
        </script>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('warning'))
        <script>
            toastr.warning("{!! \Illuminate\Support\Facades\Session::get('warning') !!}");
        </script>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <script>
            toastr.error("{!! \Illuminate\Support\Facades\Session::get('error') !!}");
        </script>
    @endif
@endsection
