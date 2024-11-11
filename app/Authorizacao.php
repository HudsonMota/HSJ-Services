<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorizacao extends Model
{
    protected $table = "authorizerequests";
    protected $fillable = ['driver'];

    /**
     * Define a relação com o modelo Driver.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver', 'id');
    }
}
