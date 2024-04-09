const registroForm = document.getElementById('registroForm');
const password = document.getElementById('password');
const confirmPass = document.getElementById('confirmacionPass');
const estadoConfirm = document.getElementById('estadoConfirm');
const mensaje = document.getElementById('mensaje');

const urlParams = new URLSearchParams(window.location.search);

confirmPass.addEventListener("input", function (e) {
    if (password.value === confirmPass.value) {
        estadoConfirm.innerHTML = "Si es igual";
    } else {
        estadoConfirm.innerHTML = "No es igual";
    }
});

registroForm.addEventListener("submit", registrarUsuario);

if (urlParams.has('change_info') && urlParams.get('change_info') === 'true') {
    console.log("hay que cambiar la info");

    $.ajax({
        url: "./php/login.php",
        type: "GET",
        success: function (response) {
            if (response != "401") {
                $.ajax({
                    type: "GET",
                    url: "php/login.php",
                    success: function (response) {

                        fetch(`./php/register.php?id=${response.id}`)
                            .then(value => {
                                if (!value.ok) {
                                    throw new Error('La solicitud no fue exitosa');
                                }
                                return value.json();
                            })
                            .then(data => {
                                // Manejar la respuesta JSON
                                let userData = data[0];
                                document.getElementById('username').value = userData.username;
                                
                                document.getElementById('cardPassword').style.display = "none";
                                document.getElementById('cardConfirmPass').style.display = "none";
                                document.getElementById('password').type = "hidden";
                                document.getElementById('confirmacionPass').type = "hidden";

                                document.getElementById('nombre').value = userData.nombre;
                                document.getElementById('apellidos').value = userData.apellidos;

                                //Genero
                                let radioMasculino = document.getElementById('masculino');
                                let radioFemenino = document.getElementById('femenino');
                                let radioNoEspecificar = document.getElementById('no_especificar');

                                if (userData.genero === 'M') {
                                    radioMasculino.checked = true;
                                } else if (userData.genero === 'F') {
                                    radioFemenino.checked = true;
                                } else {
                                    radioNoEspecificar.checked = true;
                                }

                                document.getElementById('fechaNac').value = userData.fecha_nacimiento;
                                document.getElementById('grado').value = userData.es_admin;

                                document.getElementById('btnSubmit').innerHTML = "Modificar";

                                registroForm.removeEventListener("submit", registrarUsuario);
                                registroForm.addEventListener("submit", function(e){
                                    modificarInfo(e, userData.id);
                                });
                            })
                            .catch(error => {
                                // Manejar errores
                                console.error('Error:', error);
                            });
                    }
                });
            } else {
                mensaje.innerHTML = "Hubo un error al traer los datos";
            }
        }
    });
}

function registrarUsuario(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.delete('confirmacionPass');

    $.ajax({
        type: "POST",
        url: "./php/register.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (xhr, response) {
            window.location.href = "login.html";
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud
            mensaje.innerHTML = "Error " + error + ": " + xhr.responseText;
        }
    });
}

function modificarInfo(e, id) {
    e.preventDefault();
    let formData = new FormData(registroForm);
    formData.append("modificar", true);
    formData.append("id", id);

    console.log(formData);
    console.log("Entro al metodo para modificar la info");

    $.ajax({
        type: "POST",
        url: "./php/register.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud
            mensaje.innerHTML = "Error " + error + ": " + xhr.responseText;
        }
    });
}