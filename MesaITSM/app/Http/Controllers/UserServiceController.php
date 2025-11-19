<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Ticket;
use App\Http\Requests\RequestServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

    /**
     * Formulario para solicitar servicio
     */
    public function requestForm(Service $service): View
    {
        if (!$service->is_active || !$service->category->is_active) {
            abort(404);
        }

        return view('user.catalog.request', compact('service'));
    }

    /**
     * Procesar solicitud de servicio
     */
    public function request(RequestServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Preparar descripción con los datos del formulario
            $description = "Solicitud de servicio: {$service->name}\n\n";
            
            if (isset($service->form_fields['campos']) && is_array($service->form_fields['campos'])) {
                foreach ($service->form_fields['campos'] as $field) {
                    $value = $request->input($field['name']);
                    if ($field['type'] === 'checkbox') {
                        $value = $value ? 'Sí' : 'No';
                    }
                    $description .= "{$field['label']}: {$value}\n";
                }
            }

            // Crear ticket
            $ticket = Ticket::create([
                'user_id' => auth()->id(),
                'service_id' => $service->id,
                'title' => "Solicitud: {$service->name}",
                'description' => $description,
                'folio' => date('Ymd') . strtoupper(Str::random(6)),
                'priority' => $service->priority_default,
                'status' => 'nuevo',
                'department' => $service->department,
            ]);

            DB::commit();

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', 'Solicitud enviada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al enviar la solicitud. Por favor intenta nuevamente.');
        }
    }
}