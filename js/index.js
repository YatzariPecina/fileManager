
const labelUsuario = document.getElementById('nombreUsuario');
const contenedorUsuario = document.getElementById('clickedSession');
const tabla = document.getElementById('tablaArchivos');

const mensaje = document.getElementById('mensaje');
const file = document.getElementById('file');
const nombreArchivo = document.getElementById('nombreArchivo');

var esAdmin = false;

$(document).ready(function () {
    mostrarUsuario();
    actualizarTabla();

    // Asignar evento clic a los botones "Borrar" en cada fila
    $(document).on('click', '.borrar-archivo', function () {
        // Obtener el nombre del archivo a borrar y mostrar el mensaje de confirmación
        var nombreArchivo = $(this).closest('tr').find('td:first').text();
        if (confirm("¿Está seguro que desea borrar " + nombreArchivo + "?")) {
            // Si se confirma la eliminación, llamar a la función para borrar el archivo
            var fila = $(this).closest('tr');
            borrarArchivo(nombreArchivo, fila);
        }
    });
});

function borrarArchivo(nombreArchivo, fila) {
    // Realizar solicitud AJAX para borrar el archivo del servidor
    $.ajax({
        url: './php/index.php',
        type: 'POST',
        data: { nombreFile: nombreArchivo },
        success: function (response) {
            // Si la eliminación es exitosa, eliminar la fila de la tabla
            fila.remove();
            // Mostrar mensaje de éxito
            alert("Archivo " + nombreArchivo + " eliminado correctamente.");
        },
        error: function (xhr, status, error) {
            // Mostrar mensaje de error
            alert("Error al intentar borrar el archivo: " + error);
        }
    });
}

function actualizarTabla() {
    $.ajax({
        url: "./php/index.php",
        type: "GET",
        success: function (response) {

            var filaEncabezado = $('#encabezado');

            // Limpiar todas las filas después del encabezado
            filaEncabezado.nextAll().remove();

            // Iterar en la respuesta JSON
            $.each(response, function (index, archivo) {
                // Nueva fila
                var newRow = $("<tr>");

                newRow.append('<td><a href="./php/archivo.php?nombre=' + archivo.nombre + '" target="_blank">' + archivo.nombre + '</a></td>');
                newRow.append("<td>" + archivo.size + "Kb</td>");
                newRow.append('<td><button class="borrar-archivo">Borrar</button></td>');

                // Insertar fila después de la fila encabezado
                filaEncabezado.after(newRow);
            });

            if(esAdmin){
                isAdmin();
            }
        }
    });
}

function mostrarUsuario() {
    $.ajax({
        url: "./php/login.php",
        type: "GET",
        success: function (response) {
            if (response == "401") {
                //Variable para regresar al login
                window.location.href = "login.html";
            } else {
                //Mandar el nombre a la ventana
                labelUsuario.innerHTML = "Cerrar sesion";
                contenedorUsuario.onclick = function () {
                    cerrarSesion();
                };

                esAdmin = response.esAdmin;
                if (esAdmin) {
                    isAdmin();
                }
            }
        }
    });
}

function cerrarSesion() {
    $.ajax({
        url: './php/login.php',
        type: 'POST',
        data: { logout: true },
        success: function (response) {
            if (response == "200") {
                window.location.href = "./login.html";
            }
        }
    });
}

function subirArchivo() {
    var archivo = document.getElementById('file').files[0];
    var nombreArchivo = document.getElementById('nombreArchivo').value;

    // Si no se ha seleccionado un archivo
    if (!archivo) {
        alert('Selecciona un archivo');
        return;
    }

    // Verificar si el nombre del archivo está vacío
    if (!nombreArchivo.trim()) {
        nombreArchivo = archivo.name;
    }

    var formData = new FormData();
    formData.append('nombreArchivo', nombreArchivo);
    formData.append('archivo', archivo);

    $.ajax({
        url: './php/index.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#mensaje').text(response);
            actualizarTabla();
        },
        error: function (xhr, status, error) {
            $('#mensaje').text('Error al subir el archivo: ' + error);
        }
    });
}

function isAdmin() {
    var subirArchivos = document.querySelector('.subirArchivos');
    var botonesBorrarArchivo = document.querySelectorAll('.borrar-archivo');

    // Iterar sobre todos los elementos y cambiar el estilo a "display: flex"
    botonesBorrarArchivo.forEach(function (boton) {
        boton.style.display = 'flex';
    });

    // Cambiar el estilo a "display: flex"
    subirArchivos.style.display = 'flex';
}