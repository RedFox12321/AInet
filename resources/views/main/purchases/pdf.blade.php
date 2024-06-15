<html>

<head>
    <title>Purchase Details</title>
</head>

<body class="bg-white">
    <div class="container">
        <div class="header">
            <h1 class="text-2xl font-bold">Purchase Details</h1>
        </div>
        <div class="content">
            <p><strong class="font-semibold">Purchase ID:</strong> {{ $purchase->id }}</p>
            <p><strong class="font-semibold">Customer Name:</strong> {{ $purchase->customer_name }}</p>
            <p><strong class="font-semibold">Customer Email:</strong> {{ $purchase->customer_email }}</p>
            @isset($purchase->nif)
                <p><strong class="font-semibold">NIF:</strong> {{ $purchase->nif }}</p>
            @endisset
            <p><strong class="font-semibold">Payment Type:</strong> {{ $purchase->payment_type }}</p>
            <p><strong class="font-semibold">Payment Reference:</strong> {{ $purchase->payment_ref }}</p>
            <p><strong class="font-semibold">Date:</strong> {{ $purchase->date }}</p>
        </div>
        <p class="total text-right mt-4 font-semibold">Total: {{ number_format($purchase->total_price, 2) }}€</p>
    </div>
    <div class="footer mt-4">
        <p>&copy; {{ date('Y') }} - CineMagic</p>
    </div>
    </div>
</body>

</html>
