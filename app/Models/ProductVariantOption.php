<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    use HasFactory;
    
    protected $fillable = ['variant_id', 'attribute_option_id'];

    // Relationship with Variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Relationship with Attribute Option
    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class);
    }
}
