
# API de Ventas: TodoCamisetas (PHP Puro con MVC)

> **Examen Transversal Final de Desarrollo Backend.** Proyecto que implementa una API RESTful de alto rendimiento para un sistema de gestión y ventas de camisetas de fútbol.
>
> Este desarrollo demuestra la maestría en la **Arquitectura Modular (MVC)**, el **Enrutamiento Avanzado** y la implementación de **Lógica de Negocio Financiera** compleja en el Backend.

---

##  Arquitectura y Tecnología Backend

* **Patrón de Diseño:** Implementación estricta de la arquitectura **Modelo-Vista-Controlador (MVC)** utilizando **PHP Puro** (sin frameworks). Esto garantiza la **separación de responsabilidades** y la modularidad del código.
* **Base de Datos:** **MySQL** (`todocamisetas`) utilizando **PDO** (PHP Data Objects) para conexiones seguras y parametrizadas.
* **Ruteo Avanzado:** Sistema de *routing* implementado con **expresiones regulares** en `routes/index.php`, capaz de mapear rutas dinámicas (`/camisetas/{id}`) y manejar los diferentes métodos HTTP (GET, POST, PUT, PATCH, DELETE) de manera eficiente.

### Endpoints y Funcionalidad REST
La API expone **3 recursos principales** con operaciones **CRUD** completas:

| Recurso (Ruta) | Funcionalidad Principal | Acciones |
| :--- | :--- | :--- |
| `/camisetas` | Gestión del inventario (precio, club, código). | CRUD + Lógica de Descuentos. |
| `/clientes` | Gestión de clientes (con categorías 'regular', 'premium', 'vip'). | CRUD + Validación de unicidad de RUT. |
| `/tallas` | Gestión de tallas disponibles. | CRUD. |

---

## Lógica de Negocio y Precio Dinámico

El proyecto destaca por su lógica de negocio avanzada para el cálculo de precios, centralizada en el `CamisetaController` y `Camiseta.php`:

* **Cálculo de Precio Final:** El endpoint `GET /camisetas/{id}?cliente_id={id}` realiza un cálculo dinámico:
    1.  Toma como base el `precio_oferta` (si existe) o el `precio` regular.
    2.  Aplica el **`porcentaje_oferta`** asociado al cliente (según su categoría VIP/Premium).
    3.  Retorna el precio final listo para la venta (`precio_final`).
* **Validación Crítica:** Se implementa validación para evitar la eliminación de un **Cliente** que tiene **Camisetas asociadas** a través de la tabla `camiseta_tallas` (Claves Foráneas) .

## Documentación y Pruebas de Calidad

* **Documentación API (Swagger/OpenAPI 3.0):** Se proporcionó el archivo **`swagger.json`**, documentando exhaustivamente todos los *endpoints*, parámetros, y esquemas de datos (`Camiseta`, `Cliente`, `Talla`).
* **Colección Postman:** Se incluye la colección **`todocamisetas.postman_collection.json`** para validar la lógica de descuentos y todas las operaciones CRUD.
* **Pruebas de Integración:** Se validó el flujo de datos desde el controlador (input JSON) hasta la base de datos (Models) y viceversa, asegurando un código modular y funcional.

---

## Estructura del Proyecto (Patrón MVC)

```

.
├── config/                        \# Conexión a la Base de Datos (database.php)
├── controllers/                   \# Lógica de Peticiones HTTP (Controladores)
├── models/                        \# Lógica de la Base de Datos (Modelos)
├── routes/                        \# Sistema de Enrutamiento por Expresiones Regulares
├── public/                        \# Punto de Entrada y Cabeceras CORS
├── swagger/                       \# Documentación OpenAPI 3.0 (swagger.json)
├── todocamisetas.sql              \# Script de Creación e Inserción de Datos MySQL
└── README.md

```
