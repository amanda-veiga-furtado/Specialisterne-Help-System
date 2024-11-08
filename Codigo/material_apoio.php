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
    <title>Material de Apoio
    </title>
</head>
<body>
    <div class="container">
        <!-- <h2>Material de Apoio</h2> -->
        <div class="subtitle">Material de Apoio</div>
        
        <div class="faq-box">
            <p>No Help System você encontra a resposta para suas duvidas de trabalho, em local aonde todos podem colaborar com sua duvida!<br>Como funciona:<br>Clicando no botão de “Solicitar Ajuda” você é direcionado para uma pagina aonde voce pode escrever sua duvida. E assim que voce publicar seu texto com sua duvida, todos os colaboradores vão conseguir visualizar e poderam contribuir para lhe ajudar da melhor forma!<br>Você tambem pode colaborar respondendo e ajudando seus colegas com as perguntas e duvidas deles!</p>
        </div>
        
        <!-- <button onclick="history.back()" class="button">Voltar</button> -->
        <a href="dashboard.php" class="button">Voltar</a>

    </div>
</body>
</html>
