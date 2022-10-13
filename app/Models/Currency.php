<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Currency extends Model
{
    use HasFactory;
    use UUID;

    protected $table="currency";

    protected $fillable = ['name', 'currency_code','exchange_rate'];
}
