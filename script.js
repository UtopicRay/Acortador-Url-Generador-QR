const ContentQR = document.getElementById('qr');
const form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
    ajax_post()
})

function ajax_post() {
    var url = document.getElementById('short_url').value;
    var xhr = new XMLHttpRequest();
    // Configurar la solicitud
    xhr.open("POST", "./generate.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var info = "short_url=" + url;
    // Enviar la solicitud
    xhr.send(info);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // La solicitud se completó con éxito
            var respuesta = xhr.responseText;
            // Procesar la respuesta
            console.log(url);
            ContentQR.innerHTML = respuesta;
        } else {
            // La solicitud falló
            console.log("Error al enviar la solicitud");
        }
    };
}
