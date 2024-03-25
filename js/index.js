document.getElementById("loginForm").addEventListener("submit", autenticarUsuario);
const username = document.getElementById('username');
const password = document.getElementById('password');
const mensaje = document.getElementById('mensaje');

function autenticarUsuario(event) {
    event.preventDefault();

    $.ajax({
        url: 'login.php',
        type: 'POST',
        data: {
            username: username.value,
            password: password.value,
        },
        success: function(response){
            if (response == "200") {
                window.location.href = "index.html";
            }else{
                if (response == "401"){
                    mensaje.innerHTML = "Usuario no autorizado";
                }
            }
        }
    });
    
}