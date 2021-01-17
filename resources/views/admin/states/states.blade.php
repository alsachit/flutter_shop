@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Sates') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($states as $state)
                                <div class="col-md-3">
                                    <div class="alert alert-primary text-center">
                                        <h5>{{ $state->name }}</h5>
                                        <p>Country: {{ $state->country->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $states->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
