<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'detail_address',
        'city_regency',
        'province',
        'island',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'address_id', 'address_id');
    }
}
