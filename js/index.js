
const labelUsuario = document.getElementById('nombreUsuario');
const contenedorUsuario = document.getElementById('clickedSession');
const tabla = document.getElementById('tablaArchivos');

$(document).ready(function(){
    mostrarUsuario();
});

function actualizarTabla() {
    $.ajax({
        url: "./php/index.php",
        type: "GET",
        success: function (response) {
            var filaEncabezado = $('#encabezado');

            //Reiniciar toda lo que esta en la tabla despues del encabezado
            filaEncabezado.nextAll().remove;

            //Iterar en la respuesta json
            $.each(response, function (index, archivo) { 
                 
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