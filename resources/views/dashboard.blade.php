<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-6 space-y-12">

            <div>
                <h3 class="text-2xl font-bold text-gray-800">
                    Bem-vindo ao Sistema de Tickets
                </h3>
            </div>

            {{-- ============================= --}}
            {{-- 🔵 ÁREA OPERACIONAL --}}
            {{-- ============================= --}}

            @if(isset($inboxes))
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">
                        Inboxes
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($inboxes as $inbox)

                            <a href="{{ route('inboxes.tickets.index', $inbox) }}"
                               class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">

                                <h5 class="text-lg font-semibold text-gray-700 mb-2">
                                    {{ $inbox->nome }}
                                </h5>

                                <p class="text-gray-500 text-sm">
                                    {{ $inbox->tickets_abertos_count }} tickets abertos
                                </p>

                            </a>

                        @endforeach
                    </div>
                </div>
            @endif


            {{-- CLIENTE --}}
            @if(isset($meusTickets))
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">
                        Os Meus Tickets
                    </h4>

                    <div class="bg-white shadow rounded-xl p-6 border border-gray-100 max-w-md">
                        <p class="text-gray-500 text-sm mb-4">
                            {{ $meusTickets }} tickets abertos
                        </p>

                        <a href="{{ route('meus.tickets') }}"
                           class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Ver Tickets
                        </a>
                    </div>
                </div>
            @endif


            {{-- ============================= --}}
            {{-- ⚙ ÁREA ADMINISTRATIVA --}}
            {{-- ============================= --}}

            @if(auth()->user()->isAdmin())

                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">
                        Administração
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- Entidades --}}
                        <a href="{{ route('entidades.index') }}"
                           class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                            <h5 class="text-lg font-semibold text-gray-700 mb-2">
                                Entidades
                            </h5>
                            <p class="text-gray-500 text-sm">
                                Gestão de empresas e organizações.
                            </p>
                        </a>

                        {{-- Contactos --}}
                        <a href="{{ route('contactos.index') }}"
                           class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                            <h5 class="text-lg font-semibold text-gray-700 mb-2">
                                Contactos
                            </h5>
                            <p class="text-gray-500 text-sm">
                                Gestão de contactos associados.
                            </p>
                        </a>

                        {{-- Gestão de Inboxes --}}
                        <a href="{{ route('inboxes.index') }}"
                           class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                            <h5 class="text-lg font-semibold text-gray-700 mb-2">
                                Gestão de Inboxes
                            </h5>
                            <p class="text-gray-500 text-sm">
                                Criar e configurar departamentos.
                            </p>
                        </a>

                        {{-- Utilizadores --}}
                        <a href="{{ route('users.index') }}"
                           class="bg-white shadow hover:shadow-lg transition rounded-xl p-6 border border-gray-100">
                            <h5 class="text-lg font-semibold text-gray-700 mb-2">
                                Utilizadores
                            </h5>
                            <p class="text-gray-500 text-sm">
                                Gestão de operadores e clientes.
                            </p>
                        </a>

                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>
