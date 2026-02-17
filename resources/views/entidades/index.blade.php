<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Entidades
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Lista de Entidades</h3>
            <a href="{{ route('entidades.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Entidade
            </a>
        </div>


        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIF</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telemóvel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Website</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notas</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($entidades as $entidade)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $entidade->nif }}</td>
                            <td class="px-4 py-2 font-semibold">{{ $entidade->nome }}</td>
                            <td class="px-4 py-2">{{ $entidade->telefone ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $entidade->telemovel ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $entidade->email ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($entidade->website)
                                    <a href="{{ $entidade->website }}" target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Visitar
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 max-w-xs truncate">
                                {{ $entidade->notas_internas ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('entidades.edit', $entidade) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form method="POST"
                                      action="{{ route('entidades.destroy', $entidade) }}"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline"
                                            onclick="return confirm('Tem a certeza que deseja eliminar esta entidade?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                Nenhuma entidade registada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

