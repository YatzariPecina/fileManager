document.getElementById("loginForm").addEventListener("submit", autenticarUsuario);
const username = document.getElementById('username');
const password = document.getElementById('password');
const mensaje = document.getElementById('mensaje');

const urlParams = new URLSearchParams(window.location.search);

function autenticarUsuario(event) {
    event.preventDefault();
    console.log("Entro");

    $.ajax({
        url: './php/login.php',
        type: 'POST',
        data: {
            username: username.value,
            password: password.value,
        },
        success: function (response) {
            console.log(response);
            if (response == "200") {
                window.location.href = "index.html";
            } else {
                if (response == "401") {
                    mensaje.innerHTML = "Usuario no autorizado";
                }
            }
        }
    });
}

if (urlParams.has('change_password') && urlParams.get('change_password') === 'true') {
    document.getElementById("loginForm").removeEventListener("submit", autenticarUsuario);
    console.log("Se va a cambiar la contraseña");
    document.getElementById('titulo').innerHTML = "Cambiar contraseña";
    let btnSubmit = document.getElementById('btnSubmit');

    $.ajax({
        url: "./php/login.php",
        type: "GET",
        success: function (response) {
            if (response != "401") {
                $.ajax({
                    type: "GET",
                    url: "php/login.php",
                    success: function (response) {
                        username.value = response.username;
                        btnSubmit.innerHTML = "Cambiar";

                        console.log("Se va a cambiar la contraseña");
                        let passwordContainer = document.getElementById('passwordContainer');
                        let passwordNewContainer = document.getElementById('passwordNewContainer');

                        passwordContainer.style.display = "none";
                        passwordNewContainer.style.display = "block";

                        document.getElementById("loginForm").addEventListener("submit", function(event){
                            change_password(event, response.id);
                        });
                    }
                });
            } else {
                mensaje.innerHTML = "Hubo un error al traer los datos";
            }
        }
    });
}

function change_password(event, id) {
    event.preventDefault();

    let newPassword = document.getElementById("newPassword").value;
    console.log(newPassword);

    $.ajax({
        type: "POST",
        url: "./php/register.php",
        data: {
            newPassword: newPassword,
            id: id,
        },
        success: function (response) {
            setInterval(() => {
                mensaje.innerHTML = "Se cambio la contraseña";
            }, 1000);
            
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
    });
}