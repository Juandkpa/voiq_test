<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Toin0u\Geotools\Facade\Geotools;

class Contact extends Model {


    protected $table = 'contacts';

    /**
     * Calculate coordinate position for each contact
     * @return mixed
     */
    public function getCoordinateAttribute()
    {
        return Geotools::coordinate([$this->lat, $this->lng]);
    }

}
