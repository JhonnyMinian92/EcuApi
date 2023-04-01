<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcuApp</title>
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            text-align: center;
            padding-top: 50px;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #e74c3c;
        }

        .error-message {
            font-size: 30px;
            margin-bottom: 30px;
        }

        .broken-cable {
            width: 100px;
            height: 100px;
            border: 10px solid #e74c3c;
            border-radius: 50%;
            margin: 0 auto 30px auto;
            position: relative;
            animation: cable 2s linear infinite;
        }

        .broken-cable:before {
            content: "";
            width: 20px;
            height: 20px;
            background-color: #e74c3c;
            border-radius: 50%;
            position: absolute;
            top: -5px;
            left: -5px;
        }

        .broken-cable:after {
            content: "";
            width: 20px;
            height: 20px;
            background-color: #e74c3c;
            border-radius: 50%;
            position: absolute;
            bottom: -5px;
            right: -5px;
        }

        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 18px;
            margin-top: 30px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <div class="error-message">Página no encontrada</div>
        <div class="broken-cable"></div>
        <a href="http://localhost/EcuApp/" class="btn">Volver al inicio</a>
    </div>
    <script>
        // Anima la conexión rota
        const brokenCable = document.querySelector('.broken-cable');
        const duration = 2000;

        function animateCable(timestamp) {
            const runtime = timestamp % duration / duration;
            const progress = Math.sin(runtime * Math.PI);
            brokenCable.style.transform = `rotate(${progress * 20}deg)`;
            window.requestAnimationFrame(animateCable);
        }

        window.requestAnimationFrame(animateCable);
    </script>
</body>
</html>
