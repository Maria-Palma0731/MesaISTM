<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Base de Conocimiento</h1>
                <p class="mt-2 text-gray-600">Encuentra respuestas y soluciones a problemas comunes</p>
            </div>

            {{-- Búsqueda --}}
            <div class="mb-8">
                <form action="{{ route('knowledge-base.index') }}" method="GET" class="max-w-2xl">
                    <div class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar en la base de conocimiento..." 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            {{-- Filtros por categoría --}}
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('knowledge-base.index') }}" 
                   class="px-4 py-2 rounded-lg {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    Todas ({{ $stats['total'] }})
                </a>
                <a href="{{ route('knowledge-base.index', ['category' => 'guias']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('category') == 'guias' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    Guías ({{ $stats['guias'] }})
                </a>
                <a href="{{ route('knowledge-base.index', ['category' => 'faq']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('category') == 'faq' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    FAQ ({{ $stats['faq'] }})
                </a>
                <a href="{{ route('knowledge-base.index', ['category' => 'tecnica']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('category') == 'tecnica' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    Técnica ({{ $stats['tecnica'] }})
                </a>
            </div>

            {{-- Lista de artículos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    <a href="{{ route('knowledge-base.show', $article->id) }}" 
                       class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                        <div class="flex items-start justify-between mb-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($article->category == 'guias') bg-blue-100 text-blue-700
                                @elseif($article->category == 'faq') bg-green-100 text-green-700
                                @elseif($article->category == 'tecnica') bg-purple-100 text-purple-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($article->category) }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $article->title }}
                        </h3>
                        
                        @if($article->summary)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $article->summary }}
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $article->views }}
                                </span>
                            </div>
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay artículos disponibles</h3>
                            <p class="mt-1 text-sm text-gray-500">No se encontraron artículos con los criterios de búsqueda.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
