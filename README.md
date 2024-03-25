#  Practica 6
> Objetivo

Demostrar un dominio básico en el manejo del lenguaje PHP del lado del servidor para una aplicación sencilla que aun no requiere acceso a datos.

> Desarrollo

- Se necesita desarrollar una pequeña aplicación web en la cual se implemente una funcionalidad de administrar archivos que se suben a la aplicación. Al decir administración se hace referencia a que se puedan realizar las siguientes operaciones: listar los archivos, mostrar archivo, subir archivo y borrar un archivo.

- Cada una de estas operaciones se deben implementar de la siguiente forma:

***Listar archivos***. Para implementar esta funcionalidad, se debe mostrar en un formato de tabla los nombres de los archivos que están en en directorio donde se suben los archivos a la aplicación. Esta lista en formato de tabla debe contener las las columnas: nombre del archivo, tamaño del archivo (en KiloBytes), borrar. En la columna del nombre del archivo se mostrará el nombre del archivo como un hyperlink (etiqueta 
`<a target="_blank">` para abrir en otra pestaña) la cual deberá contener un enlace para mostrar el archivo.

***Mostrar archivo***. Al momento de dar click en el hyperlink del archivo, este abre una pestaña con la URL a archivo.php?nombre={nombre del archivo con extensión}, la cual debe mostrar el contenido del archivo; es decir, si el archivo es una imagen jpeg, esta se debe mostrar, si es un archivo PDF, también se debe mostrar. Ver el archivo de código adjunto "archivo.php" e implementelo según considere en su aplicación.

***Subir archivo***. Aquí se debe implementar la subida de un archivo (para posteriormente mostrar este archivo en el listado de archivos disponibles). Se debe pedir el nombre del archivo a como se quiere guardar (input text) y el archivo a subir (input file), si no se especifica el nombre del archivo en el input, deberá guardarse con el nombre del archivo original. Siempre guardar el archivo con la extensión del archivo que se sube, por lo que si se especifica el nombre del archivo en el input text, al guardar el archivo se guardará con este nombre concatenado la extensión del archivo que se subió por el input file. También se considera que solo se podran subir archivo de imágenes (.jpe, .jpeg, .png, .gif) y archivos PDF (.pdf), por lo que tiene que validar que solo estos archivos se puedan subir. Esta funcionalidad puede ser implementada con un submit normal de un form (y después de subido el archivo, hacer el redirect a la misma página, donde se listan los archivos) o se puede subir el archivo por AJAX.

***Borrar archivo***. Al presionar al button borrar de la última columna del listado de archivos, se debe eliminar el archivo del servidor, además de eliminar el `<tr>` que muestra el archivo que se eliminó. Antes de eliminar, se debe pedir una confirmación de la operación con una función confirm en JS, en el cual se muestre un mensaje como "¿Está seguro que desea borrar image_0001.jpeg?", y al dar Aceptar u OK se elimine el archivo. Esta operación debe hacerse usando AJAX y enseguida borrar el `<tr>` donde se mostraba en el listado el archivo.

- Es necesario que implemente un mecanismo de autenticación y sesión sencillo para que no cualquiera pueda entrar a la aplicación. Para esto contemplar lo siguiente:
    - En la página index.php irá la implementación del listado de los archivos, subir los archivos, borrar archivo. Si no se ha iniciado sesión, se debe hacer un redirect a login.php.

    - En login.php mostrar un formulario de inicio se sesión sencillo, en el cual pida username y password, además de un input submit que haga el submit por POST para realizar el proceso de login. Para realizar la autenticación, hacer uso de la función "autentificar" en el archivo "login_helper.php".

    - Los usuario a utilizar estan en "login_helper.php" en $USERS, que son: admin|Admin1234 y user01|user01

    - Si se autenticó correctamente, se debe hacer el redirect a index.php (APP_ROOT) que es donde está la funcionalidad principal de la aplicación.

- También debe implementar una funcionalidad de terminar sesión.

- Solo los usuarios que son administradores se les mostrará la opción para subir archivo y para borrar archivo, a todos los otros usuarios, solo se les permite listar y mostrar los archivos. Tomar en cuanta las siguientes consideraciones:
    - Solo se pueden subir archivos de imágenes (.jpg, .jpeg, .png, .gif) y archivos PDF (.pdf): esto porque son los tipos de archivos que puede mostrar el web browser de forma facil.

    - Para mostrar el archivo, usar su implementación del archivo de código "archivo.php" adjunto aquí.

- Hacer un diseño sencillo, para que la aplicación no se muestre solo en blanco y negro: aplicar CSS

- Debe estar publicado en un hosting.
Modifique el archivo "config.php" con las rutas correctas para su caso.

> Entregables

- Archivo ZIP con los archivos del proyecto
- URL donde estará disponible la aplicación (porque debe estar en un hosting)