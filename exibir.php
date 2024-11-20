<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Imagens</title>
    <style>
        /* Definições gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-top: 50px;
        }

        /* Container principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Estilo para as imagens */
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .image-container div {
            margin: 10px;
            text-align: center;
        }

        .image-container img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Imagens na Pasta Upload</h1>

    <!-- Listagem de imagens -->
    <div class="image-container">
        <?php
        // Caminho para a pasta de uploads
        $uploadDir = __DIR__ . '/uploads/';

        // Verifica se a pasta existe
        if (is_dir($uploadDir)) {
            // Escaneia a pasta para obter arquivos
            $files = scandir($uploadDir);

            // Filtra os arquivos para exibir apenas imagens
            foreach ($files as $file) {
                // Verifica se o arquivo é uma imagem (ajuste conforme necessário)
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                    echo "<div>";
                    echo "<img src='uploads/$file' alt='" . htmlspecialchars($file) . "' />";
                    echo "<p>" . htmlspecialchars($file) . "</p>";
                    echo "</div>";
                }
            }
        } else {
            echo "A pasta de uploads não existe.";
        }
        ?>
    </div>
</div>

<a href="front.php" class="back-btn">Voltar para a Página Inicial</a>
</body>
</html>
