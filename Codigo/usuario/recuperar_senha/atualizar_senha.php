<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Incluir o arquivo config
include_once "./config.php";

// Incluir o arquivo com a conexão com banco de dados
include_once "./conexao.php";

// Receber a chave
$chave_recuperar_senha = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
//var_dump($chave_recuperar_senha);

if (empty($chave_recuperar_senha)) {
    // Criar a variável global com a mensagem de erro
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido!</p>";

    // Redirecionar o usuário
    header('Location: index.php');

    // Pausar o processamento
    exit();
} else {
    // QUERY para recuperar os dados do usuário no banco de dados
    $query_usuario = "SELECT id 
            FROM usuarios
            WHERE chave_recuperar_senha =:chave_recuperar_senha
            LIMIT 1";

    // Preparar a QUERY
    $result_usuario = $conn->prepare($query_usuario);

    // Substituir o link da query pelo valor que vem do formulário
    $result_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);

    // Executar a QUERY
    $result_usuario->execute();

    if ($result_usuario->rowCount() === 0) {
        // Criar a variável global com a mensagem de erro
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido!</p>";

        // Redirecionar o usuário
        header('Location: index.php');

        // Pausar o processamento
        exit();
    } else {
        // Ler os registros retorando do banco de dados
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celke - Atualizar Senha</title>
</head>

<body>

</body>

    <h1>Atualizar Senha</h1>

    <?php
    // Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessar o IF quando o usuário clicar no botão do formulário
    if (!empty($dados['SendNovaSenha'])) {
        var_dump($dados);

        // Criptografar a senha
        $senha_usuario = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
        $chave_recuperar_senha = 'NULL';

        // Editar o usuário e salvar a nova senha
        $query_up_usuario = "UPDATE usuarios
                    SET senha_usuario =:senha_usuario,
                    chave_recuperar_senha =:chave_recuperar_senha
                    WHERE id =:id
                    LIMIT 1";

        // Preparar a QUERY
        $editar_usuario = $conn->prepare($query_up_usuario);

        // Substituir o link da query pelo valor que vem do formulário
        $editar_usuario->bindParam(':senha_usuario', $senha_usuario);
        $editar_usuario->bindParam(':chave_recuperar_senha', $chave_recuperar_senha);
        $editar_usuario->bindParam(':id', $row_usuario['id']);

        // Executar a QUERY
        if ($editar_usuario->execute()) {

            // Criar a variável global com a mensagem de sucesso
            $_SESSION['msg'] = "<p style='color: green;'>Senha atualizada com sucesso!</p>";

            // Redirecionar o usuário
            header('Location: index.php');

            // Pausar o processamento
            exit();

        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tente novamente!</p>";
        }
    }

    // Imprimir a mensagem da sessão
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">

        <label>Senha</label>
        <input type="password" name="senha_usuario" placeholder="Digite a nova senha"><br><br>

        <input type="submit" name="SendNovaSenha" value="Atualizar"><br><br>
    </form>

    Lembrou a senha? <a href="index.php">clique aqui</a> para logar

</html>