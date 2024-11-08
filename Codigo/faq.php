<?php
session_start();
ob_start();

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Perguntas Frequentes</title>
</head>
<body>
    <div class="container">
        <h2>FAQ</h2>
        <div class="subtitle">Perguntas frequentes:</div>
        
        <div class="faq-box"><p>"Aqui contem as perguntas e respostas mais frequentes"</p></div>
        
        <a href="dashboard.php" class="button">Voltar</a>
    </div>
</body>
</html>
