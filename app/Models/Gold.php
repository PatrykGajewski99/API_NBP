<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gold extends Model
{
    use HasFactory;
    use UUID;

    protected $table="gold";

    protected $fillable = [
        'name',
        'exchange_rate'
    ];
}
