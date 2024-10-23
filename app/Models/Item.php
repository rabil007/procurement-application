<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $table = 'item';

    protected $primaryKey = 'item_id';
    protected $fillable = ['item_name', 'inventory_location', 'brand', 'category', 'supplier_id', 'stock_unit', 'unit_price', 'item_images', 'status'];

    // Item.php (Model)
public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_no');
}

}
