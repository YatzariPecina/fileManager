const registroForm = document.getElementById('registroForm');
const password = document.getElementById('password');
const confirmPass = document.getElementById('confirmacionPass');
const estadoConfirm = document.getElementById('estadoConfirm');

confirmPass.addEventListener("input", function (e){
    if(password.value === confirmPass.value){
        estadoConfirm.innerHTML = "Si es igual";
    }else{
        estadoConfirm.innerHTML = "No es igual";
    }
});

registroForm.addEventListener("submit", function (e) { 
    e.preventDefault();

    console.log("Empieza proceso de registro");
    var formData = new FormData(this);
    console.log(formData);

    $.ajax({
        type: "POST",
        url: "./php/register.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
        }
    });

});