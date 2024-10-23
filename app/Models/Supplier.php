<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $primaryKey = 'supplier_no';

    protected $fillable = ['supplier_name', 'address', 'tax_no', 'country', 'mobile_no', 'email', 'status'];

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(Item::class, 'supplier_no', 'supplier_no');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_no', 'supplier_no');
    }
}
