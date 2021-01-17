@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Tags') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($tags as $tag)
                                <div class="col-md-3">
                                    <p class="alert alert-primary text-center">{{ $tag->tag }}</p>
                                </div>
                            @endforeach
                        </div>
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
