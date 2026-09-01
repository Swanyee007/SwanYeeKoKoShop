<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='orders';
    protected $fillable=[
        'voucher_no',
        'total',
        'qty',
        'payment_slip',
        'status',
        'note',
        'item_id',
        'payment_id',
        'user_id',
    ];
    public function user()
    {
        return $this->belongdTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function payment()
    {
        return $this->belongsTo(payment::class);
    }
}
