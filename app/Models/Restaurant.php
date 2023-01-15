<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $table = 'restaurants';

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'address',
        'phone_number',
        'description',
        'user_id'
    ];

    /**
     * User
     *
     * Get User Uploaded By Restaurant
     *
     * @return object
     */
    public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

    
}
