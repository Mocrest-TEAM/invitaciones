<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Redirect</title>
    <script>
        function countdown() {
            var seconds = <?php echo $setting['seconds']; ?>;
            var countdown = document.getElementById('countdown');
            var interval = setInterval(function() {
                countdown.innerHTML = seconds;
                seconds--;
                if (seconds < 0) {
                    clearInterval(interval);
                    window.location.href = '<?php echo $url; ?>'; // Redirect
                }
            }, 1000);
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .advertise, .advertise iframe {
            width: 300px;
            height: 300px;
            margin: 0 auto;
        }
        button {
            margin: 20px auto;
            width: 300px;
            height: 36px;
            background: #4AB2FF;
            border: 0;
            color: #fff;
            font-size: 16px;
            display: block;
        }
        p {
            padding: 0 20px;
        }
        .center {
            text-align: center;
        }
        p span {
            color: red;
            word-wrap: break-word;
        }
    </style>
</head>
<body onload="countdown()">
<h2 class="center">Atencion</h2>
<p class="center">Tenga cuidado con la seguridad en la siguiente página.</p>
<?php if ($setting['html']): ?>
    <div class="advertise"><?php echo $setting['html']; ?></div>
<?php endif; ?>
<p class="center">La URL de la página siguiente es:</p>
<p class="center"><span><?php echo $url; ?></span></p>
<button onclick="window.location.href = '<?php echo $url; ?>';">Redirigir ahora</button>
    <p class="center"> Redireccionando en <span id="countdown"><?php echo $setting['seconds']; ?></span> segundos...</p>
<br>
<p class="center">
    Esta web nunca te pedira tus datos personales... La unica funcion de esta web es llevar un conteo de clicks y redireccionar al enlace seleccionado
</p>
</body>
</html>
