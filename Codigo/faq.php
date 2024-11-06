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
        .a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>FAQ</h2>
        <div class="subtitle">Perguntas frequentes:</div>
        
        <div class="faq-box">
            <p>"Aqui contem as perguntas e respostas mais frequentes"</p>
        </div>
        
        <!-- <button onclick="history.back()" class="button">Voltar</button> -->
        <a href="dashboard.php" class="button">Voltar</a>

    </div>
</body>
</html>
