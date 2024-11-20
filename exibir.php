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
    <h1>Imagens no Blob Storage</h1>

    <!-- Listagem de imagens -->
    <div class="image-container">
        <?php
        require 'vendor/autoload.php';

        use MicrosoftAzure\Storage\Blob\BlobRestProxy;
        use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

        // Configurações de exibição de erros (para debug)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Configurações do Azure Blob Storage
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = "prova2";

        // Listar todas as imagens no container
        try {
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $result = $blobClient->listBlobs($containerName);
            $blobs = $result->getBlobs();

            if (count($blobs) > 0) {
                foreach ($blobs as $blob) {
                    $blobUrl = $blobClient->getBlobUrl($containerName, $blob->getName());
                    echo "<div>";
                    echo "<img src='$blobUrl' alt='" . htmlspecialchars($blob->getName()) . "' />";
                    echo "<p>" . htmlspecialchars($blob->getName()) . "</p>";
                    echo "</div>";
                    // Debug: Exibir a URL do blob
                    // echo "<p>URL: <a href='$blobUrl' target='_blank'>$blobUrl</a></p>";
                }
            } else {
                echo "Nenhuma imagem encontrada no container.";
            }
        } catch(ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo "Erro ao listar imagens no Azure Blob Storage: $error_message";
        }
        ?>
    </div>
</div>

<a href="front.php" class="back-btn">Voltar para a Página Inicial</a>
</body>
</html>
