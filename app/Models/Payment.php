<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='payments';
    protected $fillable = [
        'name',
        'logo',
    ];
}
