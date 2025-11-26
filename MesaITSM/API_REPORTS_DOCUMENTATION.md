# API REST - Reportes y Estadísticas

## Módulo en el Dashboard

Este API corresponde al módulo **"Reportes y Estadísticas"** en el dashboard del administrador:

📊 **Icono**: Gráfico de barras naranja  
**Ubicación**: Dashboard > Módulos del Sistema > Reportes y Estadísticas  
**Descripción**: Análisis de rendimiento  
**Ruta Web**: `/administrador/reportes`

---

## Autenticación

Todas las rutas requieren autenticación mediante Laravel Sanctum. Incluir el token en el header:

```
Authorization: Bearer {token}
```

---

## Endpoints Disponibles

### 1. Dashboard General

**GET** `/api/reports/dashboard`

Obtiene estadísticas generales del sistema.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio (formato: Y-m-d)
- `date_to` (opcional): Fecha fin (formato: Y-m-d)

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": {
    "tickets": {
      "total": 150,
      "nuevos": 25,
      "en_proceso": 40,
      "resueltos": 70,
      "cerrados": 15
    },
    "usuarios": {
      "total": 85,
      "tecnicos": 7,
      "administradores": 2,
      "usuarios": 76
    },
    "conocimiento": {
      "total_articulos": 45,
      "publicados": 40,
      "borradores": 5,
      "total_vistas": 2340
    },
    "servicios": {
      "total": 30,
      "activos": 28,
      "categorias": 8
    },
    "rendimiento": {
      "tiempo_promedio_resolucion": 12.5,
      "tasa_resolucion_primer_contacto": 65.5,
      "tickets_por_dia": 5.2,
      "satisfaccion_promedio": 4.2
    }
  },
  "period": {
    "from": "2025-10-24",
    "to": "2025-11-24"
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/dashboard?date_from=2025-10-01&date_to=2025-11-24" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 2. Reporte de Tickets

**GET** `/api/reports/tickets`

Obtiene reporte detallado de tickets con filtros.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin
- `estado` (opcional): nuevo, asignado, en_proceso, pendiente_usuario, resuelto, cerrado
- `prioridad` (opcional): baja, media, alta, critica
- `tipo` (opcional): incidente, solicitud
- `tecnico_id` (opcional): ID del técnico asignado

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "titulo": "Problema con impresora",
        "estado": "resuelto",
        "prioridad": "media",
        "tipo": "incidente",
        "usuario": {
          "id": 5,
          "name": "Juan Pérez"
        },
        "tecnico": {
          "id": 2,
          "name": "María García"
        },
        "created_at": "2025-11-20T10:30:00",
        "updated_at": "2025-11-21T14:20:00"
      }
    ],
    "per_page": 50,
    "total": 150
  },
  "stats": {
    "total": 150,
    "por_estado": {
      "nuevo": 25,
      "asignado": 30,
      "resuelto": 70
    },
    "por_prioridad": {
      "baja": 40,
      "media": 60,
      "alta": 35,
      "critica": 15
    },
    "por_tipo": {
      "incidente": 90,
      "solicitud": 60
    }
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/tickets?estado=resuelto&prioridad=alta" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 3. Reporte de Rendimiento de Técnicos

**GET** `/api/reports/technicians`

Obtiene métricas de rendimiento de los técnicos.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": [
    {
      "id": 2,
      "nombre": "María García",
      "email": "maria.garcia@empresa.com",
      "tickets_asignados": 45,
      "tickets_resueltos": 40,
      "tickets_cerrados": 38,
      "tasa_resolucion": 88.89,
      "tiempo_promedio_resolucion": 8.5,
      "tiempo_promedio_resolucion_texto": "8.5 horas"
    },
    {
      "id": 3,
      "nombre": "Carlos López",
      "email": "carlos.lopez@empresa.com",
      "tickets_asignados": 38,
      "tickets_resueltos": 35,
      "tickets_cerrados": 33,
      "tasa_resolucion": 92.11,
      "tiempo_promedio_resolucion": 6.2,
      "tiempo_promedio_resolucion_texto": "6.2 horas"
    }
  ],
  "period": {
    "from": "2025-10-24",
    "to": "2025-11-24"
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/technicians?date_from=2025-11-01" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 4. Reporte de Servicios Más Solicitados

**GET** `/api/reports/services`

Obtiene los servicios más solicitados.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": [
    {
      "id": 5,
      "nombre": "Instalación de Software",
      "categoria": "Software",
      "total_solicitudes": 45,
      "solicitudes_resueltas": 42,
      "tasa_resolucion": 93.33
    },
    {
      "id": 12,
      "nombre": "Soporte de Red",
      "categoria": "Infraestructura",
      "total_solicitudes": 38,
      "solicitudes_resueltas": 35,
      "tasa_resolucion": 92.11
    }
  ],
  "period": {
    "from": "2025-10-24",
    "to": "2025-11-24"
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/services" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 5. Reporte de Base de Conocimiento

**GET** `/api/reports/knowledge-base`

Obtiene estadísticas de la base de conocimiento.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": [
    {
      "id": 3,
      "titulo": "Cómo resetear tu contraseña",
      "categoria": "Preguntas Frecuentes",
      "vistas": 312,
      "autor": "Admin Usuario",
      "publicado": true,
      "fecha_creacion": "2025-10-15"
    },
    {
      "id": 8,
      "titulo": "Configuración de VPN",
      "categoria": "Documentación Técnica",
      "vistas": 234,
      "autor": "María García",
      "publicado": true,
      "fecha_creacion": "2025-11-05"
    }
  ],
  "stats": {
    "total_articulos": 45,
    "articulos_publicados": 40,
    "total_vistas": 5680,
    "promedio_vistas": 126.22,
    "por_categoria": [
      {
        "category": "guias",
        "total": 15,
        "vistas": 2100
      },
      {
        "category": "faq",
        "total": 18,
        "vistas": 2400
      }
    ]
  },
  "period": {
    "from": "2025-10-24",
    "to": "2025-11-24"
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/knowledge-base" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 6. Reporte de Tendencias

**GET** `/api/reports/trends`

Obtiene tendencias temporales de tickets.

#### Parámetros (Query)
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin
- `group_by` (opcional): day, week, month (default: day)

#### Respuesta Exitosa (200)
```json
{
  "success": true,
  "data": {
    "tickets_creados": [
      {
        "fecha": "2025-11-20",
        "total": 12
      },
      {
        "fecha": "2025-11-21",
        "total": 15
      },
      {
        "fecha": "2025-11-22",
        "total": 8
      }
    ],
    "tickets_resueltos": [
      {
        "fecha": "2025-11-20",
        "total": 10
      },
      {
        "fecha": "2025-11-21",
        "total": 13
      },
      {
        "fecha": "2025-11-22",
        "total": 11
      }
    ]
  },
  "period": {
    "from": "2025-11-20",
    "to": "2025-11-24"
  }
}
```

#### Ejemplo de uso
```bash
curl -X GET "http://localhost:8000/api/reports/trends?group_by=day" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 7. Exportar Reportes

**GET** `/api/reports/export`

Exporta reportes en diferentes formatos.

#### Parámetros (Query) - Requeridos
- `type`: tickets, technicians, services, knowledge-base
- `format`: json, csv, pdf
- `date_from` (opcional): Fecha inicio
- `date_to` (opcional): Fecha fin

#### Respuesta Exitosa (200)
Para JSON: Retorna el reporte en formato JSON
Para CSV: Descarga archivo CSV
Para PDF: Descarga archivo PDF (en desarrollo)

#### Ejemplo de uso
```bash
# Exportar a CSV
curl -X GET "http://localhost:8000/api/reports/export?type=tickets&format=csv&date_from=2025-11-01" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  --output tickets_report.csv

# Exportar a JSON
curl -X GET "http://localhost:8000/api/reports/export?type=technicians&format=json" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

## Códigos de Estado HTTP

- `200 OK`: Solicitud exitosa
- `400 Bad Request`: Parámetros inválidos
- `401 Unauthorized`: No autenticado
- `403 Forbidden`: Sin permisos
- `404 Not Found`: Recurso no encontrado
- `422 Unprocessable Entity`: Error de validación
- `500 Internal Server Error`: Error del servidor
- `501 Not Implemented`: Funcionalidad no implementada

---

## Errores

Formato de respuesta de error:

```json
{
  "success": false,
  "message": "Descripción del error",
  "errors": {
    "campo": [
      "Mensaje de error específico"
    ]
  }
}
```

---

## Ejemplos de Integración

### JavaScript (Fetch API)

```javascript
const token = 'tu_token_aqui';

// Obtener dashboard
fetch('http://localhost:8000/api/reports/dashboard?date_from=2025-11-01', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json',
  }
})
.then(response => response.json())
.then(data => {
  console.log('Dashboard:', data);
})
.catch(error => console.error('Error:', error));
```

### PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8000',
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ]
]);

$response = $client->get('/api/reports/tickets', [
    'query' => [
        'estado' => 'resuelto',
        'date_from' => '2025-11-01',
    ]
]);

$data = json_decode($response->getBody(), true);
```

### Python (Requests)

```python
import requests

token = 'tu_token_aqui'
headers = {
    'Authorization': f'Bearer {token}',
    'Accept': 'application/json',
}

response = requests.get(
    'http://localhost:8000/api/reports/technicians',
    headers=headers,
    params={'date_from': '2025-11-01'}
)

data = response.json()
print(data)
```

---

## Notas Importantes

1. **Límite de Paginación**: Los endpoints que retornan listas paginan resultados en 50 elementos por página.

2. **Formato de Fechas**: Todas las fechas deben enviarse en formato ISO 8601 (Y-m-d) o (Y-m-d H:i:s).

3. **Caché**: Las respuestas pueden ser cacheadas. Para forzar datos frescos, agregar parámetro `?refresh=1`.

4. **Rate Limiting**: Las APIs tienen límite de 60 solicitudes por minuto por usuario autenticado.

5. **Zona Horaria**: Todas las fechas están en zona horaria UTC. Ajustar según sea necesario.

---

## Soporte

Para reportar problemas o solicitar nuevas funcionalidades en la API de reportes, contactar al equipo de desarrollo.
