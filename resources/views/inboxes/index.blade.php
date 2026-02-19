<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Inboxes
        </h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between">
            <h3 class="text-lg font-semibold">Lista de Inboxes</h3>

            <a href="{{ route('inboxes.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Nova Inbox
            </a>

            <a href="{{ route('inboxes.tickets.index', $inbox) }}"
            class="text-blue-600 hover:underline">
            Ver Tickets
            </a>

        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nome</th>
                        <th class="px-4 py-2 text-left">Descrição</th>
                        <th class="px-4 py-2 text-left">Ativa</th>
                        <th class="px-4 py-2 text-left">Operadores</th>
                        <th class="px-4 py-2 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inboxes as $inbox)
                        <tr class="border-t">
                            <td class="px-4 py-2 font-semibold">
                                {{ $inbox->nome }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $inbox->descricao ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $inbox->ativo ? 'Sim' : 'Não' }}
                            </td>
                            <td class="px-4 py-2">
                                @forelse($inbox->operadores as $operador)
                                    <span class="text-xs bg-gray-200 px-2 py-1 rounded mr-1">
                                        {{ $operador->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-sm">
                                        Sem operadores
                                    </span>
                                @endforelse
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('inboxes.edit', $inbox) }}"
                                   class="text-yellow-600 mr-2">
                                    Editar
                                </a>

                                <form method="POST"
                                      action="{{ route('inboxes.destroy', $inbox) }}"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600"
                                            onclick="return confirm('Eliminar inbox?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Nenhuma inbox registada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
