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
                            <td class="px-4 py-2">{{ $ticket->estado }}</td>
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
