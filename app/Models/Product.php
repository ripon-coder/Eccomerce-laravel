<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id','brand_id','thumbnail','images','meta_title','meta_description','meta_keywords'];

    // Relationship with Variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    protected $casts = [
        'images' => 'array', 
        'meta_keywords' => 'array',
    ];
}
