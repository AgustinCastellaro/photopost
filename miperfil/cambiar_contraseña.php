<?php
    require_once "../database/database.php";
    session_start();

    $id = $_SESSION['idusuario'];
    $email = $_SESSION['email'];

    if(!empty($_POST)){
        //Se actualizan los datos.
        if(empty($_POST['nuevaContraseña']) || empty($_POST['confirmarNuevaContraseña'])){
            $alert = '<p class="error">Debes rellenar todos los campos</p>';
        }else{
            $nuevaContraseña            = $_POST['nuevaContraseña'];
            $confirmarNuevaContraseña   = $_POST['confirmarNuevaContraseña'];
            
            if($nuevaContraseña == $confirmarNuevaContraseña){
                $query_update = mysqli_query($conection, "UPDATE usuarios 
                                                        SET contraseña = '$nuevaContraseña' 
                                                        WHERE id = '$id' ");

                if($query_update){
                    
                    $asunto = "Cambio de contraseña";
                    $mensaje = "Contraseña actualizada correctamente";
                    $header = "FROM: photopost@gmail.com"."\r\n";
                    $mail = mail($email, $asunto, $mensaje, $header);
                    
                    $alert = '<p class="success">Contraseña actualizada correctamente</p>';                    
                    
                }else{
                    $alert = '<p class="error">Error al actualizar los datos</p>';
                }

            }else{
                $alert = '<p class="error">Ambos campos deben ser iguales</p>';
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
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="../css/media.style.css">
    <!-- JS -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/functions.js"></script>
    <link rel="icon" href="../img/logo/icono/logo.png" type="image/icon type">
    <title>Photopost</title>
</head>
<body>
    <!-- Nav -->
    <?php include "../includes/nav.php"?>

    <div class="contenido">
        <form method="post">
            <div class="cambiarContraseña">
                <div class="alert">
                    <?php echo isset($alert) ? $alert : '';?>
                </div>
                <div class="titulo">
                    <p>Cambiar contraseña</p>
                </div>
                <div class="datos">
                    <div class="nuevaContraseña">
                        <label for="nuevaContraseña">Nueva contraseña</label>
                        <input type="text" name="nuevaContraseña" id="nuevaContraseña" placeholder="Nueva Contraseña" required>
                    </div>
                    <div class="confirmarNuevaContraseña">
                        <label for="confirmarNuevaContraseña">Confirmar nueva contraseña</label>
                        <input type="text" name="confirmarNuevaContraseña" id="confirmarNuevaContraseña" placeholder="Confirmar nueva contraseña" required>
                    </div>
                </div>
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>