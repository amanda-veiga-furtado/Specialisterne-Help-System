<?php
session_start();
ob_start();

// Verifica se existe uma mensagem no parâmetro da URL
if (isset($_GET['mensagem'])) {
    $mensagem = htmlspecialchars($_GET['mensagem']);
    echo "<script>alert('$mensagem');</script>";
}

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login | Cadastro</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container_1" style="background-color: rgb(16, 23, 40);  min-height: 85.3vh;">
            <div class="container_1_1" style="width: 100%; display: flex; height: 85.3vh;">
                <div id="div2" style="  flex: 1;">

                    <img src="css/img/imagem_1" style="margin-left: 20%; margin-top: 10%; margin-right: 20%;" height="10%">
                    <h1 style="font-size: 65px; 
                               font-family: 'Codec Pro ExtraBold, Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                               color: white;
                                text-align: center;
                    ">Help System</h1>
                    <button class="button-short" style="margin-left: 20%; margin-top: 10%; ">Login</button>
                </div>
                <div id="div2" style=" flex: 1;">

                <img src="css/img/imagem_2.png" style="margin: 10% auto 0; display: block; height: 70%; border-radius: 100px; box-shadow: -10px 15px 20px 5px #1f41bb;"">


                </div>
            </div>


            <div class="container_1_1" style="width: 100%; display: flex; height: 80.3vh;">
                <div id="div2" style=" background-color: blue; flex: 1;">

                    <img src="css/img/imagem_1" style="margin-left: 20%; margin-top: 10%; margin-right: 20%;" height="10%">
                    <h1 style="font-size: 65px; 
                               font-family: 'Codec Pro ExtraBold, Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                               color: white;
                                text-align: center;
                    ">Help System</h1>
                    <button class="button-short" style="margin-left: 20%; margin-top: 10%; ">Login</button>
                </div>
                <div id="div2" style=" background-color: red; flex: 1;">

                <img src="css/img/imagem_2.png" style="margin: 10% auto 0; display: block; height: 70%; border-radius: 100px;">


                </div>
            </div>
        </div>
                    
                    
    </body>
</html>
<!-- width: 100%;
            min-height: 100%;
            /* height: 85.3vh; */
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed; -->