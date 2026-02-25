<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes da Previsão
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Prediction Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $prediction->game->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Gerada em {{ $prediction->created_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                    <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">
                        {{ ucfirst($prediction->strategy) }}
                    </span>
                </div>

                {{-- Numbers --}}
                <div class="mb-8">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Números Gerados</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($prediction->predicted_numbers as $number)
                        <div class="w-14 h-14 bg-indigo-600 text-white text-xl font-extrabold rounded-full flex items-center justify-center shadow-md shadow-indigo-200">
                            {{ str_pad($number, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($prediction->confidence_score !== null)
                <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl mb-6">
                    <p class="text-sm text-amber-800">
                        <span class="font-bold">Score de Confiança:</span>
                        <span class="font-mono ml-1">{{ $prediction->confidence_score }}</span>
                        <span class="text-amber-600 ml-2 text-xs">(baseado na frequência histórica)</span>
                    </p>
                </div>
                @endif

                <div class="flex gap-3 mt-6">
                    <a href="{{ route('predictions.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition text-sm">
                        Nova Previsão
                    </a>
                    <a href="{{ route('predictions.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition text-sm">
                        Ver Todas
                    </a>
                    <form method="POST" action="{{ route('predictions.destroy', $prediction) }}" class="ml-auto" onsubmit="return confirm('Excluir esta previsão?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition text-sm">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>

            {{-- Game Statistics --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h4 class="text-lg font-bold text-gray-900 mb-6">Estatísticas do Jogo</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-3xl font-extrabold text-indigo-600">{{ number_format($stats['total_draws']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Sorteios Registrados</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-3xl font-extrabold text-purple-600">{{ number_format($stats['total_combinations']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Combinações Possíveis</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <p class="text-3xl font-extrabold text-emerald-600">1 em {{ number_format(1 / max($stats['probability_per_draw'], 0.0000001)) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Probabilidade de Acerto</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
