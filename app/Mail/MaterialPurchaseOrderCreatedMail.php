<?php

namespace App\Mail;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaterialPurchaseOrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    protected MaterialPurchaseOrder $materialPurchaseOrder;

    public function build(): MaterialPurchaseOrderCreatedMail
    {
        return $this
            ->subject("A new purchase order created, ID - " + $this->materialPurchaseOrder->id)
            ->markdown('emails.purchase-order-created', [
                'user' => $this->user,
                'purchaseOrder' => $this->materialPurchaseOrder
            ]);
    }
}
