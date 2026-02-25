<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Minhas Previsões
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 font-medium">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Histórico de Previsões</h3>
                    <a href="{{ route('predictions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Nova Previsão +
                    </a>
                </div>

                @if($predictions->isNotEmpty())
                <div class="divide-y divide-gray-100">
                    @foreach($predictions as $prediction)
                    <div class="flex items-center justify-between p-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                🎯
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $prediction->game->name }}</p>
                                <p class="text-sm text-gray-500">{{ $prediction->created_at->format('d/m/Y H:i') }} · {{ ucfirst($prediction->strategy) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-mono text-sm text-gray-700 hidden sm:block">
                                {{ implode(' - ', $prediction->predicted_numbers) }}
                            </span>
                            <a href="{{ route('predictions.show', $prediction) }}" class="text-indigo-600 text-sm hover:underline font-medium">Detalhes</a>
                            <form method="POST" action="{{ route('predictions.destroy', $prediction) }}" onsubmit="return confirm('Excluir esta previsão?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:underline">Excluir</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $predictions->links() }}
                </div>
                @else
                <div class="py-16 text-center">
                    <p class="text-gray-400 text-lg mb-4">Você ainda não gerou nenhuma previsão.</p>
                    <a href="{{ route('predictions.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                        Gerar minha primeira previsão →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
