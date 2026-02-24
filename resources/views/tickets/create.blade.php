<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Criar Ticket - {{ $inbox->nome }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">

            <form method="POST"
                  action="{{ route('inboxes.tickets.store', $inbox) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm">Inbox</label>
                        <input type="text"
                               value="{{ $inbox->nome }}"
                               disabled
                               class="w-full border rounded px-3 py-2 bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm">Tipo</label>
                        <select name="ticket_tipo_id"
                                class="w-full border rounded px-3 py-2"
                                required>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}">
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm">Entidade</label>
                        <select name="entidade_id"
                                class="w-full border rounded px-3 py-2"
                                required>
                            @foreach($entidades as $entidade)
                                <option value="{{ $entidade->id }}">
                                    {{ $entidade->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm">Contacto Criador</label>
                        <select name="contacto_id"
                                class="w-full border rounded px-3 py-2"
                                required>
                            @foreach($contactos as $contacto)
                                <option value="{{ $contacto->id }}">
                                    {{ $contacto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm">Assunto</label>
                    <input type="text"
                           name="assunto"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <div class="mt-4">
                    <label class="block text-sm">Mensagem</label>
                    <textarea name="mensagem"
                              rows="5"
                              class="w-full border rounded px-3 py-2"
                              required></textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm">
                        Conhecimento (CC) — emails separados por vírgula
                    </label>
                    <input type="text"
                           name="conhecimento"
                           class="w-full border rounded px-3 py-2"
                           placeholder="email1@empresa.com, email2@empresa.com">
                </div>

                <div class="mt-4">
                    <label class="block text-sm">Anexos</label>
                    <input type="file"
                           name="anexos[]"
                           multiple
                           class="w-full border rounded px-3 py-2">
                    <small class="text-gray-500 text-xs">
                        Máx. 5MB por ficheiro
                    </small>
                </div>

                <div class="mt-6 text-right">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">
                        Criar Ticket
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
