<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:00',
    ];

    public function invoiceItem()
    {
        return $this->belongsTo(MaterialInvoiceItem::class, 'in_invoice_item_id');
    }
}
