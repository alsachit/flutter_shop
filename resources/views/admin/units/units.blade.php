@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Units') }}</div>

                    <div class="card-body">
                        <div class="row">
                        @foreach($units as $unit)
                                <div class="col-md-3">
                                    <p class="alert alert-primary text-center">{{ $unit->unit_code }} ,  {{ $unit->unit_name }}</p>
                                </div>
                        @endforeach
                        </div>
                        {{ $units->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
