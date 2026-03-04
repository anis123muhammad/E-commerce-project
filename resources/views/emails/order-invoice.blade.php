<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Invoice - OR{{ $order->id }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <h2 style="text-align: center; color: #333;">Order Invoice - OR{{ $order->id }}</h2>

        <p style="font-size: 16px; color: #555;">
            @if($emailType == 'customer')
                Hello <strong>{{ $order->first_name }}</strong>, thank you for your order!
            @else
                New order placed by <strong>{{ $order->first_name }} {{ $order->last_name }}</strong> ({{ $order->email }})
            @endif
        </p>

        <h3 style="color: #333; margin-top: 20px;">Order Details</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #007bff; color: white;">
                    <th style="padding: 10px; text-align: left;">Product</th>
                    <th style="padding: 10px; text-align: right;">Price</th>
                    <th style="padding: 10px; text-align: right;">Qty</th>
                    <th style="padding: 10px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">{{ $item->product->title }}</td>
                    <td style="padding: 10px; text-align: right;">${{ number_format($item->price, 2) }}</td>
                    <td style="padding: 10px; text-align: right;">{{ $item->qty }}</td>
                    <td style="padding: 10px; text-align: right;">${{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="padding: 5px; text-align: right;"><strong>Subtotal:</strong></td>
                <td style="padding: 5px; text-align: right;">${{ number_format($order->subtotal, 2) }}</td>
            </tr>
               <tr>
                <td style="padding: 5px; text-align: right;"><strong>discount:</strong></td>
                <td style="padding: 5px; text-align: right;">${{ number_format($order->discount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; text-align: right;"><strong>Shipping:</strong></td>
                <td style="padding: 5px; text-align: right;">${{ number_format($order->shipping, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; text-align: right; font-size: 18px;"><strong>Grand Total:</strong></td>
                <td style="padding: 5px; text-align: right; font-size: 18px;"><strong>${{ number_format($order->grand_total, 2) }}</strong></td>
            </tr>
        </table>

        <p style="font-size: 16px; color: #555;">Thank you for shopping with us!</p>
        <p style="font-size: 14px; color: #999;">{{ config('app.name') }}</p>

    </div>

</body>
</html>
