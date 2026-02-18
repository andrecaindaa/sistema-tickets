<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Editar Inbox: {{ $inbox->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">

            <form method="POST" action="{{ route('inboxes.update', $inbox) }}">
                @csrf
                @method('PUT')

                @include('inboxes.partials.form')

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('inboxes.index') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                        Atualizar Inbox
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
