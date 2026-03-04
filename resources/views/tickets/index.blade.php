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
                        <th class="px-4 py-2 text-left">Entidade</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Criado em</th>
                        <th class="px-4 py-2 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $ticket->numero ?? $ticket->id }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">
                                    {{ $ticket->assunto }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $ticket->entidade->nome ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($ticket->estado?->nome == 'Aberto') bg-green-100 text-green-800
                                    @elseif($ticket->estado?->nome == 'Em Atendimento') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->estado?->nome == 'Resolvido') bg-blue-100 text-blue-800
                                    @elseif($ticket->estado?->nome == 'Fechado') bg-gray-100 text-gray-800
                                    @else bg-gray-100
                                    @endif">
                                    {{ $ticket->estado->nome ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $ticket->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                       class="text-blue-600 hover:text-blue-800" title="Ver">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    {{-- APENAS O BOTÃO DE ELIMINAR (NÃO O FORMULÁRIO COMPLETO) --}}
                                    @if(auth()->user()->isOperador() || auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}"
                                              onsubmit="return confirm('Tem a certeza que deseja eliminar este ticket?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                Nenhum ticket encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
