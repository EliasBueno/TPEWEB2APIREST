# Documentación de la API

## Descripción

API tipo REST que permite gestionar recursos de **Productos** y **Sucursales**. La API ofrece servicios CRUD completos, con opciones de Filtrado, Ordenamiento y Acciones específicas como obtener productos en oferta. No está autenticada.

## Endpoints

### Productos

#### URL: `http://localhost/TPE-WEB-3/api/productos`

**Método**: GET

- Devuelve una lista de todos los productos.
- **Código de respuesta**: 200 OK, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/productos/:ID`

**Método**: GET

- Devuelve un producto específico por su `ID`.
- **Código de respuesta**: 200 OK, 404 Not Found

#### URL: `http://localhost/TPE-WEB-3/api/productos/en_oferta`

**Método**: GET

- Devuelve una lista de los productos que están actualmente en oferta.
- **Código de respuesta**: 200 OK, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/productos`

**Método**: POST

- Permite agregar un nuevo producto. Devuelve el `ID` del producto recién creado.
- **Código de respuesta**: 201 Created, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/productos/:ID`

**Método**: PUT

- Permite editar un producto específico mediante su `ID`. Devuelve el objeto actualizado del producto.
- **Código de respuesta**: 200 OK, 404 Not Found

#### URL: `http://localhost/TPE-WEB-3/api/productos/:ID`

**Método**: DELETE

- Permite eliminar un producto específico mediante su `ID`. Devuelve el objeto del producto eliminado.
- **Código de respuesta**: 200 OK, 404 Not Found

### Sucursales

#### URL: `http://localhost/TPE-WEB-3/api/sucursales`

**Método**: GET

- Devuelve una lista de todas las sucursales.
- **Código de respuesta**: 200 OK, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/sucursales/:ID`

**Método**: GET

- Devuelve una sucursal específica por su `ID`.
- **Código de respuesta**: 200 OK, 404 Not Found

#### URL: `http://localhost/TPE-WEB-3/api/sucursales/:ID`

**Método**: DELETE

- Permite eliminar una sucursal específica mediante su `ID`. Devuelve el objeto de la sucursal eliminada.
- **Código de respuesta**: 200 OK, 404 Not Found

#### URL: `http://localhost/TPE-WEB-3/api/sucursales`

**Método**: POST

- Permite agregar una nueva sucursal. Devuelve el `ID` de la sucursal recién creada.
- **Código de respuesta**: 201 Created, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/sucursales/:ID`

**Método**: PUT

- Permite editar una sucursal específica mediante su `ID`. Devuelve el objeto actualizado de la sucursal.
- **Código de respuesta**: 200 OK, 404 Not Found

## Parámetros adicionales para ordenamiento y filtrado

### Ordenar productos o sucursales

#### URL: `http://localhost/TPE-WEB-3/api/productos?sort=id&order=desc`

**Método**: GET

- Permite ordenar los productos según el campo `id` de manera descendente (`desc`) o ascendente (`asc`).
- Si el parámetro `order` no tiene un valor válido ('asc' o 'desc'), la API devolverá un error `400 Bad Request`.
- **Código de respuesta**: 200 OK, 400 Bad Request

### Filtrar productos o sucursales por valores específicos

#### URL: `http://localhost/TPE-WEB-3/api/productos?value=valor`

**Método**: GET

- Permite filtrar los productos por valores específicos del campo `marca` (ej. "Bugatti", "BMW", etc.). Si el valor del campo `marca` no es válido, la API devolverá un error `400 Bad Request`.
- **Código de respuesta**: 200 OK, 400 Bad Request

#### URL: `http://localhost/TPE-WEB-3/api/sucursales?value=valor`

**Método**: GET

- Permite filtrar las sucursales por características específicas. Solo se permite filtrar por características válidas.
- **Código de respuesta**: 200 OK, 400 Bad Request

## Estructura de los recursos

### Productos:

- `id_producto`, `nombre`, `anio`, `motor`, `marca`, `id_categoria`, `caracteristicas`.

### Sucursales:

- `id_sucursal`, `nombre`, `direccion`, `caracteristicas`.

### Valores del campo **Marca** del recurso Productos:

- Bugatti, BMW, Renault, Ferrari, Lamborghini.

### Palabras clave del campo **Características** del recurso Sucursales:

- `mejor`, `aceleracion`.

## Notas adicionales

- La API no requiere autenticación.
- Las respuestas de la API son siempre en formato JSON.
- Las solicitudes deben incluir los parámetros correctos; de lo contrario, la API devolverá un error `400 Bad Request`.

## Repositorio GitHub

[https://github.com/EliasBueno/TPEWEB2APIREST.git](https://github.com/EliasBueno/TPEWEB2APIREST.git)
