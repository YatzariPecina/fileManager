const registroForm = document.getElementById('registroForm');
const password = document.getElementById('password');
const confirmPass = document.getElementById('confirmacionPass');
const estadoConfirm = document.getElementById('estadoConfirm');
const mensaje = document.getElementById('mensaje');

confirmPass.addEventListener("input", function (e){
    if(password.value === confirmPass.value){
        estadoConfirm.innerHTML = "Si es igual";
    }else{
        estadoConfirm.innerHTML = "No es igual";
    }
});

registroForm.addEventListener("submit", function (e) { 
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
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud
            mensaje.innerHTML = "Error " + error + ": " + xhr.responseText;
        }
    });
});