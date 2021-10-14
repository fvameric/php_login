M07 - CFGS DAW 2 - 21/22
## Ejercicio de registro, login y perfil

Consta de dos archivos html:
- index.html que será con el que se iniciará la página web en 000webhost.
- login.html para pedir otro formulario pero esta vez para loguearse.

Archivos php:
- db.php: conectividad con la base de datos.
- registro.php: se obtiene el nombre, email, contraseña y avatar del usuario y hace un insert.
- login.php: select a la tabla con todos los usuarios, mediante su nombre y contraseña comprueba si es posible acceder a profile.php.
- profile.php: la página de después del login. Aquí el usuario verá su nombre, su email y su avatar.
- profileAdmin.php: lo mismo que profile pero para administradores. Pueden ver el resto de usuarios. Falta implementar el CRUD.

Uploads:
- En esta carpeta se almacenan las imágenes seleccionadas, después se utiliza base64_encode para guardar dicho código en la base de datos, he utilizado LONGBLOB porque con VARCHAR o BLOB la cantidad de carácteres era inmensa y la imagen o no aparecía o salía a medias.

## Roadmap
- [x] Formulario de registro
- [x] Formulario de log in
    - [] Mejorar las validaciones de usuario
    - [] Encriptación de contraseñas
- [x] Página de perfil de usuario
- [x] Página de perfil para administradores
    - [] Consultar usuarios
    - [] Crear usuarios
    - [] Modificar usuarios
    - [] Eliminar usuarios
- [x] Poder subir una imagen como avatar
    - [] Mejorar la comprobación del formato de ficheros
    - [] Añadir avatares por defecto en caso de que no se seleccione ninguno
