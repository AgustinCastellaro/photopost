<?php
    require_once "../database/database.php";

    if(!empty($_POST)){
        //Se actualizan los datos.
        if(empty($_POST['email'])){
            $alert = '<p class="error">Debes rellenar el campo</p>';
        }else{
            $email = $_POST['email'];
            
            $asunto = "Contraseña olvidada";
            $mensaje = "Para cambiar la contraseña haga click en el siguiente link";
            $header = "FROM: photopost@gmail.com"."\r\n";
            $mail = mail($email, $asunto, $mensaje, $header);
            
            $alert = '<p class="success">Correo enviado correctamente<br>revisa tu bandeja de entrada</p>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.style.css">
    <!-- JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/functions.js"></script>
    <link rel="icon" href="../img/logo/icono/logo.png" type="image/icon type">
    <title>Photopost</title>
</head>
<body>
    <div class="contenido">
        <form action="" method="post">
            <div class="olvidasteContraseña">
                <div class="alert">
                    <?php echo isset($alert) ? $alert : '';?>
                </div>
                <img src="../img/logo/logo_negro.svg" id="logo" alt="">
                <div class="titulo">
                    <p>Reestablecer contraseña</p>
                </div>
                <div class="datos">
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Ingresa tu email" required>
                    </div>
                </div>
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>
</body>
</html>