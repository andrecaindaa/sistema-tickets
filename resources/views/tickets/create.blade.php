<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo Ticket - {{ $inbox->nome }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('inboxes.tickets.store', $inbox) }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Assunto</label>
                <input type="text" name="assunto"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Descrição</label>
                <textarea name="descricao"
                          rows="5"
                          class="w-full border rounded px-3 py-2"
                          required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Prioridade</label>
                <select name="prioridade"
                        class="w-full border rounded px-3 py-2">
                    <option value="baixa">Baixa</option>
                    <option value="media" selected>Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Criar Ticket
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
