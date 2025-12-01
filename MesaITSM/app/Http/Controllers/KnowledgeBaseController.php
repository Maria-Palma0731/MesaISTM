<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    /**
     * Mostrar lista de artículos de la base de conocimiento
     */
    public function index(): View
    {
        $articles = KnowledgeArticle::with('creator')
            ->published()
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total' => KnowledgeArticle::published()->count(),
            'guias' => KnowledgeArticle::published()->byCategory('guias')->count(),
            'faq' => KnowledgeArticle::published()->byCategory('faq')->count(),
            'tecnica' => KnowledgeArticle::published()->byCategory('tecnica')->count(),
            'total_views' => KnowledgeArticle::published()->sum('views'),
        ];

        return view('admin.knowledge-base.index', compact('articles', 'stats'));
    }

    /**
     * Mostrar formulario para crear artículo
     */
    public function create(): View
    {
        return view('admin.knowledge-base.create');
    }

    /**
     * Mostrar un artículo específico
     */
    public function show($id): View
    {
        $article = KnowledgeArticle::with('creator')->findOrFail($id);
        $article->incrementViews();
        
        return view('admin.knowledge-base.show', compact('article'));
    }

    /**
     * Mostrar formulario para editar artículo
     */
    public function edit($id): View
    {
        $article = KnowledgeArticle::with('creator')->findOrFail($id);
        return view('admin.knowledge-base.edit', compact('article'));
    }

    /**
     * Guardar nuevo artículo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:guias,faq,tecnica,politicas',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->has('is_published');
        $validated['views'] = 0;

        $article = KnowledgeArticle::create($validated);

        return redirect()
            ->route('admin.knowledge-base.show', $article->id)
            ->with('success', 'Artículo creado exitosamente');
    }

    /**
     * Actualizar artículo existente
     */
    public function update(Request $request, $id)
    {
        $article = KnowledgeArticle::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:guias,faq,tecnica,politicas',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        $article->update($validated);

        return redirect()
            ->route('admin.knowledge-base.show', $article->id)
            ->with('success', 'Artículo actualizado exitosamente');
    }

    /**
     * Eliminar artículo
     */
    public function destroy($id)
    {
        $article = KnowledgeArticle::findOrFail($id);
        $article->delete();

        return redirect()
            ->route('admin.knowledge-base.index')
            ->with('success', 'Artículo eliminado exitosamente');
    }

    /**
     * Vista pública de la base de conocimiento para usuarios
     */
    public function publicIndex(Request $request): View
    {
        $query = KnowledgeArticle::with('creator')->published();
        
        // Filtrar por categoría si se proporciona
        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }
        
        // Buscar por término si se proporciona
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }
        
        $articles = $query->orderBy('views', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(12);
        
        $stats = [
            'total' => KnowledgeArticle::published()->count(),
            'guias' => KnowledgeArticle::published()->byCategory('guias')->count(),
            'faq' => KnowledgeArticle::published()->byCategory('faq')->count(),
            'tecnica' => KnowledgeArticle::published()->byCategory('tecnica')->count(),
        ];

        return view('knowledge-base.index', compact('articles', 'stats'));
    }

    /**
     * Vista pública de un artículo específico para usuarios
     */
    public function publicShow($id): View
    {
        $article = KnowledgeArticle::with('creator')
            ->published()
            ->findOrFail($id);
        
        $article->incrementViews();
        
        // Artículos relacionados de la misma categoría
        $relatedArticles = KnowledgeArticle::published()
            ->byCategory($article->category)
            ->where('id', '!=', $article->id)
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        return view('knowledge-base.show', compact('article', 'relatedArticles'));
    }

    /**
     * Búsqueda en la base de conocimiento
     */
    public function search(Request $request)
    {
        $search = $request->input('q', '');
        
        $articles = KnowledgeArticle::with('creator')
            ->published()
            ->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('summary', 'like', "%{$search}%")
                      ->orWhere('tags', 'like', "%{$search}%");
            })
            ->orderBy('views', 'desc')
            ->paginate(10);

        return view('knowledge-base.search', compact('articles', 'search'));
    }
}
