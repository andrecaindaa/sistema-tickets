<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Nome -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nome <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="nome"
               value="{{ old('nome', $contacto->nome ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nome') border-red-500 @enderror"
               placeholder="Nome completo">
        @error('nome')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Função -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Função <span class="text-red-500">*</span>
        </label>
        <select name="funcao_id"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('funcao_id') border-red-500 @enderror">
            <option value="">Selecionar função...</option>
            @foreach($funcoes as $funcao)
                <option value="{{ $funcao->id }}"
                    {{ old('funcao_id', $contacto->funcao_id ?? '') == $funcao->id ? 'selected' : '' }}>
                    {{ $funcao->nome }}
                </option>
            @endforeach
        </select>
        @error('funcao_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $contacto->email ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
               placeholder="contacto@empresa.pt">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Telefone -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
        <input type="text"
               name="telefone"
               value="{{ old('telefone', $contacto->telefone ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="211234567">
    </div>

    <!-- Telemóvel -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Telemóvel</label>
        <input type="text"
               name="telemovel"
               value="{{ old('telemovel', $contacto->telemovel ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="911234567">
    </div>

    <!-- Entidades -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Entidades Associadas <span class="text-red-500">*</span>
        </label>
        <select name="entidades[]"
                multiple
                size="5"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('entidades') border-red-500 @enderror">
            @foreach($entidades as $entidade)
                <option value="{{ $entidade->id }}"
                    {{ in_array($entidade->id, old('entidades', isset($contacto) && $contacto->entidades ? $contacto->entidades->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                    {{ $entidade->nome }} ({{ $entidade->nif }})
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-sm text-gray-500">Segure Ctrl para selecionar múltiplas entidades</p>
        @error('entidades')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Notas -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">Notas Internas</label>
        <textarea name="notas_internas"
                  rows="4"
                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                  placeholder="Informações internas sobre o contacto...">{{ old('notas_internas', $contacto->notas_internas ?? '') }}</textarea>
    </div>
</div>

<!-- Campos obrigatórios hint -->
<p class="mt-4 text-sm text-gray-500">
    <span class="text-red-500">*</span> Campos obrigatórios
</p>
