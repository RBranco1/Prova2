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

// HTML inicial com estilos
echo <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 20px;
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
        }
    </style>
</head>
<body>
    <h1>Resultado do Cadastro</h1>
    <div class="content">
HTML;

// Verifica se o formulário foi enviado e se há um arquivo de imagem
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $uploadDir = __DIR__ . '/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    if (!is_dir($uploadDir)) {
        echo "A pasta de uploads não existe.";
        exit;
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Erro no upload: " . $_FILES['image']['error'];
        exit;
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        echo "Imagem enviada com sucesso!<br>";

        try {
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $content = fopen($uploadFile, "r");
            $options = new CreateBlockBlobOptions();
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $uploadFile);
            finfo_close($finfo);    

            $blobClient->createBlockBlob($containerName, basename($_FILES['image']['name']), $content, $options);
            echo "Imagem enviada para o Azure Blob Storage!<br>";
        } catch(ServiceException $e){
            echo "Erro ao enviar para o Azure Blob Storage: " . $e->getMessage();
        }

        $endpoint = 'https://reconhecimentoprova2.cognitiveservices.azure.com/face/v1.0/detect';
        $key = '6JXH8i0huVYzbFf1q4I1OAlmhgC9aJKLAbW11lx93AAO6JplIMCrJQQJ99AKACZoyfiXJ3w3AAAKACOGwjts';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $headers = [
            'Ocp-Apim-Subscription-Key: ' . $key,
            'Content-Type: application/octet-stream',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($uploadFile));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Erro cURL: ' . curl_error($ch);
        } else {
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $jsonResponse = json_decode($response, true);
                $numFaces = count($jsonResponse);

                echo "<p><strong>Número de rostos detectados: $numFaces</strong></p>";
                echo "<img src='/uploads/" . basename($_FILES['image']['name']) . "' alt='Imagem enviada' />";
                echo "<br>";
            } else {
                echo "Erro na resposta da Azure: " . $response;
            }
        }

        curl_close($ch);
    } else {
        echo "Erro no upload da imagem.";
    }
} else {
    echo "Nenhuma imagem enviada.";
}

echo <<<HTML
        <a href='index.php' class='back-btn'>Voltar para a Página Inicial</a>
    </div>
</body>
</html>
HTML;
?>
