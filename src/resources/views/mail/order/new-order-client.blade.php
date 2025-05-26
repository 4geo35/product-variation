<x-mail::message>
# Здравствуйте!

На сайте был оформлен заказ {{ $order->number }} на сумму {{ $order->total }} рублей.

<x-mail::table>
| Товар | Количество | Сумма |
| :---- | ---------: | ----: |
@foreach ($items as $item)
| {{ $item->title }}: {{ $item->variation_title }}. | {{ $item->quantity }} | {{ $item->total }} |
@endforeach
</x-mail::table>

<x-mail::button :url="$url">
Просмотр
</x-mail::button>

С уважением,<br>
[{{ config('app.name') }}]({{ config("app.url") }})
</x-mail::message>
