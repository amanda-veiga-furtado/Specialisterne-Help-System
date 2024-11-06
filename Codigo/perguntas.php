<?php
session_start();
ob_start();

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 

// Verificar se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    echo "Você precisa estar logado para visualizar e responder perguntas.";
    exit;
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores do formulário
    $id_usuario = $_SESSION['id_usuario']; // Pegar o ID do usuário logado
    $area = $_POST['area'];
    $duvida_area = $_POST['duvida_area'];
    $pergunta = htmlspecialchars($_POST['question']); // Prevenir XSS

    // Verificar se os campos não estão vazios
    if (empty($area) || empty($duvida_area) || empty($pergunta)) {
        echo "Todos os campos devem ser preenchidos.";
    } else {
        // Preparar a consulta SQL para inserir os dados na tabela
        $sql = "INSERT INTO forum_perguntas (fk_id_usuario, area, duvida_area, pergunta) VALUES (:id_usuario, :area, :duvida_area, :pergunta)";
        $stmt = $conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':area', $area, PDO::PARAM_INT);
        $stmt->bindParam(':duvida_area', $duvida_area, PDO::PARAM_INT);
        $stmt->bindParam(':pergunta', $pergunta, PDO::PARAM_STR);

        // Executar a consulta e verificar se foi bem-sucedida
        if ($stmt->execute()) {
            echo "Pergunta salva com sucesso!";
        } else {
            echo "Erro ao salvar a pergunta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Help System</title>
    <style>
        body {
            background-color: #1a1a2e;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        .bubble {
            background: #ff007f;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            font-size: 14px;
        }
        .question {
            background: rgba(255, 0, 127, 0.2);
            border-radius: 15px;
            padding: 20px;
            width: 70%;
            margin: 10px auto;
        }
        .button {
            background-color: #ff007f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        .button:hover {
            background-color: #e6006b;
        }
        .input-field {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff007f;
            border-radius: 10px;
            background-color: #2a2a3e;
            color: #fff;
            font-size: 16px;
        }
        select {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ff007f;
            background-color: #2a2a3e;
            color: #fff;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Escreva sua dúvida no campo abaixo:</h2>
        
        <form action="" method="POST">
            <div class="question">
                <label for="area">Eu atuo na área:</label><br>
                <select name="area" id="area" required>
                    <option value="1">Área 1</option>
                    <option value="2">Área 2</option>
                    <!-- Adicione mais opções conforme necessário -->
                </select>
            </div>

            <div class="question">
                <label for="duvida_area">Minha dúvida é em relação à área:</label><br>
                <select name="duvida_area" id="duvida_area" required>
                    <option value="1">Área 1</option>
                    <option value="2">Área 2</option>
                    <!-- Adicione mais opções conforme necessário -->
                </select>
            </div>

            <div class="question">
                <label for="question">Mensagem:</label><br>
                <textarea name="question" id="question" class="input-field" rows="4" placeholder="Digite sua mensagem aqui..." required></textarea>
            </div>
            
            <button type="submit" class="button">Publicar minha dúvida</button>
        </form>
        
        <button onclick="history.back()" class="button">Voltar</button>
    </div>
</body>
</html>
