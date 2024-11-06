<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhar Perguntas e Respostas</title>
    <style>
        body {
            background-color: #1a1a2e;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            font-size: 30px;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px auto;
            max-width: 80%;
        }
        .card {
            background-color: #ffffff;
            color: #000;
            padding: 20px;
            width: 300px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
        }
        .card-header {
            background-color: #ff007f;
            color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
            font-size: 16px;
        }
        .card-content {
            padding: 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        .button {
            background-color: #ff007f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 30px;
        }
        .button:hover {
            background-color: #e6006b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aqui você pode acompanhar todas as suas perguntas e respostas</h1>

        <div class="card-container">
            <div class="card">
                <div class="card-header">Suas perguntas (Solicitações de ajuda abertas)</div>
                <div class="card-content">
                    <p>"Aqui aparecem as perguntas feitas por esse usuário"</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Solicitações de ajuda que você colaborou</div>
                <div class="card-content">
                    <p>"Aqui aparecem as respostas que esse usuário colaborou em solicitações de ajuda de outros colaboradores"</p>
                </div>
            </div>
        </div>

        <button onclick="history.back()" class="button">Voltar</button>
    </div>
</body>
</html>
