<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item_options';

    protected $fillable = [
        'item_id',
        'name',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function values()
    {
        return $this->hasMany(ItemOptionValue::class);
    }
}
