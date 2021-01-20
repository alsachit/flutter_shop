<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Shipment
 *
 * @property int $id
 * @property int $user_id
 * @property int $payment_id
 * @property int $order_id
 * @property string $status
 * @property string|null $shipment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $customer
 * @property-read \App\Order $order
 * @property-read \App\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereShipmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereUserId($value)
 * @mixin \Eloquent
 */
class Shipment extends Model
{
    protected $fillable = [
        'user_id', 'payment_id', 'order_id', 'status', 'shipment_date'
    ];

    public function customer() {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
}
