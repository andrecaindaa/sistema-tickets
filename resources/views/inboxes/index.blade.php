<td>
    @foreach($inbox->operadores as $operador)
        <span class="text-xs bg-gray-200 px-2 py-1 rounded">
            {{ $operador->name }}
        </span>
    @endforeach
</td>
