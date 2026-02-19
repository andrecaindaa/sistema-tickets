<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-6">

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">
                {{ $ticket->assunto }}
            </h3>

            <p class="text-gray-700 mb-4">
                {{ $ticket->descricao }}
            </p>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><strong>Inbox:</strong> {{ $ticket->inbox->nome }}</div>
                <div><strong>Criado por:</strong> {{ $ticket->cliente->name }}</div>
                <div><strong>Estado:</strong> {{ $ticket->estado }}</div>
                <div><strong>Prioridade:</strong> {{ $ticket->prioridade }}</div>
                <div>
                    <strong>Operador:</strong>
                    {{ $ticket->operador->name ?? 'Não atribuído' }}
                </div>
            </div>
        </div>

        @if(auth()->user()->isOperador())
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm">Estado</label>
                        <select name="estado"
                                class="w-full border rounded px-3 py-2">
                            <option value="aberto">Aberto</option>
                            <option value="em_atendimento">Em Atendimento</option>
                            <option value="resolvido">Resolvido</option>
                            <option value="fechado">Fechado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm">Atribuir Operador</label>
                        <select name="operador_id"
                                class="w-full border rounded px-3 py-2">
                            <option value="">-- Nenhum --</option>
                            @foreach($operadores as $operador)
                                <option value="{{ $operador->id }}">
                                    {{ $operador->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-right">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Atualizar Ticket
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</x-app-layout>
