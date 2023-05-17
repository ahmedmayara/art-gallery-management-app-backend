@component('mail::message')

# Hello {{ $customer }}

# Your order has been approved

Your order number is ORDER-000{{ $order->id }}

Your order total is {{ $order->total }}$<br>

Your order will be delivered to you as soon as possible.

# Thank you for shopping with us!

All the best,<br>
{{ config('app.name') }}
@endcomponent


