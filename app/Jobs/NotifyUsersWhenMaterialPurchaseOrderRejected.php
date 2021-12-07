<?php

namespace App\Jobs;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Mail\MaterialPurchaseOrderApprovedMail;
use App\Mail\MaterialPurchaseOrderCreatedMail;
use App\Mail\MaterialPurchaseOrderRejectedMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersWhenMaterialPurchaseOrderRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected MaterialPurchaseOrder $materialPurchaseOrder;

    public function __construct(MaterialPurchaseOrder $materialPurchaseOrder)
    {
        $this->materialPurchaseOrder = $materialPurchaseOrder;
    }

    public function handle()
    {
        $factoryId = $this->materialPurchaseOrder->factory_id;
        $users = User::role('Customer Service Agent')
            ->whereHas('factories', function ($q) use ($factoryId) {
                $q->where('id', $factoryId);
            })
            ->get();

        foreach ($users as $user) {
            Mail::to($user)
                ->queue(
                    new MaterialPurchaseOrderRejectedMail($user, $this->materialPurchaseOrder)
                );
        }
    }
}
