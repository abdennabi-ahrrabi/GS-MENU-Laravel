<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';

    protected $fillable = [
        'name', 'Parent_Category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'Parent_Category_id');
    }
}
