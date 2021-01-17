@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Tickets') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($tickets as $ticket)
                                <div class="col-md-12">
                                    <div class="alert alert-primary">
                                        <h5>Customer: {{ $ticket->user->formattedName() }}</h5>
                                        <p>Ticket Type: {{ $ticket->ticketType->name }}</p>
                                        <p>Status: {{ $ticket->status }}</p>
                                        <p>Title: {{ $ticket->title }}</p>
                                        <p>Message: {{ $ticket->message }}</p>
                                        <p>Date: {{ $ticket->humanDate() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
