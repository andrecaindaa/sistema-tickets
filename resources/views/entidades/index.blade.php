<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Entidades
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('entidades.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Nova Entidade
        </a>

        <table class="mt-4 w-full border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIF</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entidades as $entidade)
                    <tr>
                        <td>{{ $entidade->id }}</td>
                        <td>{{ $entidade->nif }}</td>
                        <td>{{ $entidade->nome }}</td>
                        <td>{{ $entidade->email }}</td>
                        <td>
                            <a href="{{ route('entidades.edit', $entidade) }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
