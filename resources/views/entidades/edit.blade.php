<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Entidade: {{ $entidade->nome }}
            </h2>
            <a href="{{ route('entidades.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('entidades.update', $entidade) }}">
                    @csrf
                    @method('PUT')

                    @include('entidades.partials.form')

                    @if(isset($clientes) && $clientes->count() > 0)
                        <hr class="my-6">

                        <h3 class="text-lg font-semibold mb-3">Clientes Associados</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($clientes as $cliente)
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox"
                                           name="clientes[]"
                                           value="{{ $cliente->id }}"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                           {{ isset($entidade) && $entidade->users->contains($cliente->id) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">
                                        {{ $cliente->name }}
                                        <span class="text-gray-500 text-xs">({{ $cliente->email }})</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <p class="text-sm text-gray-500 mt-2">
                            Selecione os clientes que pertencem a esta entidade
                        </p>
                    @endif

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('entidades.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                            Atualizar Entidade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
