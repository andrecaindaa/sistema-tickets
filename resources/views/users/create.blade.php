<x-app-layout>
    <div class="p-6 max-w-lg mx-auto">

        <h2 class="text-xl font-semibold mb-4">
            Criar Utilizador
        </h2>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="name"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>Tipo</label>
                <select name="role"
                        class="w-full border rounded px-3 py-2">
                    <option value="cliente">Cliente</option>
                    <option value="operador">Operador</option>
                </select>
            </div>

            <div class="text-right">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Criar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
