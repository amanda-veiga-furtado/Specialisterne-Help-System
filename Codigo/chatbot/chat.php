<?php

ini_set('default_charset', 'UTF-8'); // Configura UTF-8 para PHP
header('Content-Type: text/html; charset=UTF-8'); // Define o cabeçalho de resposta em UTF-8 para o navegador entender

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    // Comando para chamar o script Python
    $command = escapeshellcmd("python3 chatbot.py '$message'");
    $output = shell_exec($command);

    echo $output;
}
?>