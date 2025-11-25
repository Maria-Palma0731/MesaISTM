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
}
