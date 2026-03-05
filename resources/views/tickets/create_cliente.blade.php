<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                Novo Ticket
            </h2>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">

            <form method="POST"
                  action="{{ route('clientes.tickets.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Entidade --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Entidade <span class="text-red-500">*</span>
                        </label>
                        <select name="entidade_id"
                                id="entidade_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('entidade_id') border-red-500 @enderror"
                                required>
                            <option value="">Selecionar entidade...</option>
                            @foreach($entidades as $entidade)
                                <option value="{{ $entidade->id }}" {{ old('entidade_id') == $entidade->id ? 'selected' : '' }}>
                                    {{ $entidade->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('entidade_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contacto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Contacto <span class="text-red-500">*</span>
                        </label>
                        <select name="contacto_id"
                                id="contacto_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('contacto_id') border-red-500 @enderror"
                                required>
                            <option value="">Selecionar contacto...</option>
                            @foreach($contactos as $contacto)
                                <option value="{{ $contacto->id }}" {{ old('contacto_id') == $contacto->id ? 'selected' : '' }}>
                                    {{ $contacto->nome }}
                                    @if($contacto->funcao)
                                        ({{ $contacto->funcao->nome }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('contacto_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo <span class="text-red-500">*</span>
                        </label>
                        <select name="ticket_tipo_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('ticket_tipo_id') border-red-500 @enderror"
                                required>
                            <option value="">Selecionar tipo...</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('ticket_tipo_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('ticket_tipo_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Assunto --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Assunto <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="assunto"
                           value="{{ old('assunto') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('assunto') border-red-500 @enderror"
                           placeholder="Título resumido do pedido"
                           required>
                    @error('assunto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mensagem --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mensagem <span class="text-red-500">*</span>
                    </label>
                    <textarea name="mensagem"
                              rows="5"
                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('mensagem') border-red-500 @enderror"
                              placeholder="Descreva o seu pedido ou problema..."
                              required>{{ old('mensagem') }}</textarea>
                    @error('mensagem')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CC --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Conhecimento (CC) — emails separados por vírgula
                    </label>
                    <input type="text"
                           name="conhecimento"
                           value="{{ old('conhecimento') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                           placeholder="email1@empresa.com, email2@empresa.com">
                    <p class="mt-1 text-xs text-gray-500">
                        Estas pessoas receberão notificações mas não terão acesso ao sistema
                    </p>
                </div>

                {{-- Anexos --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Anexos</label>
                    <input type="file"
                           name="anexos[]"
                           multiple
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <small class="text-gray-500 text-xs">
                        Máx. 5MB por ficheiro. Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG
                    </small>
                </div>

                {{-- Botões --}}
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                        Criar Ticket
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
