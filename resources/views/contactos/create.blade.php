<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Novo Contacto
            </h2>
            <a href="{{ route('contactos.index') }}"
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
                <form method="POST" action="{{ route('contactos.store') }}">
                    @csrf

                    @include('contactos.partials.form')

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('contactos.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                            Guardar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
