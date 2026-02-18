<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Nova Inbox
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('inboxes.store') }}">
                @csrf

                @include('inboxes.partials.form')

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
