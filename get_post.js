document.addEventListener('DOMContentLoaded', function () {
    // Enviar dados via POST
    document.getElementById('myForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        const name = document.getElementById('name').value;

        fetch('Main.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ name })
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('response').innerText = 'Resposta do POST: ' + data;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });

    // Obter dados via GET
    document.getElementById('getData').addEventListener('click', function () {
        fetch('Main.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('response').innerText = 'Resposta do GET: ' + data;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });
});
