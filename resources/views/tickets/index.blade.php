<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tickets - {{ $inbox->nome }}
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="{{ route('inboxes.tickets.create', $inbox) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Novo Ticket
        </a>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <form method="GET" class="bg-white p-4 rounded shadow mb-4">
    <div class="grid grid-cols-6 gap-4">

        <input type="text"
               name="search"
               placeholder="Pesquisar..."
               value="{{ request('search') }}"
               class="border rounded px-3 py-2">

        <select name="estado" class="border rounded px-3 py-2">
            <option value="">Estado</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id }}"
                    {{ request('estado') == $estado->id ? 'selected' : '' }}>
                    {{ $estado->nome }}
                </option>
            @endforeach
        </select>

        <select name="operador" class="border rounded px-3 py-2">
            <option value="">Operador</option>
            @foreach($operadores as $operador)
                <option value="{{ $operador->id }}"
                    {{ request('operador') == $operador->id ? 'selected' : '' }}>
                    {{ $operador->name }}
                </option>
            @endforeach
        </select>

        <select name="tipo" class="border rounded px-3 py-2">
            <option value="">Tipo</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}"
                    {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                    {{ $tipo->nome }}
                </option>
            @endforeach
        </select>

        <select name="entidade" class="border rounded px-3 py-2">
            <option value="">Entidade</option>
            @foreach($entidades as $entidade)
                <option value="{{ $entidade->id }}"
                    {{ request('entidade') == $entidade->id ? 'selected' : '' }}>
                    {{ $entidade->nome }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filtrar
        </button>

    </div>
</form>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Assunto</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Prioridade</th>
                        <th class="px-4 py-2 text-left">Criado em</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $ticket->id }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $ticket->assunto }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs bg-gray-100">
                                    {{ $ticket->estado->nome ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $ticket->prioridade }}</td>
                            <td class="px-4 py-2">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Nenhum ticket encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
