
const labelUsuario = document.getElementById('nombreUsuario');
const tabla = document.getElementById('tablaArchivos');

$(document).ready(function(){
    mostrarUsuario();
});

function actualizarTabla() {
    $.ajax({
        url: "./php/index.php",
        type: "GET",
        success: function (response) {
            console.log(response);
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
                window.location.href = "login.html";
            }else{
                labelUsuario.innerHTML = response.username;
                
            }
        }
    });
}