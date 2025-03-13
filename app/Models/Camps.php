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
        'mikrotikUsername',
        'mikrotikPassword',
        'radiusSecret',
        'radiusIP',
        'status',
    ];
}
