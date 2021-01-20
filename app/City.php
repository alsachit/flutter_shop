<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\City
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property string $state_code
 * @property int $country_id
 * @property string $country_code
 * @property string $latitude
 * @property string $longitude
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $updated_on
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 * @property-read \App\Country $country
 * @property-read \App\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereWikiDataId($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cities';

    public function state() {
      return  $this->belongsTo(State::class);
    }

    public function country() {
       return $this->belongsTo(Country::class);
    }
}
