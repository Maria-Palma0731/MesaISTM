<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $query = Ticket::with(['user', 'assignedTo'])
            ->select('tickets.*');

        // Aplicar filtros
        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }

        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        if (!empty($this->filters['assigned_to'])) {
            $query->where('assigned_to', $this->filters['assigned_to']);
        }

        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Folio',
            'Título',
            'Solicitante',
            'Técnico Asignado',
            'Categoría',
            'Subcategoría',
            'Prioridad',
            'Estado',
            'Fecha Creación',
            'Última Actualización',
            'Tiempo Resolución (horas)',
            'Calificación',
            'Comentario Calificación',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $resolutionTime = null;
        if ($row->status === 'resuelto') {
            $updated = $row->updated_at;
            $created = $row->created_at;
            $resolutionTime = round($created->diffInHours($updated), 1);
        }

        return [
            $row->folio,
            $row->title,
            $row->user->name,
            $row->assignedTo ? $row->assignedTo->name : 'Sin asignar',
            ucfirst($row->category),
            $row->subcategory ? ucfirst($row->subcategory) : 'N/A',
            ucfirst($row->priority),
            ucfirst(str_replace('_', ' ', $row->status)),
            $row->created_at->format('d/m/Y H:i'),
            $row->updated_at->format('d/m/Y H:i'),
            $resolutionTime,
            $row->rating,
            $row->rating_comment,
        ];
    }
}