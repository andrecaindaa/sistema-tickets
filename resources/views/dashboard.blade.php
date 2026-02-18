<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">
                    Bem-vindo ao Sistema de Tickets
                </h3>
                <p class="text-gray-500 mt-2">
                    Gestão centralizada de entidades, contactos e comunicações.
                </p>
            </div>

            <!-- Grid de módulos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Entidades -->
                <a href="{{ route('entidades.index') }}"
                   class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">
                        Entidades
                    </h4>
                    <p class="text-gray-500 text-sm">
                        Gestão de empresas e organizações.
                    </p>
                </a>

                <!-- Contactos -->
                <a href="{{ route('contactos.index') }}"
                   class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">
                        Contactos
                    </h4>
                    <p class="text-gray-500 text-sm">
                        Gestão de contactos associados às entidades.
                    </p>
                </a>

                <!-- Inboxes -->
                <a href="{{ route('inboxes.index') }}"
                   class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">
                        Inboxes
                    </h4>
                    <p class="text-gray-500 text-sm">
                        Departamentos e áreas de atendimento.
                    </p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
