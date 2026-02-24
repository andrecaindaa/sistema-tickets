<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-6">

        {{-- DETALHES --}}
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
                <div><strong>Estado:</strong> {{ $ticket->estado->nome ?? '—' }}</div>
                <div><strong>Prioridade:</strong> {{ $ticket->prioridade }}</div>
                <div>
                    <strong>Operador:</strong>
                    {{ $ticket->operador->name ?? 'Não atribuído' }}
                </div>
            </div>
        </div>

        {{-- GESTÃO OPERADOR --}}
        @if(auth()->user()->isOperador())
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm mb-1">Estado</label>
                        <select name="ticket_estado_id" class="w-full border rounded px-3 py-2">
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}"
                                    {{ $ticket->ticket_estado_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm">Atribuir Operador</label>
                        <select name="operador_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- Nenhum --</option>
                            @foreach($operadores as $operador)
                                <option value="{{ $operador->id }}"
                                    {{ $ticket->operador_id == $operador->id ? 'selected' : '' }}>
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

        {{-- CONVERSAÇÃO --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">
                Conversação
            </h3>

            <div class="space-y-4">
                @forelse($ticket->mensagens as $mensagem)

                    <div class="p-4 rounded-lg
                        {{ $mensagem->user_id === auth()->id()
                            ? 'bg-blue-50 border border-blue-200'
                            : 'bg-gray-50 border border-gray-200' }}">

                        <div class="text-sm text-gray-600 mb-1">
                            <strong>{{ $mensagem->user->name }}</strong>
                            • {{ $mensagem->created_at->format('d/m/Y H:i') }}
                        </div>

                        <div class="text-gray-800">
                            {{ $mensagem->mensagem }}
                        </div>

                        @if($mensagem->attachments->count())
                            <div class="mt-2 space-y-1">
                                @foreach($mensagem->attachments as $anexo)
                                    <a href="{{ asset('storage/' . $anexo->path) }}"
                                       target="_blank"
                                       class="block text-blue-600 text-sm underline">
                                        📎 {{ $anexo->filename }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>

                @empty
                    <p class="text-gray-500">
                        Ainda não existem mensagens.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- HISTÓRICO --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">
                Histórico de Atividade
            </h3>

            <div class="space-y-3">
                @forelse($ticket->logs as $log)

                    <div class="text-sm text-gray-600 border-b pb-2">
                        <strong>{{ $log->user->name }}</strong>
                        • {{ $log->created_at->format('d/m/Y H:i') }}
                        <br>
                        {{ $log->descricao }}
                    </div>

                @empty
                    <p class="text-gray-500">
                        Sem alterações registadas.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- NOVA MENSAGEM --}}
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST"
                  action="{{ route('tickets.messages.store', $ticket) }}"
                  enctype="multipart/form-data">
                @csrf

                <textarea name="mensagem"
                          rows="4"
                          class="w-full border rounded px-3 py-2 mb-3"
                          placeholder="Escreva a sua mensagem..."
                          required></textarea>

                <input type="file"
                       name="anexos[]"
                       multiple
                       class="w-full border rounded px-3 py-2 mb-3">

                <div class="text-right">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Enviar Mensagem
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
