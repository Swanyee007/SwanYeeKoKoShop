<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVariantValue extends Model
{
    use HasFactory;

    protected $table = 'item_variant_values';

    protected $fillable = [
        'item_variant_id',
        'item_option_value_id',
    ];

    public function variant()
    {
        return $this->belongsTo(
            ItemVariant::class,
            'item_variant_id'
        );
    }

    public function optionValue()
    {
        return $this->belongsTo(
            ItemOptionValue::class,
            'item_option_value_id'
        );
    }
}
