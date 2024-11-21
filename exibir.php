<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Imagens</title>
    <style>
        /* Definições gerais */
        body {
            font-family: Arial, sans-serif;
            --s: 200px;
            /* control the size */
            --c1: #30A9E8;
            --c2: #3CCBF4;
            --c3: #0078D4;

            background: repeating-conic-gradient(from 30deg,
                    #0000 0 120deg,
                    var(--c3) 0 180deg) calc(0.5 * var(--s)) calc(0.5 * var(--s) * 0.577),
                repeating-conic-gradient(from 30deg,
                    var(--c1) 0 60deg,
                    var(--c2) 0 120deg,
                    var(--c3) 0 180deg);
            background-size: var(--s) calc(var(--s) * 0.577);
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #37BBEE;
            margin: 50px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Estilo da grade de imagens */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .image-item {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .image-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .delete-btn {
            margin-top: 10px;
            padding: 5px 10px;
            font-size: 14px;
            color: white;
            background-color: #d9534f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

        .summary {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #37BBEE;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0C59A2;
            scale: 1.1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard de Imagens</h1>

        <?php
        // Caminho da pasta de uploads no Azure App Service
        $uploadDir = '/home/site/uploads';

        // Certifique-se de que a pasta de uploads exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Exclusão de imagem
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
            $imageToDelete = $_POST['delete_image'];
            $fullPath = $uploadDir . '/' . $imageToDelete;

            if (file_exists($fullPath)) {
                unlink($fullPath);
                echo "<p class='summary'>Imagem <strong>$imageToDelete</strong> excluída com sucesso!</p>";
            } else {
                echo "<p class='summary'>Erro: Arquivo não encontrado.</p>";
            }
        }

        // Verifica se a pasta existe
        if (is_dir($uploadDir)) {
            $images = array_diff(scandir($uploadDir), array('.', '..'));

            echo "<div class='image-grid'>";

            // Exibe as imagens encontradas
            foreach ($images as $image) {
                $filePath = $uploadDir . '/' . $image;
                $fileUrl = 'uploads/' . $image; // Ajuste o caminho de acordo com sua configuração de servidor

                // Verifica se o arquivo é uma imagem
                if (is_file($filePath) && @getimagesize($filePath)) {

                    echo "<div class='image-item'>
                            <img src='$fileUrl' alt='$image'>
                            <p><strong>$image</strong></p>
                            <form method='POST'>
                                <input type='hidden' name='delete_image' value='$image'>
                                <button class='delete-btn'>Apagar</button>
                            </form>
                          </div>";
                }
            }

            echo "</div>";

            if (count($images) === 0) {
                echo "<p class='summary'>Nenhuma imagem encontrada na pasta.</p>";
            }
        } else {
            echo "<p class='summary'>Pasta de uploads não encontrada.</p>";
        }
        ?>

        <!-- Botões de navegação -->
        <a href="index.php" class="back-btn">Voltar para a Página Inicial</a>
        <a href="front.php" class="back-btn">Criar novo Cadastro</a>
    </div>
</body>
</html>
