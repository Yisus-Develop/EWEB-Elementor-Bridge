# Estado del Sistema: EWEB Elementor Bridge (V10.3)

> **Última Actualización:** 08 Enero 2026
> **Estado:** ✅ Estable / Producción
> **Arquitectura:** V10 (Desacoplada)

## 🏗️ Arquitectura Actual

Hemos evolucionado a un sistema desacoplado (Data vs. Visual) para máxima seguridad y escalabilidad.

### 🔌 Plugins Activos

| Plugin | Versión | Responsabilidad | Ubicación |
| :--- | :--- | :--- | :--- |
| **CPS Site Core** | 1.0.0 | **DATOS.** Define qué es un "Proyecto" y sus categorías. Independiente del diseño. | `/wp-content/plugins/cps-site-core/` |
| **CPS Official Widgets** | 10.3.0 | **DISEÑO.** Conjunto de widgets de Elementor que leen o muestran información. | `/wp-content/plugins/eweb-official-widgets/` |

### 📂 Estructura de Archivos (Widgets)

```text
/wp-content/plugins/eweb-official-widgets/
├── plugin.php           <-- [LOADER] Solo carga widgets.
└── widgets/
    ├── services-widget.php  <-- [LOOP] Servicios con Repeater.
    ├── intro-widget.php     <-- [STATIC] Intro moderna.
    └── hello-widget.php     <-- [TEST] Diagnóstico.
```

## 🧩 Componentes Funcionales

### 1. Widgets Personalizados (Elementor)

| Widget | ID | Estado | Loop Dinámico? |
| :--- | :--- | :--- | :--- |
| **Intro** | `cps_modern_intro` | ✅ Activo | No (Texto fijo/control simple) |
| **Servicios** | `cps_services_asymmetric` | ✅ Activo | **SÍ** (Repeater integrado) |

### 2. Estructuras de Datos (Core)

| Tipo | Slug | Gestionado por | Estado |
| :--- | :--- | :--- | :--- |
| **CPT Projetos** | `projeto` | `CPS Site Core` | ✅ Restaurado y Seguro |
| **Categorías** | `categoria_projeto` | `CPS Site Core` | ✅ Activo |

## 🚀 Hoja de Ruta (Siguientes Pasos)

1. **Loop de Proyectos:** Crear un nuevo widget en `eweb-official-widgets/widgets/projects-widget.php` que lea los datos del plugin Core.
2. **Iteración Visual:** Ajustar CSS/Diseño en Figma y actualizar los archivos de widgets correspondientes.
