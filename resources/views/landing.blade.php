<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LotoPredict — Inteligência Estatística para Loterias</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-gray-900">

        {{-- Navigation --}}
        <nav class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-extrabold text-indigo-600">Loto<span class="text-gray-900">Predict</span></span>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Entrar</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                Começar Grátis
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="pt-32 pb-20 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full uppercase tracking-wide mb-6">
                    Plataforma SaaS de Inteligência Estatística
                </span>
                <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    Preveja a Loteria com <br>
                    <span class="text-indigo-600">Inteligência de Dados</span>
                </h1>
                <p class="max-w-2xl mx-auto text-xl text-gray-600 mb-10">
                    O LotoPredict analisa milhares de resultados históricos e aplica cálculos combinatórios avançados para gerar suas melhores apostas — estatisticamente embasadas.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white text-lg font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Acessar Dashboard →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white text-lg font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Começar Grátis Agora →
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 text-lg font-semibold rounded-xl border border-gray-200 hover:border-indigo-300 hover:text-indigo-600 transition">
                            Já tenho conta
                        </a>
                    @endauth
                </div>
                <p class="mt-4 text-sm text-gray-400">Sem cartão de crédito. Acesso imediato.</p>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900">Por que o LotoPredict?</h2>
                    <p class="mt-4 text-lg text-gray-500">Tecnologia de ponta para maximizar suas chances</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 rounded-2xl bg-indigo-50 border border-indigo-100">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">📊</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Análise de Frequência</h3>
                        <p class="text-gray-600">Identifica os números mais e menos sorteados nos últimos concursos com precisão estatística.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-purple-50 border border-purple-100">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">🔢</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Combinatória Avançada</h3>
                        <p class="text-gray-600">Calcula todas as combinações possíveis e a probabilidade exata de cada aposta sugerida.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">🎯</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Previsões Personalizadas</h3>
                        <p class="text-gray-600">Gera apostas baseadas em múltiplas estratégias: frequência, equilíbrio e distribuição estatística.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How It Works --}}
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900">Como funciona</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-600 text-white text-2xl font-extrabold rounded-full flex items-center justify-center mx-auto mb-5">1</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Crie sua conta</h3>
                        <p class="text-gray-500">Cadastro rápido e gratuito. Acesse imediatamente todos os recursos da plataforma.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-600 text-white text-2xl font-extrabold rounded-full flex items-center justify-center mx-auto mb-5">2</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Escolha a loteria</h3>
                        <p class="text-gray-500">Selecione o jogo que deseja analisar: Mega-Sena, Lotofácil, Quina e muito mais.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-600 text-white text-2xl font-extrabold rounded-full flex items-center justify-center mx-auto mb-5">3</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Gere suas apostas</h3>
                        <p class="text-gray-500">Nosso algoritmo analisa os dados históricos e gera combinações otimizadas para você.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="py-24 bg-indigo-600">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-white mb-6">
                    Pronto para apostar com inteligência?
                </h2>
                <p class="text-xl text-indigo-200 mb-10">
                    Junte-se a milhares de jogadores que já usam estatística a seu favor.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-600 text-xl font-extrabold rounded-xl hover:bg-indigo-50 transition shadow-xl">
                        Acessar Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-600 text-xl font-extrabold rounded-xl hover:bg-indigo-50 transition shadow-xl">
                        Criar conta gratuita →
                    </a>
                @endauth
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-10 bg-gray-900 text-center">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} LotoPredict — Plataforma SaaS de Inteligência Estatística para Loterias.
            </p>
            <p class="text-gray-600 text-xs mt-2">
                Este sistema não garante ganhos. Jogue com responsabilidade.
            </p>
        </footer>

    </body>
</html>
