<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'pagename',
    ];

    public function rolepages()
    {
        return $this->hasMany(RolePages::class, 'page_id');
    }
}
