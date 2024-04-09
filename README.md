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

-------------------------
**Objetivo**

Que el alumno demuestre el dominio de programación del lado del servidor para resolver el problema de crear una aplicación web con funcionalidad básica que incluye el inicio de sesión, manejo de sesión y acceso a datos.

**Desarrollo**

>_Registro de nuevos usuarios_

Crear una página para que los nuevos usuarios puedan registrarse, esto es pedir los datos necesarios para su registro: nombre, apellidos, username (que para nuestro caso debe ser una dirección de correo electrónico), password, confirmación del password, genero (M = Masculino, F = Femeninio, X = Prefiero no especificar) y fecha de nacimiento. 

Cabe mencionar que el username tiene que se un correo electrónico, por lo que hay que validar que se haya ingresado una dirección de correo; puede ser una validación básica, es decir que solo se valide si el valor que se ingresó tiene un '@' y también que el texto después del @ contenga un '.' (punto). Además al momento de registrarse se tiene que validar que no exista otro usuario con el mismo username.

Todos los campos son obligatorios, así que tiene que validar tanto del lado del cliente como del lado del servidor (código PHP). Además que los campos que son cadenas de texto (username, nombre, apellidos) se debe validar que no se ingresen puros caracteres de espacios en blanco ' ', y al momento de guardar los datos en la base de datos, se debe hacer un trim() para quitar los espacios en blanco que al usuario se le hayan podido haber ido por accidente.

Es importante que al momento de guardar en base de datos los datos del usuario, el password del usuario se guarde cifrado de la siguiente forma: generar el password salt (64 caracteres aleatorios), al password en texto plano concatenarle al final el salt generado, al password en texto plano concatenado con el salt generarle el SHA512 y este será el password_encrypted.

> _Cambiar contraseña_

Agregar una opción para que una vez que el usuario ya haya iniciado sesión, este pueda cambiar la contraseña. Recordando que la contraseña en base de datos se guarda cifrada.

> _Modificar datos personales_

El usuario también debe poder modificar sus datos personales: nombre, apellidos, genero y fecha de nacimiento. Tenga en cuanta que todos los datos son obligatorios, además que se tienen que validar tanto del lado del cliente como del lado del servidor (código PHP); además así como en el registro de nuevos usuarios, también se debe validar que no se hayan ingresado puros caracteres de espacios en blanco (' ') y al guardar hacer trim() para quitar los espacios en blanco que se hayan ido de más.

>_Hacer Público/Privado un archivo_

En index, se tiene el listado de los archivos más recientes subidos por el usuario, aquí se pide que se imlpemente la funcionalidad de los archivos que muestran ahí hacerlos públicos o privados según sea el caso. Para esto tendrá que implementar una llamada AJAX para ejecutar esta funcionalidad, puesto que ya está medio implementado además de diseñado para que sea con llamada AJAX la modificación del registro del archivo en DB para modificar el campo de es_publico.

> _Mis Archivos_

En esta sección, el usuario podrá ver todos los archivos que ha subido a la aplicación, con la diferencia que para poder ver los archivos, estos se deben consultar seleccionando el año-mes de los archivos que se quieren consultar.

Para implementar la funcionalidad de consulta de los archivos por año-mes, se puede implementar con dos combo-box (input de tipo select-option), el primero para seleccionar el año (que muestra los años del 2023 al año actual el orden decreciente, es decir 2024, 2023) y el otro combo-box para seleccionar el mes. Después dar click en un boton de consultar y que se muestre el listado de los archivos.

Por default al entrar a esta sección se deben mostrar los archivos del año y mes actual.

Al mostrar los archivos también se deben mostrar las operaciones que se muestra en la página principal (index), que es el poder ver, descargar, hacer público/privado y borrar el archivo.

< _De Otros_

Para esta sección se implementa la consulta de los archivos de otros usuarios. Los archivos de otros usuarios solo deben poder listarse los que son públicos, con excepción de que si es un usuario admin, entonces podrá ver los archivos tanto publicos como los que no lo son.

El proceso para consultar los archivos de otros usuarios es el siguiente: primero se debe buscar un usuario, ya sea por su nombre o por su username, después se debe mostrar el listado de los usuarios que se encontraron para la búsqueda, donde cada resultado encontrado debe ser un link para llevar a una página parecida a "Mis Archivos", es decir que listen los archivos del mes actual y se pueda consultar por año-mes (combobox).

En la primera parte, la consulta de los usuario por su username o nombre, se debe tener un campo de texto para introducir el parámetro de búsqueda, si introduce un texto que tenga un '@' la consulta se realizará por username (recordando que los usernames son direcciones de email), de otra forma se debe consultar por el nombre. La consulta debe realizarse con una operación LIKE en DB, es decir, que si se introduce "luis%@gmail" debe regresar resultados como "luisroberto@gmail.com" "luisflores@gmail.com" "luisalbertofuentes@gmail.com"... Esto también aplica para la busqueda por nombre: si se introduce "luis" debe regresar resultados como "Luis Roberto Flores", "Jose Luis Alfaro", "Luis Carlos Rodríguez"...

Para mostrar los archivos en esta sección, se listarán como en "Mis Archivos" y tener las operaciones de ver el archivo y descargar el archivo; pero si un usuario es Admin, también se debe mostrar la opción de borrar el archivo.

Cabe mencionar que todas las operaciones de ver o descargar, así como borrar un archivo, deben registrarse en archivos_log_general en DB.

Entregables
Source code de su aplicación web en una carpeta ZIP
Imágenes de evidencia de su aplicación funcionando en otra carpeta ZIP
La revisión/evaluación de la práctica se realizará en clase