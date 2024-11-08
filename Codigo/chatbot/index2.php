<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <style>
        body { font-family: Arial, sans-serif; }

        /* Animação de pulo */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Estilo para o botão de abrir o chat como imagem com animação */
        #chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            cursor: pointer;
            animation: bounce 0.6s infinite;
        }

        /* Estilo caixa de chat */
        #chat-container {
            display: none;
            position: fixed;
            bottom: 70px;
            right: 20px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        #chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        /* Estilo botão de minimizar */
        #minimize-btn {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        #chat-box {
            width: 100%;
            height: 200px;
            padding: 10px;
            overflow-y: auto;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        #message { 
            width: calc(100% - 80px); 
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
        }

        #send-btn { 
            padding: 10px 20px; 
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Substituindo o botão pelo ícone de imagem com animação de pulo -->
    <img id="chat-button" src="lacinho-icon.png" alt="Chat" width="75" height="75">

    <div id="chat-container">
        <div id="chat-header">
            Chatbot
            <button id="minimize-btn">-</button>
        </div>
        <div id="chat-box"></div>
        <div style="display: flex; align-items: center;">
            <input type="text" id="message" placeholder="Digite sua mensagem aqui...">
            <button id="send-btn">Enviar</button>
        </div>
    </div>

    <script>
        // Variavel de abertura do chat
    let mensagemInicialExibida = false;
        // Mensagens que são exibidas quando o chat é aberto
    function exibirMensagemInicial() {
        if (!mensagemInicialExibida) {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += "<div>Lacinho: Olá! Como posso ajudar?</div>";
            chatBox.innerHTML += "<div>Lacinho: Vou mostrar as Opções abaixo: </div>";
            chatBox.innerHTML += "<div>Lacinho: Forum 1 </div>";
            chatBox.innerHTML += "<div>Lacinho: Forum 2 </div>";
            chatBox.innerHTML += "<div>Lacinho: Forum 3 </div>";
            mensagemInicialExibida = true;
        }
    }
    document.getElementById('chat-button').addEventListener('click', function() {
        const chatContainer = document.getElementById('chat-container');
        const chatButton = document.getElementById('chat-button');
        // Para com a função pular quando o chat é aberto
        if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
            chatContainer.style.display = 'block';
            chatButton.style.animation = 'none';
            exibirMensagemInicial();
        } else {
            chatContainer.style.display = 'none';
            chatButton.style.animation = 'bounce 0.6s infinite';
        }
    });

    document.getElementById('minimize-btn').addEventListener('click', function() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.style.display = 'none';

        const chatButton = document.getElementById('chat-button');
        chatButton.style.animation = 'bounce 0.6s infinite';
    });

    // Coloca o pronome "Voce" antes da sua mensagem digitada
    document.getElementById('send-btn').addEventListener('click', function() {
        let message = document.getElementById('message').value;
        if (message.trim() !== "") {
            document.getElementById('chat-box').innerHTML += "<div>Você: " + message + "</div>";
            document.getElementById('message').value = "";

            // envia a mensagem digitada para o script php para ser enviado ao python
            fetch('chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'message=' + encodeURIComponent(message)
            })
            // Coloca o "Lacinho" antes da mensagem do chat para sinalizar que foi ele
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat-box').innerHTML += "<div>Lacinho: " + data + "</div>";
                document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
            });
        }
    });

    // Função para enviar a mensagem ao pressionar "Enter"
    document.getElementById('message').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Previne a quebra de linha no campo de entrada
            document.getElementById('send-btn').click(); // Simula o clique no botão de enviar
        }
    });
</script>

</body>
</html>