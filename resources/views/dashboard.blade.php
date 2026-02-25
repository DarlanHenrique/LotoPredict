<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Card --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
                <h3 class="text-2xl font-extrabold mb-2">Bem-vindo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-indigo-200 mb-6">Use a inteligência estatística para gerar suas melhores apostas.</p>
                <a href="{{ route('predictions.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition shadow">
                    Gerar nova previsão →
                </a>
            </div>

            {{-- Available Games --}}
            @if($games->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Jogos Disponíveis</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($games as $game)
                    <div class="p-4 rounded-xl border border-indigo-100 bg-indigo-50 flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $game->name }}</p>
                            <p class="text-sm text-gray-500">{{ $game->numbers_drawn }} números de {{ $game->min_number }} a {{ $game->max_number }}</p>
                        </div>
                        <a href="{{ route('predictions.create') }}?game={{ $game->id }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">Apostar →</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-gray-500 text-center py-4">Nenhum jogo disponível no momento.</p>
            </div>
            @endif

            {{-- Recent Predictions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900">Previsões Recentes</h4>
                    <a href="{{ route('predictions.index') }}" class="text-indigo-600 text-sm font-medium hover:underline">Ver todas →</a>
                </div>
                @if($recentPredictions->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentPredictions as $prediction)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <span class="font-semibold text-gray-800">{{ $prediction->game->name }}</span>
                            <span class="ml-2 text-sm text-gray-500">{{ $prediction->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-sm text-gray-700">
                                {{ implode(' - ', $prediction->predicted_numbers) }}
                            </span>
                            <a href="{{ route('predictions.show', $prediction) }}" class="text-indigo-600 text-sm hover:underline">Ver</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400 text-center py-6">Você ainda não gerou nenhuma previsão. <a href="{{ route('predictions.create') }}" class="text-indigo-600 hover:underline">Criar agora →</a></p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
