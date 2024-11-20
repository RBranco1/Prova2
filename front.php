<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa com Imagem</title>
    <style>
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
            margin: 100px;
            padding: 0;
            text-align: center;
        }

        h2 {
            text-align: center;
            color: #37BBEE;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #37BBEE;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0C59A2;
            scale: 0.9;
        }

        .container {
            margin-bottom: 20px;
        }

        /* Botão de Voltar */
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            margin-left: 10px;
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

    <form action="teste.php" method="POST" enctype="multipart/form-data">
         <h2>Formulário de Cadastro com Imagem</h2>

        <div class="container">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Joao batista de andrade"required>
        </div>

        <div class="container">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="usuario@gmail.com" required>
        </div>

        <div class="container">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(11) 123456789" required>
        </div>

        <div class="container">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </div>

        <div class="container">
            <label for="endereco">Endereço:</label>
            <textarea id="endereco" name="endereco" rows="4" placeholder="rua joao peixe 155"required></textarea>
        </div>

        <div class="container">
            <label for="imagem">Escolha uma Imagem:</label>
            <input type="file" id="imagem" name="image" accept="image/*" required>
        </div>

        <div class="container">
            <input type="submit" value="Cadastrar">
        </div> 
        <a href="index.php" class="back-btn">Voltar para a Página Inicial</a>
    </form>

   

</body>
</html>
