<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_name',
        'city',
        'country',
        'phone',
        'fax',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
