<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item_variants';

    protected $fillable = [
        'item_id',
        'sku',
        'price',
        'stock',
        'image',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function variantValues()
    {
        return $this->hasMany(ItemVariantValue::class);
    }

    public function optionValues()
    {
        return $this->belongsToMany(
            ItemOptionValue::class,
            'item_variant_values',
            'item_variant_id',
            'item_option_value_id'
        );
    }
}
