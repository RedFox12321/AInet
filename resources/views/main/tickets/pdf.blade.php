<html>

<head>
    <title>Tickets</title>
</head>

<body class="bg-white">
    @foreach ($tickets as $ticket)
        <div class="container">
            <div class="header">
                <h1 class="text-2xl font-bold">Ticket <a
                        href="{{ route('tickets.show', ['ticket' => $ticket]) }}">#{{ $ticket->id }}</a> Details</h1>
            </div>
            <div class="content">
                <p><strong class="font-semibold">Ticket ID:</strong>{{ $ticket->id }}</p>
                <p><strong class="font-semibold">Theater:</strong>{{ $ticket->screening->theater->name }}</p>
                <p><strong class="font-semibold">Movie Title:</strong>{{ $ticket->screening->movie->title }}</p>
                <p><strong class="font-semibold">Seat:</strong>{{ $ticket->seat->row }}-{{ $ticket->seat->seat_number }}
                </p>
                <p><strong
                        class="font-semibold">Time:</strong>{{ $ticket->screening->date }}-{{ $ticket->screening->start_time }}
                </p>
            </div>
            <p class="total text-right mt-4 font-semibold">Price: {{ number_format($ticket->price, 2) }}€</p>
            <p class="total text-right mt-4 font-semibold">Customer Name: {{ $ticket->purchase->customer_name }}€</p>
            <p class="total text-right mt-4 font-semibold">Customer Email: {{ $ticket->purchase->customer_email }}€</p>
            @if($ticket->purchase->nif)
            <p class="total text-right mt-4 font-semibold">NIF: {{ $ticket->purchase->nif }}€</p>
            @endif
        </div>
        <img src="{{ $base64Image["$ticket->id"] }}" alt="QR Code">
    @endforeach
    <div class="footer mt-4">
        <p>&copy; {{ date('Y') }} - CineMagic</p>
    </div>
    </div>
</body>

</html>
