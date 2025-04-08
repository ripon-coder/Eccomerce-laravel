<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value','others'];

    // Relationship with Attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id');
    }

    public function variantOptions(): HasMany
    {
        return $this->hasMany(ProductVariantOption::class);
    }
}
