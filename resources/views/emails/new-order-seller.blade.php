@component('mail::message')
# ¡Nuevo pedido recibido! 🚀

Hola,

Has recibido un nuevo pedido en tu tienda **{{ $store->name }}**. A continuación se detallan los datos del cliente y de la orden para que puedas gestionarla lo antes posible:

### Datos de la Orden (#{{ $order->id }}):
* **Cliente:** {{ $order->customer_name }}
* **Email:** {{ $order->customer_email }}
* **Total:** ${{ number_format($order->total, 2) }}

@component('mail::button', ['url' => route('stores.orders.details', ['order' => $order->id])])
Gestionar Orden en mi Panel
@endcomponent

Recuerda revisar la orden a la brevedad para garantizar la mejor experiencia a tus clientes.

Atentamente,  
**Plataforma Tienda SaaS**
@endcomponent
