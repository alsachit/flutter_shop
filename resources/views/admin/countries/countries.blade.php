@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Countries') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($countries as $country)
                                <div class="col-md-3">
                                    <div class="alert alert-primary text-center">
                                        <h5>{{ $country->name }}</h5>
                                        <p>Currency: {{ $country->currency }}</p>
                                        <p>Capital: {{ $country->capital }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $countries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
