
const labelUsuario = document.getElementById('nombreUsuario');
const contenedorUsuario = document.getElementById('clickedSession');
const tabla = document.getElementById('tablaArchivos');

$(document).ready(function(){
    mostrarUsuario();
    actualizarTabla();
});

function actualizarTabla() {
    $.ajax({
        url: "./php/index.php",
        type: "GET",
        success: function (response) {
            console.log(response);
            var filaEncabezado = $('#encabezado');

            //Reiniciar toda lo que esta en la tabla despues del encabezado
            filaEncabezado.nextAll().remove;

            //Iterar en la respuesta json
            $.each(response, function (index, archivo) { 
                //Nueva fila
                var newRow = $("<tr>");

                newRow.append('<td><a href="./php/archivo.php?nombre=' + archivo.nombre + '" target="_blank">' + archivo.nombre + '</a></td>');
                newRow.append("<td>" + archivo.size + "Kb</td>");
                newRow.append("<td></td>")

                //Insertar fila despeus de fila encabezado
                filaEncabezado.after(newRow);
            });
        }
    });
}

function mostrarUsuario(){
    $.ajax({
        url: "./php/login.php",
        type: "GET",
        success: function (response){
            console.log(response);
            if(response == "401"){
                //Variable para regresar al login
                window.location.href = "login.html";
            }else{
                //Mandar el nombre a la ventana
                labelUsuario.innerHTML = "Cerrar sesion";
                contenedorUsuario.onclick = function(){
                    cerrarSesion();
                };
            }
        }
    });
}

function cerrarSesion(){
    $.ajax({
        url: './php/login.php',
        type: 'POST',
        data: { logout : true},
        success: function (response){
            if(response == "200"){
                window.location.href = "./login.html";
            }
        }
    });
}