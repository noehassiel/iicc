<div align="center">

# n<span>/</span>h

**noehassiel**<br>
`artisan developer`

<br>

# IICC — sitio web

Instituto de Idioma y Cultura China en México, A.C. · [iicc.org.mx](https://iicc.org.mx/)

</div>

---

## Lo que es

El mismo sitio que ya tienen, con los mismos menús, pero con contenido más completo, diseño moderno y un panel para que el instituto lo edite sin tocar código.
Sin venta en línea: el llamado a la acción abre WhatsApp directo.

| | |
|---|---|
| **Menú** | Inicio · Cursos · Certificaciones · Becas · Otros Servicios · Eventos · Nosotros · Contacto |
| **Idiomas** | Español y chino **tradicional** (zh_TW) |
| **Panel** | Banner principal y eventos; después cursos, becas y reseñas de Google |
| **Hosting** | cPanel compartido: los assets se compilan en local |

## Stack

Laravel 13 · PHP 8.4 · Livewire 4 · Fortify · Tailwind v4 · Vite+ · Pest 5 · Larastan

## Arranque

```bash
composer setup   # env, key, migraciones, build de assets
composer dev     # servidor, vite y logs en local
```

El sitio lo sirve Laravel Herd en local.

## Comandos

```bash
php artisan test --compact               # pruebas
vendor/bin/pint --dirty --format agent   # formato de PHP
composer types:check                     # phpstan
composer test                            # pint + phpstan + pruebas (CI)
npm run build                            # assets de producción, antes de subir a cPanel
```

## Estructura

- `resources/views/pages/`: páginas públicas sobre `<x-layouts.site>`, sólo con Tailwind y Alpine.
- `resources/css/site.css`: CSS del sitio público, separado del `app.css` del panel.
- `lang/zh_TW.json`: traducciones; la llave es el texto exacto en español.
- `pages-info/`: textos del cliente por página y la propuesta firmada.

## Despliegue

1. `npm run build` en local.
2. Subir el proyecto a cPanel, con `public/` como raíz del dominio.
3. `php artisan migrate --force` y `php artisan storage:link`.

No usa colas, websockets ni Node en el servidor.

---

<div align="center">
<sub><b>n/h</b> · noehassiel · artisan developer · 2026</sub>
</div>
