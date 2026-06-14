@component('mail::message')
# ¡Tu pedido está listo! 🎉

Hola **{{ $order->customer_name }}**,

Nos alegra informarte que tu pedido **#{{ $order->id }}** en **{{ $store->name }}** ha sido marcado como **completado**. Tu producto o servicio ya está preparado para entrega/envío.

### Detalle del Pedido:
* **Número de pedido:** #{{ $order->id }}
* **Total de compra:** ${{ number_format($order->total, 2) }}

Si deseas ver más detalles de tu compra o de tus pedidos anteriores, haz clic en el siguiente enlace:

@component('mail::button', ['url' => route('public.customer.order', ['store' => $store->slug, 'order' => $order->id])])
Ver Detalle de Compra
@endcomponent

¡Muchas gracias por tu preferencia!  
El equipo de **{{ $store->name }}**
@endcomponent
