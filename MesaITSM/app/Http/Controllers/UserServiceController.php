<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\View\View;

class UserServiceController extends Controller
{
    /**
     * Catálogo de servicios
     */
    public function index(): View
    {
        $categories = ServiceCategory::with('activeServices')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('user.catalog.index', compact('categories'));
    }

    /**
     * Ver servicios de una categoría
     */
    public function category(ServiceCategory $category): View
    {
        if (!$category->is_active) {
            abort(404);
        }

        $services = $category->activeServices()->get();

        return view('user.catalog.category', compact('category', 'services'));
    }

    /**
     * Ver detalle de un servicio
     */
    public function show(Service $service): View
    {
        if (!$service->is_active || !$service->category->is_active) {
            abort(404);
        }

        return view('user.catalog.show', compact('service'));
    }
}