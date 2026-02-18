<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contactos
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Lista de Contactos</h3>
            <a href="{{ route('contactos.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Contacto
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Função</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telemóvel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entidades</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contactos as $contacto)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-semibold">{{ $contacto->nome }}</td>
                            <td class="px-4 py-2">{{ $contacto->funcao->nome ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $contacto->email ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $contacto->telefone ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $contacto->telemovel ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @foreach($contacto->entidades as $entidade)
                                    <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded mr-1 mb-1">
                                        {{ $entidade->nome }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('contactos.edit', $contacto) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form method="POST"
                                      action="{{ route('contactos.destroy', $contacto) }}"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline"
                                            onclick="return confirm('Tem a certeza que deseja eliminar este contacto?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">
                                Nenhum contacto registado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
