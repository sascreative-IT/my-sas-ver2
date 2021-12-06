@component('mail::message')
Hello {{$user->name}},

The new purchase order has been rejected.

The purchase order ID is : {{$purchaseOrder->id}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
