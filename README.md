# Lechuga Negra - PrivKeyManager para Laravel

Este paquete de Laravel proporciona un sistema de autenticación JWT para llaves privadas y robusto para tus aplicaciones.

## Características Principales

* **Autenticación JWT:** Utiliza JSON Web Tokens (JWT) para una autenticación segura y sin estado.
* **Inicio de Sesión:** Proceso de inicio de sesión completo con generación de tokens JWT.
* **Middleware de Autenticación:** Middleware para proteger rutas y asegurar que solo usuarios autenticados puedan acceder.
* **Endpoint de validación de token:** Endpoint para validar token de autenticación, su objetivo es para uso de microservicio.

## Instalación

1.  **Crear grupo de paquetes:**

    Crear la carpeta packages en la raíz del proyecto e ingresar a la carpeta:

    ```bash
    mkdir packages
    cd packages
    ```

    Crear el grupo de carpetas dentro de la carpeta creada, e ingresar a l carpeta:
    
    ```bash
    mkdir lechuganegra
    cd lechuganegra
    ```

2.  **Clonar el paquete:**

    Clonar el paquete en el grupo de carpetas creado y renombrarlo para que el Provider pueda registrarlo en la instalación

    ```bash
    git clone https://github.com/mtorres-lechuganegra/package-privkeymanager.git privkeymanager
    ```

3.  **Configurar composer del proyecto:**

    Dirígite a la raíz de tu proyecto, edita tu archivo `composer.json` y añade el paquete como repositorio:

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "packages/lechuganegra/PrivKeyManager"
            }
        ]
    }
    ```
    también deberás añadir el namespace del paquete al autoloading de PSR-4:

    ```json
    {
        "autoload": {
            "psr-4": {
                "LechugaNegra\\PrivKeyManager\\": "packages/lechugaNegra/PrivKeyManager/src/"
            }
        }
    }
    ```

4.  **Ejecutar composer require:**

    Después de editar tu archivo, abre tu terminal y ejecuta el siguiente comando para agregar el paquete a las dependencias de tu proyecto:

    ```bash
    composer require lechuganegra/PrivKeyManager:@dev
    ```

    Este comando descargará el paquete y actualizará tu archivo `composer.json`.

5.  **Generar la clave secreta de JWT:**

    Ejecuta el siguiente comando para generar la clave secreta que se utilizará para firmar los tokens JWT:

    ```bash
        php artisan jwt:secret
    ```

    Este comando agregará la clave secreta a tu archivo `.env`.

    > Si el proyecto ya tiene configurado JWT previamente, este paso no es necesario.
6.  **Ejecutar las migraciones:**

    Ejecuta las migraciones del paquete para crear las tablas necesarias en la base de datos:

    ```bash
    php artisan migrate --path=packages/lechuganegra/PrivKeyManager/src/Database/Migrations
    ```

7.  **Limpiar la caché:**

    Limpia la caché de configuración y rutas para asegurar que los cambios se apliquen correctamente:

    ```bash
    php artisan config:clear
    php artisan config:cache
    php artisan route:clear
    php artisan route:cache
    ```
    
8.  **Regenerar clases:**

    Regenerar las clases con el cargador automático "autoload"

    ```bash
    composer dump-autoload
    ```

## Uso

### Endpoints del Servicio

Puede importar el archivo `postman_collection.json` que se ubica en la carpeta `docs` de la raíz del paquete.

### Comando de creación de llave

Solo la key

```bash
php artisan privkey:create
```

Con expiración

```bash
php artisan privkey:create --expires_at="2026-12-31 23:59:59"
```

Con referer

```bash
php artisan privkey:create --referer_url="https://app.cientifica.edu.pe"
```

Con ambos

```bash
php artisan privkey:create --expires_at="2026-12-31 23:59:59" --referer_url="https://app.cientifica.edu.pe"
```

### Middleware de Autenticación

El paquete registra automáticamente el middleware `priv.key`. Úsalo para proteger las rutas que requieren autenticación por API Key:

```php
Route::middleware(['priv.key'])->group(function () {
    // Rutas protegidas
});
```
