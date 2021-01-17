@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Roles') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($roles as $role)
                                <div class="col-md-3">
                                    <div class="alert alert-primary">
                                        <p>{{ $role->role }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
