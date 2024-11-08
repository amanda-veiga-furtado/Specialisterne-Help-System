<?php
session_start();
ob_start();

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 

// Verificar se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    echo "Você precisa estar logado para visualizar suas notificações.";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// // Consulta para obter as 4 perguntas respondidas pelo usuário logado (usuário atual)
// $sql = "SELECT p.id_pergunta, p.area, p.duvida_area, p.pergunta, r.resposta 
//         FROM forum_perguntas AS p
//         INNER JOIN forum_respostas AS r ON p.id_pergunta = r.fk_id_pergunta
//         WHERE r.fk_id_usuario = :id_usuario
//         ORDER BY r.id_resposta DESC
//         LIMIT 4";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
// $stmt->execute();
// $notificacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Consulta para obter as 4 perguntas mais recentes feitas pelo usuário logado e que têm respostas
$sql = "SELECT p.id_pergunta, p.area, p.duvida_area, p.pergunta, r.resposta
        FROM forum_perguntas AS p
        INNER JOIN forum_respostas AS r ON p.id_pergunta = r.fk_id_pergunta
        WHERE p.fk_id_usuario = :id_usuario
        ORDER BY r.id_resposta DESC
        LIMIT 4";
        
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$notificacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
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
        h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .subtitle {
            background-color: #2a2a3e;
            color: #fff;
            padding: 10px 20px;
            border-radius: 15px;
            font-size: 18px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .faq-box {
            background-color: #2b2b4e;
            padding: 40px;
            margin: 0 auto;
            width: 70%;
            border-radius: 20px;
            font-size: 16px;
            line-height: 1.5;
            color: #fff;
        }
        .notificacao {
            border-bottom: 1px solid #444;
            padding: 15px 0;
            text-align: left;
        }
        .notificacao:last-child {
            border-bottom: none;
        }
        .button {
            background-color: #ff007f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #e6006b;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="subtitle">Notificações</div>
        
        <div class="faq-box">
            <?php if (!empty($notificacoes)): ?>
                <?php foreach ($notificacoes as $notificacao): ?>
                    <div class="notificacao">
                        <p><strong>Área:</strong> <?= htmlspecialchars($notificacao['area']) ?></p>
                        <p><strong>Dúvida Área:</strong> <?= htmlspecialchars($notificacao['duvida_area']) ?></p>
                        <p><strong>Pergunta:</strong> <?= htmlspecialchars($notificacao['pergunta']) ?></p>
                        <p><strong>Resposta:</strong> <?= htmlspecialchars($notificacao['resposta']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há notificações no momento.</p>
            <?php endif; ?>
        </div>

        <a href="dashboard.php" class="button">Voltar</a>
    </div>
</body>
</html>
