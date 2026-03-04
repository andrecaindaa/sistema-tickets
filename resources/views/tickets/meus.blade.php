<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Os Meus Tickets
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="bg-white shadow rounded-xl p-6 border border-gray-100">

                @forelse($tickets as $ticket)

                    <div class="border-b py-3">
                        <a href="{{ route('tickets.show', $ticket) }}"
                           class="font-semibold text-blue-600 hover:underline">
                            {{ $ticket->numero }} - {{ $ticket->assunto }}
                        </a>

                        <div class="text-sm text-gray-500">
                            {{ $ticket->inbox->nome }} |
                            {{ $ticket->estado->nome }}
                        </div>
                    </div>

                @empty

                    <p class="text-gray-500">Sem tickets.</p>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
