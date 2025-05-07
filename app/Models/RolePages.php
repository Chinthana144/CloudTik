<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePages extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'page_id',
        'permissions',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
}
