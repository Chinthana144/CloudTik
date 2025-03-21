<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
        'camp_id',
        'user_id',
        'startAmount',
        'endAmount',
        'startTime',
        'endTime',
        'status',
    ];

    public function camp()
    {
        return $this->belongsTo(Camps::class, 'camp_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasMany(Subscriptions::class, 'counter_id');
    }
}
