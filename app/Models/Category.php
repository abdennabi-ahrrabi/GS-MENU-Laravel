<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'name', 'restaurant_id',
    ];

    
    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
