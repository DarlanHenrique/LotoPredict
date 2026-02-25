<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerar Nova Previsão
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Nova Previsão</h3>
                <p class="text-gray-500 mb-8">Selecione o jogo e a estratégia de análise para gerar seus números.</p>

                <form method="POST" action="{{ route('predictions.store') }}">
                    @csrf

                    {{-- Game Selection --}}
                    <div class="mb-6">
                        <label for="lottery_game_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Loteria
                        </label>
                        <select
                            id="lottery_game_id"
                            name="lottery_game_id"
                            class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                            required
                        >
                            <option value="">Selecione a loteria</option>
                            @foreach($games as $game)
                            <option value="{{ $game->id }}" {{ old('lottery_game_id', request('game')) == $game->id ? 'selected' : '' }}>
                                {{ $game->name }} ({{ $game->numbers_drawn }} números de {{ $game->min_number }} a {{ $game->max_number }})
                            </option>
                            @endforeach
                        </select>
                        @error('lottery_game_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($games->isEmpty())
                        <p class="mt-2 text-sm text-amber-600">Nenhuma loteria cadastrada no momento.</p>
                        @endif
                    </div>

                    {{-- Strategy Selection --}}
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Estratégia de Análise</label>
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="strategy" value="frequency" class="mt-0.5 text-indigo-600 focus:ring-indigo-500" {{ old('strategy', 'frequency') === 'frequency' ? 'checked' : '' }}>
                                <div>
                                    <p class="font-semibold text-gray-900">Frequência</p>
                                    <p class="text-sm text-gray-500">Prioriza os números mais e menos sorteados historicamente.</p>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="strategy" value="balanced" class="mt-0.5 text-indigo-600 focus:ring-indigo-500" {{ old('strategy') === 'balanced' ? 'checked' : '' }}>
                                <div>
                                    <p class="font-semibold text-gray-900">Equilibrado</p>
                                    <p class="text-sm text-gray-500">Combina análise estatística com distribuição uniforme dos números.</p>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="strategy" value="random" class="mt-0.5 text-indigo-600 focus:ring-indigo-500" {{ old('strategy') === 'random' ? 'checked' : '' }}>
                                <div>
                                    <p class="font-semibold text-gray-900">Aleatório Ponderado</p>
                                    <p class="text-sm text-gray-500">Seleção aleatória ponderada pelos dados históricos.</p>
                                </div>
                            </label>
                        </div>
                        @error('strategy')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                            Gerar Previsão →
                        </button>
                        <a href="{{ route('predictions.index') }}" class="px-6 py-3 text-gray-600 font-semibold hover:text-gray-900 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
