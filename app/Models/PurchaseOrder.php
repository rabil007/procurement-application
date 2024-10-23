<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    protected $primaryKey = 'order_id';
    protected $fillable = ['order_no', 'order_date', 'supplier_id', 'item_total', 'discount', 'net_amount', 'item_id', 'quantity'];


    // public function supplier(): BelongsTo
    // {
    //     return $this->belongsTo(Supplier::class);
    // }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_no');
    }
    public function item()
{
    return $this->belongsTo(Item::class, 'item_id', 'item_id'); // Adjust if your keys are different
}

}   

