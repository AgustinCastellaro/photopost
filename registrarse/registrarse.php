<?php
    require_once "../database/database.php";

    $alert = '';
    if(!empty($_POST)){
        if(empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email']) || empty($_POST['contraseña'])){
            $alert = '<p class="error">Debes rellenar todos los campos</p>';
        }else{
            include "../database/database.php";

            $nombre         = $_POST['nombre'];
            $apellido       = $_POST['apellido'];
            $email          = $_POST['email'];
            $contraseña     = $_POST['contraseña'];

            $query = mysqli_query($conection,"SELECT * FROM usuarios
                                                WHERE email = '$email' ");
                                                    
            $resultado_email_usuario = mysqli_fetch_array($query);

            if($resultado_email_usuario > 0){
                $alert = '<p class="error">El email ya esta en uso</p>';
            }else{
                $query_insert = mysqli_query($conection,"INSERT INTO usuarios(nombre, apellido, email, contraseña, descripcion, imagenusuario, instagram, web, ubicacion)
                                                            VALUES ('$nombre', '$apellido', '$email', '$contraseña', '', 'IMG_default.png', '', '', '')");

                if($query_insert){
                    $alert = '<p class="success">Usuario creado correctamente</p>';
                    header("Refresh:1; ../login/login.php?email_Reg=$email");
                }else{
                    $alert = '<p class="error">Error al crear el usuario</p>';
                }
            }
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
            <div class="registrarse">
                <div class="imagen_fondo">
                    <p>Las grandes ideas comienzan con una simple fotografía</p>
                </div>
                <div class="info">
                    <div class="alert">
                        <?php echo isset($alert) ? $alert : ''; ?>
                    </div>
                    <img src="../img/logo/logo_negro.svg" id="logo" alt="">
                    <div class="inputs">
                        <div class="inputs_group">
                            <div class="nombre">
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                            </div>
                            <div class="apellido">
                                <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
                            </div>
                        </div>
                        <input type="text" name="email" id="email" placeholder="Email" required>
                        <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                        <div class="registrarse_btn">
                            <button type="submit">Registrarse</button>
                        </div>
                        <div class="r-login">
                            <p>Ya tienes cuenta?</p>
                            <a href="../login/login.php">Inicia sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>