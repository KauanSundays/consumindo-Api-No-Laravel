<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class UserAddress extends Model
{
    use Sushi;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postal_code',
        'address',
        'number',
        'complement', 
        'neighborhood', 
        'city', 
        'uf',
    ];

    public function users(): HasOne
    {
        return  $this->hasOne(User::class);
    }

    public function getRows()
    {
    // Fetch products from API
    $products = Http::get('https://dummyjson.com/products')->json();

    return $products;
}
}
