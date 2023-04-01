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

        .unauthorized-icon {
            width: 100px;
            height: 100px;
            background-color: #e74c3c;
            border-radius: 50%;
            margin: 0 auto 30px auto;
            position: relative;
            animation: unauthorized 1.5s ease-out infinite;
        }

        .unauthorized-icon:before {
            content: "";
            width: 20px;
            height: 20px;
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            top: 35px;
            left: 35px;
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

        @keyframes unauthorized {
            0% {
                transform: rotate(0deg);
            }
            20% {
                transform: rotate(-20deg);
            }
            40% {
                transform: rotate(20deg);
            }
            60% {
                transform: rotate(-20deg);
            }
            80% {
                transform: rotate(20deg);
            }
            100% {
                transform: rotate(0deg);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">405</div>
        <div class="error-message">Acceso no autorizado</div>
        <div class="unauthorized-icon"></div>
        <a href="http://localhost/EcuApp/" class="btn">Volver al inicio</a>
    </div>
</body>
</html>