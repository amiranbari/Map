<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ACTIVE   = 1;
    const INACTIVE = 0;
    const STATUS   = [
        self::ACTIVE,
        self::INACTIVE
    ];

    public function scopeActives($q)
    {
        return $q->where('status', self::ACTIVE);
    }
}
