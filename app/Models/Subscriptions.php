<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'camp_id',
        'user_id',
        'counter_id',
        'customer_id',
        'package_id',
        'purchaseDateTime',
        'subscriptionStartTime',
        'subscriptionEndTime',
        'price',
        'macAddress',
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

    public function counter()
    {
        return $this->belongsTo(Counter::class, 'counter_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id');
    }
}
