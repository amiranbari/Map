<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const ACTIVE   = 1;
    const INACTIVE = 0;
    const STATUS   = [
        self::ACTIVE,
        self::INACTIVE
    ];

    protected $guarded = [];

    public function scopeActives($q)
    {
        return $q->where('status', self::ACTIVE);
    }
}
