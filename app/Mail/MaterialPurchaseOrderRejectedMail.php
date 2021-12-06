<?php

namespace App\Mail;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaterialPurchaseOrderRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    protected MaterialPurchaseOrder $materialPurchaseOrder;

    public function __construct(User $user, MaterialPurchaseOrder $materialPurchaseOrder)
    {
        $this->user = $user;
        $this->materialPurchaseOrder = $materialPurchaseOrder;
    }

    public function build(): MaterialPurchaseOrderRejectedMail
    {
        return $this
            ->subject("A new purchase order rejected, ID - ". $this->materialPurchaseOrder->id)
            ->markdown('emails.purchase-order-rejected', [
                'user' => $this->user,
                'purchaseOrder' => $this->materialPurchaseOrder
            ]);
    }
}
