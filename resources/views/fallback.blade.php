<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Algo correu mal</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: rgb(11, 11, 11);
            font-family: Arial, sans-serif;
        }

        spline-viewer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: block;
            z-index: 0;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }

        .overlay a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .overlay a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.96/build/spline-viewer.js"></script>
    <spline-viewer url="https://prod.spline.design/XOPl3PBs3OKjKG01/scene.splinecode"></spline-viewer>

    <div class="overlay">
        <h1>Estás perdido?</h1>
        <p>Clica no botão abaixo para voltares ao início.</p>
        <a href="{{ url('/') }}">Voltar ao Início</a>
    </div>
</body>

</html>
