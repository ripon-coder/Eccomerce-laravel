<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "name",
        "type",
        "discount",
        "start_date",
        "end_date",
        "is_active",
        "description",
        "usage_limit",
        "user_limit",
    ];

    // Relationship with Products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'campaign_products')->withPivot('max_quantity')
            ->withTimestamps();
    }
}
