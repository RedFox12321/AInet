<div class="overflow-hidden rounded-xl border-4 border-stone-950" >
    <table class="table-auto">
        <tbody>
            @foreach($cart as $item)
            <tr class="bg-stone-700 @if (!$loop->last) border-b-2 border-b-stone-200 @endif">
                
                <td class="px-2 py-2 text-left text-rose-600 border-dotted border-r-black border-r-2">
                    <a href="{{ route('screenings.show', ['screening' => $item['screening']]) }}">#{{ $item['screening']->id }}</a>
                </td>
                <td class="px-2 py-2 text-center ">{{ $item['screening']->movie->title }}</td>
                <td class="px-2 py-2 text-center ">{{ $item['screening']->theater->name }}</td>
                <td class="px-2 py-2 text-right ">{{ $item['screening']->date }}</td>
                <td class="px-2 py-2 text-left ">{{ $item['screening']->start_time }}</td>
                <td class="px-2 py-2 text-left ">{{ $item['seat']->row }}-{{ $item['seat']->seat_number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>