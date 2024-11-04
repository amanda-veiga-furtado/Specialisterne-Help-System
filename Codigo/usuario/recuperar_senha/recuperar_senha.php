<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Importar as classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir o arquivo config
include_once "./config.php";

// Incluir o arquivo com a conexão com banco de dados
include_once "./conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celke - Recuperar Senha</title>
</head>

<body>

</body>

    <h1>Recuperar Senha</h1>

    <?php
    // Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Acessar o IF quando o usuário clicar no botão do formulário
if (!empty($dados['SendRecupSenha'])) {
    //var_dump($dados);

    // QUERY para recuperar os dados do usuário no banco de dados
    $query_usuario = "SELECT id, nome, usuario 
                    FROM usuarios
                    WHERE usuario =:usuario
                    LIMIT 1";

    // Preparar a QUERY
    $result_usuario = $conn->prepare($query_usuario);

    // Substituir o link da query pelo valor que vem do formulário
    $result_usuario->bindParam(':usuario', $dados['usuario']);

    // Executar a QUERY
    $result_usuario->execute();

    // Acessar o IF quando encontrar usuário no banco de dados
    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        // Ler os registros retorando do banco de dados
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_usuario);

        // Gerar a chave para recuperar senha
        $chave_recuperar_senha = password_hash($row_usuario['id'] . $row_usuario['usuario'], PASSWORD_DEFAULT);
        //var_dump($chave_recuperar_senha);

        // Editar o usuário e salvar a chave recuperar senha
        $query_up_usuario = "UPDATE usuarios 
                    SET chave_recuperar_senha =:chave_recuperar_senha
                    WHERE id =:id
                    LIMIT 1";

        // Preparar a QUERY
        $editar_usuario = $conn->prepare($query_up_usuario);

        // Substituir o link da query pelo valor que vem do formulário
        $editar_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
        $editar_usuario->bindParam(':id', $row_usuario['id']);

        // Executar a QUERY
        if ($editar_usuario->execute()) {
            // Gerar o link recuperar senha
            $link = "http://localhost/celke/atualizar_senha.php?chave=$chave_recuperar_senha";
            //var_dump($link);

            // Incluir o Composer
            require './lib/vendor/autoload.php';

            // Criar o objeto e instanciar a classe do PHPMailer
            $mail = new PHPMailer(true);

            // Verificar se envia o e-mail corretamente com try catch
            try {
                // Imprimir os erro com debug
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

                // Permitir o envio do e-mail com caracteres especiais
                $mail->CharSet = 'UTF-8';

                // Definir para usar SMTP
                $mail->isSMTP();

                // Servidor de envio de e-mail
                $mail->Host       = HOSTEMAIL; 

                // Indicar que é necessário autenticar
                $mail->SMTPAuth   = true;     

                // Usuário/e-mail para enviar o e-mail                              
                $mail->Username   = USEREMAIL; 

                // Senha do e-mail utilizado para enviar e-mail                  
                $mail->Password   = PASSEMAIL;      

                // Ativar criptografia                         
                $mail->SMTPSecure = SMTPSECURE;  

                // Porta para enviar e-mail          
                $mail->Port       = PORTEMAIL;

                // E-mail do rementente
                $mail->setFrom(REMETENTE, NOMEREMETENTE);
                
                // E-mail de destino
                $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);

                // Definir formato de e-mail para HTML
                $mail->isHTML(true);

                // Título do e-mail
                $mail->Subject = 'Recuperar senha';

                // Conteúdo do e-mail em formato HTML
                $mail->Body    = "Olá " . $row_usuario['nome'] . ".<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";

                // Conteúdo do e-mail em formato texto
                $mail->AltBody = "Olá " . $row_usuario['nome'] . "\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

                // Enviar e-mail
                $mail->send();

                // Criar a variável global com a mensagem de sucesso
                $_SESSION['msg'] = "<p style='color: green;'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";

                // Redirecionar o usuário
                header('Location: index.php');

                // Pausar o processamento
                exit();
            } catch (Exception $e) { // Acessa o catch quando não é enviado e-mail corretamente
                echo "E-mail não enviado com sucesso. Erro: {$mail->ErrorInfo}";
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não enviado com sucesso!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    }
}

// Imprimir a mensagem da sessão
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

    <form method="POST" action="">
        <label>E-mail</label>
        <input type="text" name="usuario" placeholder="Digite o usuário"><br><br>

        <input type="submit" name="SendRecupSenha" value="Recuperar"><br><br>
    </form>

    Lembrou a senha? <a href="index.php">clique aqui</a> para logar

</html>