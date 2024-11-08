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

    if (!empty($id_pergunta) && !empty($resposta)) {
        $sql = "INSERT INTO forum_respostas (fk_id_usuario, fk_id_pergunta, resposta) VALUES (:id_usuario, :id_pergunta, :resposta)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_pergunta', $id_pergunta, PDO::PARAM_INT);
        $stmt->bindParam(':resposta', $resposta, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<p>Resposta salva com sucesso!</p>";
        } else {
            echo "<p>Erro ao salvar a resposta.</p>";
        }
    } else {
        echo "<p>Todos os campos devem ser preenchidos.</p>";
    }
}

// Consulta para obter apenas as perguntas feitas pelo usuário e que não possuem respostas
$sql = "SELECT * FROM forum_perguntas p
        WHERE p.fk_id_usuario = :id_usuario
        AND NOT EXISTS (
            SELECT 1 FROM forum_respostas r
            WHERE r.fk_id_pergunta = p.id_pergunta
        )";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
$stmt->execute();
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obter as respostas do usuário
$sql = "SELECT r.resposta, p.area, p.duvida_area, p.pergunta 
        FROM forum_respostas AS r
        INNER JOIN forum_perguntas AS p ON r.fk_id_pergunta = p.id_pergunta
        WHERE r.fk_id_usuario = :id_usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
$stmt->execute();
$respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            color: #000;
            padding: 20px;
            width: 300px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
            flex: 1;
            min-width: 280px;
            max-width: 300px;
        }
        .card-header {
            background-color: #ff007f;
            color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        .card-content {
            padding: 15px;
            font-size: 14px;
            line-height: 1.5;
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
        <h1>Aqui você pode acompanhar todas as suas perguntas e respostas</h1>
        
        <div class="card-container">
            <!-- Card de perguntas -->
            <div class="card">
                <div class="card-header">Suas perguntas (Solicitações de ajuda abertas)</div>
                <div class="card-content">
                    <?php if (!empty($perguntas)): ?>
                        <?php foreach ($perguntas as $pergunta): ?>
                            <h3>Pergunta:</h3>
                            <p><strong>Área:</strong> <?= htmlspecialchars($pergunta['area']) ?></p>
                            <p><strong>Dúvida Área:</strong> <?= htmlspecialchars($pergunta['duvida_area']) ?></p>
                            <p><strong>Conteúdo:</strong> <?= htmlspecialchars($pergunta['pergunta']) ?></p>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Não há perguntas sem resposta no momento.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card de respostas do usuário -->
            <div class="card">
                <div class="card-header">Solicitações de ajuda que você colaborou</div>
                <div class="card-content">
                    <?php if (!empty($respostas)): ?>
                        <?php foreach ($respostas as $resposta): ?>
                            <h3>Pergunta:</h3>
                            <p><strong>Área:</strong> <?= htmlspecialchars($resposta['area']) ?></p>
                            <p><strong>Dúvida Área:</strong> <?= htmlspecialchars($resposta['duvida_area']) ?></p>
                            <p><strong>Conteúdo:</strong> <?= htmlspecialchars($resposta['pergunta']) ?></p>
                            <p><strong>Sua Resposta:</strong> <?= htmlspecialchars($resposta['resposta']) ?></p>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Você ainda não colaborou com nenhuma resposta.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <button onclick="history.back()" class="button">Voltar</button>
    </div>
</body>
</html>
