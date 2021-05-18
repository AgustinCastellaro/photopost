<?php
    require_once "../database/database.php";

    //Inicia la sesión.
    session_start();
    if(!empty($_SESSION['active'])){
        header("Location: ../index.php");
    }else{
        if(!empty($_POST)){
            if(empty($_POST['email']) || empty($_POST['contraseña'])){
                $alert = '<p class="error">Ingrese su email y contraseña</p>';
            }else{
                $email          = $_POST['email'];
                $contraseña     = $_POST['contraseña'];

                $query = mysqli_query($conection,"SELECT * FROM usuarios
                                                    WHERE email = '$email' 
                                                    AND contraseña = '$contraseña' ");
                                                        
                $result = mysqli_num_rows($query);
                                                        
                if($result > 0){
                    $data = mysqli_fetch_array($query);
                    $_SESSION["active"]         = true;
                    $_SESSION['idusuario']      = $data['id'];
                    $_SESSION['nombre']         = $data['nombre'];
                    $_SESSION['apellido']       = $data['apellido'];
                    $_SESSION['email']          = $data['email'];
                    $_SESSION['contraseña']     = $data['contraseña'];
                    $_SESSION['descripcion']    = $data['descripcion'];
                    $_SESSION['instagram']      = $data['instagram'];
                    $_SESSION['web']            = $data['web'];
                    $_SESSION['ubicacion']      = $data['ubicacion'];
                    $_SESSION['imagenusuario']  = $data['imagenusuario'];

                    header("Location: ../index.php");
                }else{
                    $alert = '<p class="error">Email o contraseña incorrectos</p>';
                    session_destroy();
                }
            }
        }
    }

    
    //Mostrar datos Registrarse.
    if(empty($_GET["email_Reg"])){
        $result = 0;
    }else{
        $email_Reg = $_GET["email_Reg"];
    
        $sql = mysqli_query($conection, "SELECT u.email, u.contraseña FROM usuarios u
                                            WHERE email = '$email_Reg' ");
    
        $result = mysqli_num_rows($sql);
    
        if($result > 0){
            while($data = mysqli_fetch_array($sql)){
                $email          = $data['email'];
                $contraseña     = $data['contraseña'];
            }
        }
        $alert = '<p class="success">Inicia sesion para mostrarle al mundo tus ideas!</p>';
        
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
            <div class="login">
                <div class="imagen_fondo">
                    <p>Las grandes ideas comienzan con una simple fotografía</p>
                </div>
                <div class="info">
                    <div class="alert">
                        <?php echo isset($alert) ? $alert : ''; ?>
                    </div>
                    <img src="../img/logo/logo_negro.svg" id="logo" alt="">
                    <div class="inputs">
                        <input type="text" name="email" id="email" placeholder="Email" <?php 
                                                                                            if($result > 0){
                                                                                        ?>
                                                                                                value="<?php echo $email;?>"
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                        >
                        <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" <?php 
                                                                                                    if($result > 0){
                                                                                                ?>
                                                                                                        value="<?php echo $contraseña;?>"
                                                                                                <?php
                                                                                                    }
                                                                                                ?>
                        >
                        <div class="login_btn">
                            <button type="submit">Login</button>
                        </div>
                        <div class="olvidaste_contraseña">
                            <a href="olvidaste_contraseña.php">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="l-registrarse">
                            <p>No tienes cuenta?</p>
                            <a href="../registrarse/registrarse.php">Registrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>