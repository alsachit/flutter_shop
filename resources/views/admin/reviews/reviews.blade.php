
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Reviews') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($reviews as $review)
                                <div class="col-md-12">
                                    <div class="alert alert-primary ">
                                        <h5> Customer: {{ $review->customer->formattedName() }}  </h5>
                                        <p>Product: {{ $review->product->title }}</p>
                                        <p>
                                            Stars:
                                       @for($i=0; $i < 5; $i++)
                                           @if($i < $review->stars)
                                                <i class="bi bi-star-fill"></i>
                                                @endif
                                               @if($i >= $review->stars)
                                                   <i class="bi bi-star"></i>
                                                   @endif
                                            @endfor

                                        </p>

                                        <p>Review:  {{ $review->review }}</p>
                                        <p>Date: {{ $review->humanDate() }} </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
