<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
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

    public function getRows()
    {
        //API
        $cep = Http::get('viacep.com.br/ws/01001000/json/')->json();
 
        //filtering some attributes
        $cep = Arr::map($cep['cep'], function ($item) {
            return Arr::only($item,
                [
                    'cep',
                    'logradouro',
                    'complemento',
                ]
            );
        });
 
        return $cep;
    }

    public function users(): HasOne
    {
        return  $this->hasOne(User::class);
    }
}
