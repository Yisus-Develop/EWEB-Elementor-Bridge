# EWEB Elementor Bridge 🌉

**Arquitectura V10 (Desacoplada & Robusta)**

> "Diseño sin límites, Edición sin código."

Este proyecto implementa una arquitectura profesional ("El Puente") para combinar el poder del **Diseño Personalizado (Code-First)** con la facilidad de edición de **Elementor**.

## 🧠 Filosofía del Proyecto

El objetivo es evitar las limitaciones visuales de los widgets estándar de Elementor sin perder la capacidad de edición para el cliente final.

1. **Nosotros (Developers):** Escribimos HTML y CSS real en archivos PHP. Controlamos el píxel, el rendimiento y la semántica.
2. **El Cliente (Editors):** Usa Elementor solo para cambiar textos, imágenes y enlaces. No pueden "romper" el diseño porque la estructura está protegida en el código.

---

## 🏗️ Estructura del Sistema

Hemos dividido el sistema en dos piezas fundamentales para garantizar estabilidad y datos persistentes.

### 1. 🧠 CPS Site Core (Datos)

* **Responsabilidad:** "El Cerebro". Maneja qué DATOS existen.
* **Ruta:** `/wp-content/plugins/cps-site-core/`
* **Contenido:**
  * Custom Post Types (Ej: `Projetos`).
  * Taxonomías (Ej: `Categorias`, `Tipos de Serviço`).
* **Ventaja:** Si cambias de tema visual o de builder, tus datos NO SE PIERDEN.

### 2. 🎨 EWEB Official Widgets (Puente Visual)

* **Responsabilidad:** "La Cara". Muestra los datos con diseño personalizado.
* **Ruta:** `/wp-content/plugins/eweb-elementor-bridge/`
* **Arquitectura:**
  * `plugin.php`: El "Cargador". Solo "despierta" cuando Elementor está listo. Evita errores fatales.
  * `widgets/`: Carpeta donde vive la magia. Un archivo PHP por cada diseño.

---

## 🧠 Strategy: Smart Reuse & Style Models

Instead of creating a new widget for every design variation, we follow the **"One Widget, Multiple Models"** compatibility rule:

1. **Do Not Clone:** Never duplicate a widget just to change CSS.
2. **Use Style Models:** Add a "Style/Skin" selector control to the existing widget.
    * *Example:* The `Services Widget` should have a dropdown: `[Grid Layout]`, `[Carousel Layout]`.
    * Each model loads a different CSS class or Template Part, but reuses the same Logic.
3. **Future Proofing:** Since we extend `\Elementor\Widget_Base`, we inherit all core updates automatically.

### ♻️ Reuse Guide: When to Code vs. When to Reuse?

We use **ProElements** (GPL Elementor Pro) to avoid reinventing the wheel.

| Feature Type | Recommendation | Widget to Use |
| :--- | :--- | :--- |
| **Simple Image/Text** | ✅ **REUSE** | Standard Image / Heading / Text Editor |
| **Forms (Contact)** | ✅ **REUSE** | **Pro Form** (Included in ProElements) |
| **Blog / News Grid** | ✅ **REUSE** | **Posts Widget** + Custom Skin (CSS) |
| **Sliders** | ✅ **REUSE** | **Slides Widget** (Basic) or **Loop Carousel** (Advanced) |
| **Complex Layouts** | 🛠️ **CODE (Bridge)** | **Custom EWEB Widget** (Like `services-widget.php`) |
| **Highly Interactive** | 🛠️ **CODE (Bridge)** | **Custom EWEB Widget** (For Parallax, WebGL, Heavy JS) |

---

## 🛠️ Flujo de Trabajo: Figma a Elementor

Cuando quieras crear una nueva sección personalizada (ej: "Hero con Efecto Parallax"):

1. **Diseño:** Creas el visual en Figma.
2. **Código:** Creas un archivo `widgets/hero-parallax.php`.
    * Copias tu HTML y CSS aquí.
3. **Puente (Controles):**
    * En la función `register_controls()`, añades campos (Título, Foto de Fondo).
    * En la función `render()`, reemplazas el texto estático por la variable de Elementor (ej: `$settings['titulo']`).
4. **Resultado:** Tienes un bloque pixel-perfect 100% editable.

## 📂 Inventario Actual (V10)

| Archivo | Función | Tipo |
| :--- | :--- | :--- |
| `widgets/intro-widget.php` | Intro Animada | Estático |
| `widgets/services-widget.php` | Grid de Servicios | **Loop Dinámico (Repeater)** |
| `widgets/projects-widget.php` | Loop de Proyectos | **Query Loop (CPT)** |

---
**Desarrollado para CPS LDA por Yisus Dev & Antigravity**
