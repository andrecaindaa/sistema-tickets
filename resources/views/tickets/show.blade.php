<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket #{{ $ticket->numero ?? $ticket->id }} - {{ $ticket->assunto }}
            </h2>
            <div class="flex space-x-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ $ticket->estado->nome ?? 'Aberto' }}
                </span>
                <a href="{{ route('inboxes.tickets.index', $ticket->inbox) }}"
                   class="text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex gap-6">
            {{-- COLUNA PRINCIPAL (CONVERSAÇÃO) --}}
            <div class="flex-1 space-y-6">
                {{-- CABEÇALHO DO TICKET --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $ticket->assunto }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Criado por <span class="font-medium">{{ $ticket->cliente->name ?? 'Sistema' }}</span> •
                                {{ $ticket->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                {{ $ticket->tipo->nome ?? 'Sem tipo' }}
                            </span>
                        </div>
                    </div>

                    {{-- MENSAGEM INICIAL --}}
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $ticket->descricao }}</p>
                        @if($ticket->conhecimento)
                            <div class="mt-2 text-sm text-gray-500">
                                <span class="font-medium">CC:</span> {{ implode(', ', (array)$ticket->conhecimento) }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CONVERSAÇÃO (estilo Kirridesk) --}}
                <div class="bg-white shadow rounded-lg">
                    <div class="border-b px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Conversa</h3>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($ticket->mensagens as $mensagem)
                            <div class="p-6 hover:bg-gray-50 transition">
                                {{-- CABEÇALHO DA MENSAGEM --}}
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($mensagem->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $mensagem->user->name ?? 'Sistema' }}</span>
                                            <span class="text-sm text-gray-500 ml-2">
                                                {{ $mensagem->created_at->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- BADGE DE CANAL (ex: Via WhatsApp) --}}
                                    <span class="text-xs text-gray-400">
                                        Via {{ $mensagem->canal ?? 'Web' }}
                                    </span>
                                </div>

                                {{-- CONTEÚDO DA MENSAGEM --}}
                                <div class="ml-10">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $mensagem->mensagem }}</p>

                                    {{-- ANEXOS --}}
                                    @if($mensagem->attachments->count())
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @foreach($mensagem->attachments as $anexo)
                                                <a href="{{ asset('storage/' . $anexo->path) }}"
                                                   target="_blank"
                                                   class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm text-gray-700">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.414 6.586a6 6 0 106.656 6.656l6.586-6.586"></path>
                                                    </svg>
                                                    {{ $anexo->filename }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p>Ainda não existem mensagens nesta conversa.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- NOVA RESPOSTA --}}
                    <div class="border-t p-6 bg-gray-50">
                        <form method="POST" action="{{ route('tickets.messages.store', $ticket) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <textarea name="mensagem"
                                          rows="3"
                                          class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Escreva a sua mensagem..."
                                          required></textarea>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <label class="cursor-pointer text-gray-500 hover:text-gray-700">
                                        <input type="file" name="anexos[]" multiple class="hidden">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.414 6.586a6 6 0 106.656 6.656l6.586-6.586"></path>
                                        </svg>
                                    </label>
                                    <span class="text-xs text-gray-400">Max 5MB</span>
                                </div>

                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                    Enviar Mensagem
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- BARRA LATERAL (DETALHES E AÇÕES) --}}
            <div class="w-80 space-y-6">
                {{-- DETALHES DO TICKET --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Detalhes do Ticket</h4>

                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500 block">Inbox</span>
                            <span class="font-medium">{{ $ticket->inbox->nome ?? '—' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Entidade</span>
                            <span class="font-medium">{{ $ticket->entidade?->nome ?? '—' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Contacto</span>
                            <span class="font-medium">{{ $ticket->contacto?->nome ?? '—' }}</span>
                            @if($ticket->contacto?->email)
                                <span class="text-gray-400 text-xs block">{{ $ticket->contacto->email }}</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-gray-500 block">Criado por</span>
                            <span class="font-medium">{{ $ticket->cliente?->name ?? 'Sistema' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Tipo</span>
                            <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $ticket->tipo?->nome ?? '—' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Estado</span>
                            <span class="font-medium">{{ $ticket->estado?->nome ?? '—' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Operador</span>
                            <span class="font-medium">{{ $ticket->operador?->name ?? 'Não atribuído' }}</span>
                        </div>
                    </div>
                </div>

                {{-- GESTÃO PARA OPERADORES E ADMIN --}}
@if(auth()->user()->isOperador() || auth()->user()->isAdmin())
<div class="bg-white shadow rounded-lg p-6">
    <h4 class="font-semibold text-gray-900 mb-4">Gestão do Ticket</h4>

    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-600 mb-1">Estado</label>
            <select name="ticket_estado_id" class="w-full border-gray-300 rounded-lg text-sm">
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}"
                        {{ $ticket->ticket_estado_id == $estado->id ? 'selected' : '' }}>
                        {{ $estado->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Operador Responsável</label>
            <select name="operador_id" class="w-full border-gray-300 rounded-lg text-sm">
                <option value="">— Não atribuído —</option>
                @foreach($operadores as $operador)
                    <option value="{{ $operador->id }}"
                        {{ $ticket->operador_id == $operador->id ? 'selected' : '' }}>
                        {{ $operador->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            Atualizar Ticket
        </button>
    </form>

    {{-- BOTÃO DE ELIMINAR - APENAS PARA OPERADORES E ADMIN --}}
    <div class="mt-4 pt-4 border-t border-gray-200">
        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}"
              onsubmit="return confirm('Tem a certeza que deseja eliminar este ticket? Esta ação não pode ser desfeita.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Eliminar Ticket
            </button>
        </form>
    </div>
</div>
@endif

                {{-- HISTÓRICO DE ATIVIDADE --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Atividade</h4>

                    <div class="space-y-3">
                        @forelse($ticket->logs->take(5) as $log)
                            <div class="text-xs border-l-2 border-gray-200 pl-3">
                                <div class="text-gray-900 font-medium">{{ $log->user->name ?? 'Sistema' }}</div>
                                <div class="text-gray-500">{{ $log->descricao }}</div>
                                <div class="text-gray-400">{{ $log->created_at->format('d M H:i') }}</div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Sem atividade recente</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
