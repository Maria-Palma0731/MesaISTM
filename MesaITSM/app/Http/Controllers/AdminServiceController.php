<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\StoreServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminServiceController extends Controller
{
    /**
     * Lista de categorías de servicio
     */
    public function categories(): View
    {
        $categories = ServiceCategory::with('services')
            ->orderBy('order')
            ->get();

        return view('admin.catalog.categories.index', compact('categories'));
    }

    /**
     * Formulario para crear categoría
     */
    public function createCategory(): View
    {
        return view('admin.catalog.categories.create');
    }

    /**
     * Guardar nueva categoría
     */
    public function storeCategory(StoreServiceCategoryRequest $request): RedirectResponse
    {
        $category = ServiceCategory::create($request->validated());

        return redirect()
            ->route('admin.catalog.categories')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Formulario para editar categoría
     */
    public function editCategory(ServiceCategory $category): View
    {
        return view('admin.catalog.categories.edit', compact('category'));
    }

    /**
     * Actualizar categoría
     */
    public function updateCategory(StoreServiceCategoryRequest $request, ServiceCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.catalog.categories')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Eliminar categoría
     */
    public function destroyCategory(ServiceCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.catalog.categories')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    /**
     * Reordenar categorías
     */
    public function reorderCategories(Request $request): RedirectResponse
    {
        $request->validate([
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:service_categories,id']
        ]);

        foreach ($request->categories as $index => $id) {
            ServiceCategory::where('id', $id)->update(['order' => $index]);
        }

        return back()->with('success', 'Categorías reordenadas correctamente.');
    }

    /**
     * Lista de servicios
     */
    public function services(): View
    {
        $services = Service::with('category')
            ->orderBy('category_id')
            ->orderBy('order')
            ->get();

        return view('admin.catalog.services.index', compact('services'));
    }

    /**
     * Formulario para crear servicio
     */
    public function createService(): View
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.catalog.services.create', compact('categories'));
    }

    /**
     * Guardar nuevo servicio
     */
    public function storeService(StoreServiceRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $service = Service::create($request->validated());

            if (!$service->validateFormFields()) {
                throw new \Exception('La estructura de los campos del formulario no es válida.');
            }

            DB::commit();

            return redirect()
                ->route('admin.catalog.services')
                ->with('success', 'Servicio creado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear el servicio: ' . $e->getMessage());
        }
    }

    /**
     * Formulario para editar servicio
     */
    public function editService(Service $service): View
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.catalog.services.edit', compact('service', 'categories'));
    }

    /**
     * Actualizar servicio
     */
    public function updateService(StoreServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $service->update($request->validated());

            if (!$service->validateFormFields()) {
                throw new \Exception('La estructura de los campos del formulario no es válida.');
            }

            DB::commit();

            return redirect()
                ->route('admin.catalog.services')
                ->with('success', 'Servicio actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el servicio: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar servicio
     */
    public function destroyService(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.catalog.services')
            ->with('success', 'Servicio eliminado correctamente.');
    }

    /**
     * Reordenar servicios
     */
    public function reorderServices(Request $request): RedirectResponse
    {
        $request->validate([
            'services' => ['required', 'array'],
            'services.*' => ['required', 'exists:services,id']
        ]);

        foreach ($request->services as $index => $id) {
            Service::where('id', $id)->update(['order' => $index]);
        }

        return back()->with('success', 'Servicios reordenados correctamente.');
    }

    /**
     * Vista previa del formulario
     */
    public function previewForm(Request $request): View
    {
        $service = new Service([
            'name' => 'Vista Previa',
            'form_fields' => $request->form_fields
        ]);

        return view('admin.catalog.services.preview', compact('service'));
    }
}