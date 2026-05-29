@component('mail::message')
# ¡Gracias por tu compra en {{ $store->name }}!

Hola **{{ $order->customer_name }}**, hemos recibido tu pedido con éxito y ya está siendo procesado por la tienda.

### Resumen del Pedido (#{{ $order->id }})

@component('mail::table')
| Producto | Cant. | Precio | Total |
| :--- | :---: | :---: | :---: |
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} | ${{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
| | | **Total:** | **${{ number_format($order->total, 2) }}** |
@endcomponent

Si compraste estando registrado en la tienda, puedes consultar el estado de tu pedido en tiempo real haciendo clic en el botón de abajo:

@component('mail::button', ['url' => route('public.customer.order', ['store' => $store->slug, 'order' => $order->id])])
Ver el Estado de mi Pedido
@endcomponent

Gracias por confiar en nosotros,  
El equipo de **{{ $store->name }}**
@endcomponent
