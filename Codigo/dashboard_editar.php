<?php 
session_start(); 
ob_start();

include_once 'conexao.php'; 
include 'css/css.php';
include_once 'menu.php'; 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
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
        .bubble {
            background: #ff007f;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            font-size: 14px;
        }
        .question {
            background: rgba(255, 0, 127, 0.2);
            border-radius: 15px;
            padding: 20px;
            width: 70%;
            margin: 10px auto;
        }
        .button {
            background-color: #ff007f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        .button:hover {
            background-color: #e6006b;
        }
        .input-field {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff007f;
            border-radius: 10px;
            background-color: #2a2a3e;
            color: #fff;
            font-size: 16px;
        }
        select {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ff007f;
            background-color: #2a2a3e;
            color: #fff;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container_background_image_grow">
    <div class="container_whitecard_grow">
        <div class="container_form">
            <div class="form_switch">
                <h1>Bem-vindo(a) <?php echo htmlspecialchars($nome_usuario); ?>!</h1><br> 
            </div>
            <div style="display: flex; align-items: center;">
                <div style="margin-right: 10px;">
                    <img src="<?php echo !empty($imagem_usuario) ? htmlspecialchars($imagem_usuario) : 'css/img/usuario/no_image.png'; ?>" alt="Foto de perfil" style="width:150px;height:150px;border-radius: 50%">
                </div>
                
                <div style="margin-top:5px;">
                    <?php if (!empty($mensagem)): ?>
                        <p class="error-message"><?php echo htmlspecialchars($mensagem); ?></p>
                    <?php endif; ?>
                    
                    <!-- Form for profile update -->
                    <form method="POST" enctype="multipart/form-data">
                        <input type="text" name="nome_usuario" value="<?php echo htmlspecialchars($nome_usuario); ?>" required>
                        <input type="file" name="imagem_usuario">
                </div>
            </div>
        </div>
            <!-- <input type="submit" name="update_profile" value="Atualizar Perfil" class="button-long" style="margin-top:25px;"> -->



            <!-- <div class="container-button-long"> -->
                <input type="submit" name="update_profile" value="Atualizar Perfil" class="button-long" style="margin-top:25px;">
                <a href="dashboard.php" class="button">Voltar</a>


            <!-- </div> -->

            
            </form>
        </div>
    </div>
</div>

<script>
    <?php if (!empty($mensagem)): ?>
        alert('<?php echo addslashes($mensagem); ?>');
    <?php endif; ?>

    // Recarrega a imagem do perfil automaticamente sem recarregar a página inteira
    document.addEventListener("DOMContentLoaded", function() {
        const imgElement = document.querySelector("img[alt='Foto de perfil']");
        if (imgElement) {
            const src = imgElement.src;
            imgElement.src = src + "?t=" + new Date().getTime(); // Cache busting
        }
    });
</script>


</body>
</html>
