<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_published',
        'deleted_at'
    ];

    // Relationship: Parent Category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship: Child Categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function categories()
    {
        return $this->children();
    }

    // Relationship: Products in this Category
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
