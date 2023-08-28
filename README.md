# API LARAVEL de Rick & Morty
## INSTALACION
- git clone https://github.com/DonChia-S/rick-and-morty-apiLaravel.git
- cd rick-and-morty-apiLaravel

- ### BACKEND
    - cd ./server
    - Tener en cuenta la instalación de composer y php version >8
    - Ejecutar comando php artisan server --port=7500

- ### FRONTEND
    - cd ./client
    - npm install
    - npm run build
    - npm run start:dev

## ANALISIS Y ENTENDIMIENTO
- Por medio de Laravel, guardar información de la api de rick y morty por medio de sqlite, indicando las diferentes funciones que son crear, eliminar, editar, buscar.
- Dependiendo la estructura de la api dada, se genero la estructura de las tablas para poder guardar la información en sqlite.
- Me di cuenta en el fronted que algunos consumos simulaban un token en los headers. Entonces se realizo la validacion de ese token.
- Adaptar la api en desarrollo a la implementada en el fronted teniendo en cuenta que pasaba como parametro el tipo de api y yo lo iguale al nombre de la tabla, es decir, el servicio de rickymorty episode, yo le coloque el mismo nombre a la tabla de sqlite para mayor dinamismo y respetar la estructura establecida.
- En caso de vaciar las tablas, se genero un endpoint para genera la migracion de datos de la api dada a las tablas.

## DESARROLLO
- Se creo la conexio a sqlite con el archivo existente cambio el nombre a database y ubicarla en la carpeta ./server/database/database.sqlite.
- Se creo las migraciones para las apis restantes(episode, location).
- Se creo un controlador donde esta todos los servicio necesarios para el CRUD.
- Se genero las rutas en la carpeta ./server/routes/api.
- Se realizo un endpoint para hacer la migracion de datos en caso que este vacias las tablas(episode, location).

## COMPILACIONES
- En caso de que la base de datos entregada rickandmorty_v1.db se debe ejecutar lo siguiente:
- Se debe renombra el archivo a database.sqlite y ponerlo en la siguiente ruta ./server/database/ para que se mantega la tabla de characters    predeterminada.
- php artisan migrate ya que se genera las migraciones para las otras tablas.
- En caso que falle el comando, se debera generar actualizacion del nombre del archivo de migracion.
- y si desea realizar la migracion de los datos, ejecutar estos dos endpoints:
- {GET} http://localhost:7500/api/migrate/episode
- {GET} http://localhost:7500/api/migrate/location


 