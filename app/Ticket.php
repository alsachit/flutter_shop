<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'title', 'message', 'ticket_type_id', 'status'
        ];

    public function ticketType() {
        return $this->hasOne(TicketType::class, 'id' , 'ticket_type_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function humanDate() {
        return Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans();
    }
}
