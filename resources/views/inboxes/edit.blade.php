<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Gerir Operadores - {{ $inbox->nome }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow rounded">

        <form method="POST" action="{{ route('inboxes.update', $inbox) }}">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                @foreach($operadores as $operador)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox"
                               name="operadores[]"
                               value="{{ $operador->id }}"
                               {{ $inbox->operadores->contains($operador->id) ? 'checked' : '' }}>
                        <span>{{ $operador->name }}</span>
                    </label>
                @endforeach
            </div>

            <div class="mt-4 text-right">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
