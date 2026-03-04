<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Utilizadores
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-6">
                <a href="{{ route('users.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Novo Utilizador
                </a>
            </div>

            <div class="bg-white shadow rounded-xl p-6 border border-gray-100">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-sm font-semibold text-gray-600">
                            <th class="py-2">Nome</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Perfil</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr>
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2 capitalize">
                                    {{ $user->role }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>
