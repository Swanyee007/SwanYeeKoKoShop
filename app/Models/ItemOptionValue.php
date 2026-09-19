<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOptionValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item_option_values';

    protected $fillable = [
        'item_option_id',
        'value',
    ];

    public function option()
    {
        return $this->belongsTo(
            ItemOption::class,
            'item_option_id'
        );
    }

    public function variantValues()
    {
        return $this->hasMany(ItemVariantValue::class);
    }

    public function variants()
    {
        return $this->belongsToMany(
            ItemVariant::class,
            'item_variant_values',
            'item_option_value_id',
            'item_variant_id'
        );
    }
}
