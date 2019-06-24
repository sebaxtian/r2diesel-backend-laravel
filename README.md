# r2diesel-backend-laravel

Construccion de API para prueba tecnica en R2Diesel desarrollado usando como Backend el Framework Laravel.

* Para ejecutar ejecutar el proyecto se puede ejecutar usando la configuracion de Homestead, para esto leer la documentacion de Homestead:
  - Homestead: https://laravel.com/docs/5.8/homestead
  - Tambien pueden consultar esta informacion en mi blog: https://ideafalaz.blogspot.com/2019/06/instalar-y-configurar-laravel-php.html
  - Renombrar el archivo **Homestead.example.yaml** -> **Homestead.yaml**
    - Modificar **PATH-TO** por el path absoluto al directorio del proyecto r2diesel-backend-laravel
  - Renombrar el archivo **.env.example** -> **.env**
    - Verificar en **.env**:
      ```sh
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=homestead
        DB_USERNAME=homestead
        DB_PASSWORD=secret
      ```
  * Realizar la configuracion del **hostname** para el proyecto como se describe aqui:
    - https://ideafalaz.blogspot.com/2019/06/instalar-y-configurar-laravel-php.html
    - El hosname utilizado para el proyecto es **r2diesel-backend.test**
