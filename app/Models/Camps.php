<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camps extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'location',
        'contactPerson',
        'contactPhone',
        'contactEmail',
        'mikritikIP',
        'mikritikPort',
        'mikrotikUsername',
        'mikrotikPassword',
        'radiusSecret',
        'radiusIP',
        'status',
    ];

    public function campusers()
    {
        return $this->hasMany(campusers::class, 'camp_id');
    }

    public function customers()
    {
        return $this->hasMany(Customers::class, 'camp_id');
    }
}
