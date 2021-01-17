@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Categories') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-3">
                                    <p class="alert alert-primary text-center">{{ $category->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
