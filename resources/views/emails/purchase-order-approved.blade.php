@component('mail::message')
Hello {{$user->name}},

A new purchase order has been approved.

The purchase order ID is : {{$purchaseOrder->id}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
