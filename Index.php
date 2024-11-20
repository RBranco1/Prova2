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

        h1 {
            color: #37BBEE;
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

        /* Estilo para os links */
        a {
            display: inline-block;
            margin: 20px 15px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            background-color: #0C59A2;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            color: white;
            scale: 1.1;
            background-color: #37BBEE;
        }

        /* Estilo para o formulário */
        form {
            margin-top: 20px;
        }

        /* Tela de carregamento */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }

        /* Loader */
        .three-body {
            --uib-size: 35px;
            --uib-speed: 0.8s;
            --uib-color: #30A9E8;
            position: relative;
            display: inline-block;
            height: var(--uib-size);
            width: var(--uib-size);
            animation: spin78236 calc(var(--uib-speed) * 2.5) infinite linear;
        }

        .three-body__dot {
            position: absolute;
            height: 100%;
            width: 30%;
        }

        .three-body__dot:after {
            content: '';
            position: absolute;
            height: 0%;
            width: 100%;
            padding-bottom: 100%;
            background-color: var(--uib-color);
            border-radius: 50%;
        }

        .three-body__dot:nth-child(1) {
            bottom: 5%;
            left: 0;
            transform: rotate(60deg);
            transform-origin: 50% 85%;
        }

        .three-body__dot:nth-child(1)::after {
            bottom: 0;
            left: 0;
            animation: wobble1 var(--uib-speed) infinite ease-in-out;
            animation-delay: calc(var(--uib-speed) * -0.3);
        }

        .three-body__dot:nth-child(2) {
            bottom: 5%;
            right: 0;
            transform: rotate(-60deg);
            transform-origin: 50% 85%;
        }

        .three-body__dot:nth-child(2)::after {
            bottom: 0;
            left: 0;
            animation: wobble1 var(--uib-speed) infinite
                calc(var(--uib-speed) * -0.15) ease-in-out;
        }

        .three-body__dot:nth-child(3) {
            bottom: -5%;
            left: 0;
            transform: translateX(116.666%);
        }

        .three-body__dot:nth-child(3)::after {
            top: 0;
            left: 0;
            animation: wobble2 var(--uib-speed) infinite ease-in-out;
        }

        @keyframes spin78236 {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes wobble1 {
            0%,
            100% {
                transform: translateY(0%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateY(-66%) scale(0.65);
                opacity: 0.8;
            }
        }

        @keyframes wobble2 {
            0%,
            100% {
                transform: translateY(0%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateY(66%) scale(0.65);
                opacity: 0.8;
            }
        }
    </style>
</head>

<body>
    <!-- Tela de carregamento -->
    <div id="loading-screen">
        <div class="three-body">
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
        </div>
    </div>

    <!-- Conteúdo da Página -->
    <div class="container">
        <h1>Bem-vindo ao Sistema de Cadastro</h1>
        <img src="logo.png" alt="Logo do Sistema" style="max-width: 200px; margin-bottom: 20px;">

        <form>
            <a href="front.php" class="nav-link">Tela de Cadastro</a>
            <a href="exibir.php" class="nav-link">Exibir Dados</a>
        </form>
    </div>

    <script>
        // Exibir tela de carregamento ao clicar nos links
        const links = document.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('loading-screen').style.display = 'flex';
                const href = this.href;
                setTimeout(() => {
                    window.location.href = href;
                }, 500); // Adiciona um pequeno delay
            });
        });
    </script>
</body>

</html>
