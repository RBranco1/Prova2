<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa com Imagem</title>
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

        /* Estilo para o formulário */
        form {
            margin-top: 20px;
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
    </style>
</head>
<body>

<div class="container">
    <h1>Bem-vindo ao Sistema</h1>

    <!-- Formulário de upload de imagem -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Enviar Imagem</button>
    </form>

    <!-- Listagem de imagens -->
    <div class="image-container">
        <?php
        require 'vendor/autoload.php';

        use MicrosoftAzure\Storage\Blob\BlobRestProxy;
        use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
        use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

        // Configurações de exibição de erros (para debug)
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Configurações do Azure Blob Storage
        $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
        $containerName = "prova2";

        // Verifica se o formulário foi enviado e se há um arquivo de imagem
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
            // Caminho absoluto da pasta de upload
            $uploadDir = __DIR__ . '/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // Verifica se a pasta de uploads existe
            if (!is_dir($uploadDir)) {
                echo "A pasta de uploads não existe.";
                exit;
            }

            // Verifica se houve erro no upload
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo "Erro no upload: " . $_FILES['image']['error'];
                exit;
            }

            // Verifica se a imagem foi enviada corretamente
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "Imagem enviada com sucesso!<br>";

                // Enviar para o Azure Blob Storage
                try {
                    $blobClient = BlobRestProxy::createBlobService($connectionString);
                    $content = fopen($uploadFile, "r");
                    $options = new CreateBlockBlobOptions();
                    $options->setContentType(mime_content_type($uploadFile));

                    $blobClient->createBlockBlob($containerName, basename($_FILES['image']['name']), $content, $options);
                    echo "Imagem enviada para o Azure Blob Storage!<br>";
                } catch(ServiceException $e){
                    $code = $e->getCode();
                    $error_message = $e->getMessage();
                    echo "Erro ao enviar para o Azure Blob Storage: $error_message";
                }

            } else {
                echo "Erro no upload da imagem.";
            }
        } else {
            echo "Nenhuma imagem enviada.";
        }

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
                    echo "<p>URL: <a href='$blobUrl' target='_blank'>$blobUrl</a></p>";
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
