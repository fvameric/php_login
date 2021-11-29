M07 - CFGS DAW 2 - 21/22
## Ejercicio de registro, login y perfil

Consta de dos archivos html:
- index.html que será con el que se iniciará la página web en 000webhost.
- login.php para pedir otro formulario pero esta vez para loguearse.

Archivos php:
- db.php: conectividad con la base de datos.
- registro.php: se obtiene el nombre, email, contraseña y avatar del usuario y hace un insert.
- login.php: select a la tabla con todos los usuarios, mediante su nombre y contraseña comprueba si es posible acceder a profile.php.
- profile.php: la página de después del login. Aquí el usuario verá su nombre, su email y su avatar. En caso de ser admin podrán ver el resto de usuarios.

Uploads:
- En esta carpeta se almacenan las imágenes seleccionadas, después se utiliza base64_encode para guardar dicho código en la base de datos, he utilizado LONGBLOB porque con VARCHAR o BLOB la cantidad de carácteres era inmensa y la imagen o no aparecía o salía a medias.

## Roadmap
- [x] Formulario de registro
- [x] Formulario de log in
    - [ ] Mejorar las validaciones de usuario
    - [X] Encriptación de contraseñas
- [x] Página de perfil
    - [X] Admin: Consultar usuarios
    - [X] Admin: Eliminar usuarios
    - [X] Consultar items tienda
    - [X] Crear items tienda
    - [X] Modificar items tienda
    - [X] Eliminar items tienda
- [x] Orden de productos
    - [ ] Filtrar Y ordenar los productos por categorias
    - [ ] Productos populares
- [x] Poder subir una imagen como avatar
    - [ ] Mejorar la comprobación del formato de ficheros
    - [X] Añadir avatares por defecto en caso de que no se seleccione ninguno
- [] Mejorar considerablemente el estilo de la página
    - [ ] Uso de SweetAlert2
    - [ ] Modo oscuro
- [x] Creación de XML
    - [ ] XML Personalizado a partir de una lista personal de productos
    - [] Subida de archivos XML para procesar productos y agregarlos en listas
- [ ] Distintos idiomas
- [ ] Consultar las necesidades de cada planta
    - [ ] Obtener la temperatura mediante la ubicación del usuario
