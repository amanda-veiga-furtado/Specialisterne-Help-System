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
    // include_once 'menu_admin.php'; 
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
                $target_dir = "css/img/usuario/";
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
        .container_container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 77vh;
            margin: 0;
            background-color: #1a1a2e; /* Define um fundo para a página */
        }
        .container {
            background-color: #2B2B4E;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            min-height: 450px; /* Defina uma altura mínima adequada */

        }
        h2 {
            margin-top: 0;
            color: white;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover; /* Garante que a imagem se ajuste sem distorcer */
            border: 3px solid #ff007f;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ff007f;
            border-radius: 10px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
        }
        /* Estilizando o campo de input de arquivo */
        input[type="file"] {
            border: 1px solid #ff007f; /* Borda rosa */
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
            width: 100%;
        }
        .button:hover {
            background-color: #e6006b;
        }
        .error-message {
            color: #ff4d4d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container_container">

    <div class="container">
        <h2>Editar Perfil</h2>
        
        <!-- Foto de Perfil -->
        <img src="<?php echo htmlspecialchars($imagem_usuario); ?>" alt="Foto de perfil" class="profile-pic">
        
        <!-- Exibe mensagem de erro, se houver -->
        <?php if (!empty($mensagem)): ?>
            <p class="error-message"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>
        
        <!-- Formulário de Atualização de Perfil -->
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nome_usuario" class="input-field" value="<?php echo htmlspecialchars($nome_usuario); ?>" required>
            <input type="file" name="imagem_usuario" class="input-field" accept="image/jpeg">
            <input type="submit" name="update_profile" value="Atualizar Perfil" class="button">
        </form>

        <!-- Botão para Voltar ao Dashboard -->
        <a href="dashboard.php" class="button">Voltar</a>
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
