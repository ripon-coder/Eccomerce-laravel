<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_address extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "manual_order_id",
        "name",
        "phone",
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "postal_code",
        "country",
    ];
}
