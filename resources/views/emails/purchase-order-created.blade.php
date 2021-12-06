@component('mail::message')
Hello {{$user->name}},

A new purchase order has been created and waiting for your approval.

The purchase order ID is : {{$purchaseOrder->id}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
