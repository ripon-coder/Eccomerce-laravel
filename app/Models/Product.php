<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'category_id', 'brand_id', 'thumbnail', 'images', 'slug', 'meta_title', 'meta_description', 'meta_keywords','is_published','feature_product'];

    // Relationship with Variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relationship with Campaigns
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_products')->withPivot('max_quantity')
            ->withTimestamps();
    }

    protected $casts = [
        'images' => 'array',
        'meta_keywords' => 'array',
    ];
}
