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

// Verificar se o formulário de resposta foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resposta'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_pergunta = $_POST['id_pergunta'];
    $resposta = htmlspecialchars($_POST['resposta']); // Prevenção contra XSS

    // Verificar se os campos estão preenchidos
    if (!empty($id_pergunta) && !empty($resposta)) {
        // Preparar a consulta SQL para inserir a resposta
        $sql = "INSERT INTO forum_respostas (fk_id_usuario, fk_id_pergunta, resposta) VALUES (:id_usuario, :id_pergunta, :resposta)";
        // $sql = "INSERT INTO forum_respostas (fk_id_pergunta, resposta) VALUES (:id_pergunta, :resposta)";

        $stmt = $conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_pergunta', $id_pergunta, PDO::PARAM_INT);
        $stmt->bindParam(':resposta', $resposta, PDO::PARAM_STR);

        // Executar a consulta e verificar se foi bem-sucedida
        if ($stmt->execute()) {
            echo "<p>Resposta salva com sucesso!</p>";
        } else {
            echo "<p>Erro ao salvar a resposta.</p>";
        }
    } else {
        echo "<p>Todos os campos devem ser preenchidos.</p>";
    }
}

// Consulta para obter todas as perguntas
$sql = "SELECT * FROM forum_perguntas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Perguntas</title>
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
            margin-top: 20px;
            padding: 20px;
        }
        .pergunta {
            background-color: #2a2a3e;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
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
        .button {
            background-color: #ff007f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #e6006b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Perguntas no Fórum</h2>
        
        <?php foreach ($perguntas as $pergunta): ?>
            <div class="pergunta">
                <h3>Pergunta:</h3>
                <p><strong>Área:</strong> <?= htmlspecialchars($pergunta['area']) ?></p>
                <p><strong>Dúvida Área:</strong> <?= htmlspecialchars($pergunta['duvida_area']) ?></p>
                <p><strong>Conteúdo:</strong> <?= htmlspecialchars($pergunta['pergunta']) ?></p>

                <!-- Formulário para responder a pergunta -->
                <form action="" method="POST">
                    <input type="hidden" name="id_pergunta" value="<?= $pergunta['id_pergunta'] ?>">
                    <textarea name="resposta" class="input-field" rows="3" placeholder="Escreva sua resposta..." required></textarea>
                    <button type="submit" class="button">Enviar Resposta</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
