<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- NIF -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            NIF <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="nif"
               value="{{ old('nif', $entidade->nif ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nif') border-red-500 @enderror"
               placeholder="123456789">
        @error('nif')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Nome -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nome <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="nome"
               value="{{ old('nome', $entidade->nome ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nome') border-red-500 @enderror"
               placeholder="Nome da empresa">
        @error('nome')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Telefone -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
        <input type="text"
               name="telefone"
               value="{{ old('telefone', $entidade->telefone ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="211234567">
    </div>

    <!-- Telemóvel -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Telemóvel</label>
        <input type="text"
               name="telemovel"
               value="{{ old('telemovel', $entidade->telemovel ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="911234567">
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $entidade->email ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
               placeholder="geral@empresa.pt">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Website -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
        <input type="url"
               name="website"
               value="{{ old('website', $entidade->website ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('website') border-red-500 @enderror"
               placeholder="https://www.empresa.pt">
        @error('website')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Notas Internas (full width) -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">Notas Internas</label>
        <textarea name="notas_internas"
                  rows="4"
                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                  placeholder="Informações internas sobre a entidade...">{{ old('notas_internas', $entidade->notas_internas ?? '') }}</textarea>
    </div>
</div>

<!-- Campos obrigatórios hint -->
<p class="mt-4 text-sm text-gray-500">
    <span class="text-red-500">*</span> Campos obrigatórios
</p>
