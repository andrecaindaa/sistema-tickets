@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">

    <!-- Nome -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nome *
        </label>
        <input type="text"
               name="nome"
               value="{{ old('nome', $inbox->nome ?? '') }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    <!-- Descrição -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Descrição
        </label>
        <textarea name="descricao"
                  rows="3"
                  class="w-full rounded-lg border-gray-300">{{ old('descricao', $inbox->descricao ?? '') }}</textarea>
    </div>

    <!-- Ativo -->
    <div class="flex items-center">
        <input type="checkbox"
               name="ativo"
               value="1"
               class="rounded border-gray-300"
               {{ old('ativo', $inbox->ativo ?? true) ? 'checked' : '' }}>
        <label class="ml-2 text-sm text-gray-700">
            Inbox ativa
        </label>
    </div>

    <!-- Operadores -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Operadores
        </label>

        <select name="operadores[]" multiple
                class="w-full rounded-lg border-gray-300 h-40">

            @php
                $selected = old(
                    'operadores',
                    isset($inbox) ? $inbox->operadores->pluck('id')->toArray() : []
                );
            @endphp

            @foreach($operadores as $operador)
                <option value="{{ $operador->id }}"
                    {{ in_array($operador->id, $selected) ? 'selected' : '' }}>
                    {{ $operador->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>
