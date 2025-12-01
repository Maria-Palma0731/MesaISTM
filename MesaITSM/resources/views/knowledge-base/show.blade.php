<x-app-layout>
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('knowledge-base.index') }}" class="text-blue-600 hover:text-blue-700">
                            Base de Conocimiento
                        </a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-600">{{ $article->title }}</li>
                </ol>
            </nav>

            {{-- Artículo --}}
            <article class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                {{-- Encabezado --}}
                <div class="mb-6">
                    <span class="px-3 py-1 text-xs font-medium rounded-full
                        @if($article->category == 'guias') bg-blue-100 text-blue-700
                        @elseif($article->category == 'faq') bg-green-100 text-green-700
                        @elseif($article->category == 'tecnica') bg-purple-100 text-purple-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($article->category) }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>

                <div class="flex items-center text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $article->creator->name }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $article->created_at->format('d M Y') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $article->views }} vistas
                        </span>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="prose prose-blue max-w-none">
                    {!! nl2br(e($article->content)) !!}
                </div>

                {{-- Tags --}}
                @if($article->tags)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Etiquetas:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $article->tags) as $tag)
                                <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">
                                    {{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>

            {{-- Artículos relacionados --}}
            @if($relatedArticles->count() > 0)
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Artículos relacionados</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('knowledge-base.show', $related->id) }}" 
                               class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow group">
                                <h3 class="font-medium text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                    {{ $related->title }}
                                </h3>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $related->views }} vistas
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
