<?php 
session_start(); 
ob_start();

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login_cadastro.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if (isset($_SESSION['statusAdministrador_usuario']) && $_SESSION['statusAdministrador_usuario'] === 'a') {
    include_once 'menu_admin.php'; 
}

$nome_usuario = $_SESSION['nome_usuario'];
$email_usuario = $_SESSION['email_usuario'];

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $novo_nome_usuario = trim($_POST['nome_usuario']);
    $imagem_usuario = $_FILES['imagem_usuario']['name'];
    $imagem_tamanho = $_FILES['imagem_usuario']['size']; 

    $limite_tamanho = 2 * 1024 * 1024; // 2MB
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE nome_usuario = :nome_usuario AND id_usuario != :id_usuario");
    $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        $mensagem = "Erro: Nome de usuário já está em uso!";
    } else {
        if ($imagem_usuario) {
            $file_extension = strtolower(pathinfo($imagem_usuario, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $extensoes_permitidas)) {
                $mensagem = "Erro: Apenas arquivos JPG, PNG e GIF são permitidos.";
            } elseif ($imagem_tamanho > $limite_tamanho) {
                $mensagem = "Erro: O arquivo é muito grande. O tamanho máximo permitido é de 2MB.";
            } else {
                $target_dir = "../css/img/usuario/";
                $target_file = $target_dir . uniqid() . "_" . basename($imagem_usuario);

                if (move_uploaded_file($_FILES['imagem_usuario']['tmp_name'], $target_file)) {
                    $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario, imagem_usuario = :imagem_usuario WHERE id_usuario = :id_usuario");
                    $stmt->bindParam(':imagem_usuario', $target_file);
                } else {
                    $mensagem = "Erro ao fazer o upload da imagem. Tente novamente.";
                }
            }
        } else {
            $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = :nome_usuario WHERE id_usuario = :id_usuario");
        }

        $stmt->bindParam(':nome_usuario', $novo_nome_usuario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        if ($stmt->execute()) {
            $mensagem = "Perfil atualizado com sucesso!";
            $_SESSION['nome_usuario'] = $novo_nome_usuario;
        }
    }
}

// Recupera a imagem do usuário
$stmt = $conn->prepare("SELECT imagem_usuario FROM usuario WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$imagem_usuario = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
</head>
<body>
    <div style="background-color: rgb(16, 23, 40);  min-height: 85.3vh;">
        <div style="height: 60px; display: flex; align-items: center; gap: 20px; padding-right: 20px; justify-content: flex-end;">
        <a href="notificacoes.php">
            <i class="fa-solid fa-bell fa-shake fa-2xl" style="color: #FFD43B;"></i>
        </a>
            <!-- <i class="fa-solid fa-message fa-2xl" style="color: #FFD43B;"></i> -->
        </div>
        <div style="width: 100%; display: flex; height: 80.3vh;">
            <div style=" background-color: blue; flex: 1; align-items: center;">
                <button class="button-long" style="margin-top: 10%; align-items: center;">Solicitar Ajuda</button><br>
                <button class="button-long" style="margin-top: 10%;" title="Esse botão direciona o usuário para uma tela onde ele pode ver perguntas de outros usuários e respondê-las.">
                    Ajude seus colegas!
                </button>

                <button class="button-long" style="margin-top: 10%; align-items: center;">Respostas das duvidas que você publicou</button><br>
                <button class="button-long" style="margin-top: 10%; align-items: center;">Acompanhar suas
                perguntas e respostas</button><br>

            </div>
                <div style=" background-color: red; flex: 1;">
                    <img src="<?php echo !empty($imagem_usuario) ? htmlspecialchars($imagem_usuario) : 'css/img/usuario/no_image.png'; ?>" style="margin: 10% auto 0; display: block; height: 150px; width:150px; border-radius: 50%;">
                    <!-- <h1>Bem-vindo(a) <?php echo htmlspecialchars($nome_usuario); ?>!</h1><br>  -->
                    <a href="dashboard_editar.php">
                    
                    <button class="button-long" style="margin-top: 10%;"title="Seja direcionado para uma nova pagina para personalizar seu perfil"> <?php echo htmlspecialchars($nome_usuario); ?></button>

                    </a>

                </div>
                <div style=" background-color: blue; flex: 1;">

                <button class="button-long" style="margin-top: 10%; align-items: center;">Configurações</button><br>
                <button class="button-long" style="margin-top: 10%;">Material de Apoio</button>

                <button class="button-long" style="margin-top: 10%; align-items: center;">FAQ</button><br>
                <button class="button-long" style="margin-top: 10%; align-items: center;" href="sair.php;">Sair</button><br>

                </div>
        </div>
