<?php
    require_once "../database/database.php";
    session_start();
    
    //Si NO hay una sesion activa.
    if(!isset($_SESSION['active'])){
        header("Location: ../index.php");
    }

    //Consulta datos Usuario.
    $id = $_SESSION['idusuario'];
    $query = mysqli_query($conection, "SELECT nombre, apellido, email, contraseña, descripcion, imagenusuario, instagram, web, ubicacion 
                                        FROM usuarios 
                                        WHERE id = '$id' ");

    $result = mysqli_num_rows($query);
    if($result == 0){
        header('Location: perfil.php');
    }else{
        while($data = mysqli_fetch_array($query)){
            $imagenusuario  = $data['imagenusuario'];
            $nombre         = $data['nombre'];
            $apellido       = $data['apellido'];
            $email          = $data['email'];
            $contraseña     = $data['contraseña'];
            $descripcion    = $data['descripcion'];
            $instagram      = $data['instagram'];
            $web            = $data['web'];
            $ubicacion      = $data['ubicacion'];
        }
    }

    //Post Datos
    $alert = '';
    if(!empty($_POST)){
        //Se actualizan los datos.
        if(empty($_POST['nombre']) || 
            empty($_POST['apellido']) || 
            empty($_POST['email']) || 
            empty($_POST['descripcion']) ){
            
            $alert = '<p class="error">Debes rellenar los campos obligatorios</p>';
        }else{
            $nombre         = $_POST['nombre'];
            $apellido       = $_POST['apellido'];
            $email          = $_POST['email'];
            $descripcion    = $_POST['descripcion'];
            $instagram      = $_POST['instagram'];
            $web            = $_POST['web'];
            $ubicacion      = $_POST['ubicacion'];
    
            $query = mysqli_query($conection,"SELECT * FROM usuarios
                                                WHERE email = '$email' 
                                                AND id != '$id' ");
    
            $resultado_email_usuario = mysqli_fetch_array($query);
    
            if($resultado_email_usuario > 0){
                $alert = '<p class="error">El email ya esta en uso</p>';
            }else{
                $query_update = mysqli_query($conection, "UPDATE usuarios 
                                                SET nombre = '$nombre', 
                                                apellido = '$apellido', 
                                                email = '$email', 
                                                descripcion = '$descripcion', 
                                                instagram = '$instagram', 
                                                web = '$web', 
                                                ubicacion = '$ubicacion' 
                                                WHERE id = '$id' ");
                
                
                //Si el tamaño de la imagen corresponde y es PNG o JPG.
                if(($_FILES['imagen']['size'] < '5242880' && $_FILES['imagen']['type'] == 'image/png') || 
                    ($_FILES['imagen']['size'] < '5242880' && $_FILES['imagen']['type'] == 'image/jpeg')){
                        //Actualizo la imagen.
                        $nombreImagen    = "IMG_id_".$id.".png";
                        $url_tmp        = $_FILES['imagen']["tmp_name"];
                        $src            = "../img/usuarios/".$nombreImagen;
        
                        $query_update = mysqli_query($conection, "UPDATE usuarios 
                                                        SET imagenusuario = '$nombreImagen' 
                                                        WHERE id = '$id' ");
                        
                        if($query_update){
                            //Sube la imagen a la carpeta usuarios.
                            if(move_uploaded_file($url_tmp, $src)){
                                $alert = '<p class="success">Usuario actualizado correctamente</p>';
                                header("Refresh:1; url=perfil.php");
                            }else{
                                echo "Error al actualizada la imagen";
                                $alert = '<p class="error">Error al actualizar la imagen</p>';
                            }
                        }
        
                }else{
                    //Si no se quiere actualizar la imagen.
                    if($_FILES['imagen']['size'] == ''){
                        $alert = '<p class="success">Usuario Actualizado correctamente</p>';
                        header("Refresh:1; url=perfil.php");
                    }
                    //Si el tamaño de la imagen es mayor a 5 MB.
                    if($_FILES['imagen']['size'] > '5242880'){
                        $alert = '<p class="error">El tamaño de la imagen tiene que ser menor a 5 MB</p>';
                    }
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="editar_perfil">
                <div class="alert">
                    <?php echo isset($alert) ? $alert : '';?>
                </div>
                <div class="titulo">
                    <p>Editar perfil</p>
                </div>
                <div class="info">
                    <div class="imagen">
                        <div class="imagen_select">
                            <input type="file" onchange="readURL_editar_perfil(this);" name="imagen" id="imagen" title="">
                            <img src="/photopost/img/usuarios/<?php echo $imagenusuario;?>" alt="" name="Imagen" id="ep_imagen">
                        </div>
                        <div class="mensaje">
                            <p>Recomendación:</p>
                            <p>Solo archivos JPG, PNG menores a 5 MB</p>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="inputs_group">
                            <div class="nombre">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre;?>" required>
                            </div>
                            <div class="apellido">
                                <label for="apellido">Apellido</label>
                                <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo $apellido;?>" required>
                            </div>
                        </div>
                        
                        <div class="email">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Email" value="<?php echo $email;?>" required>
                        </div>

                        <div class="contraseña">
                            <label for="contraseña">Contraseña</label>
                            <div class="inputContraseña">
                                <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" value="<?php echo $contraseña;?>" readonly>
                                <a href="cambiar_contraseña.php">Cambiar contraseña</a>
                            </div>
                        </div>

                        <div class="descripcion">
                            <div class="titulo">
                                <label for="descripción">Descripción</label>
                                <div class="caracteres">
                                    <p id="carac_actual_editar_perfil"></p>
                                </div>
                            </div>
                            <textarea name="descripcion" id="descripcion_editar_perfil" cols="30" rows="10" maxlength="300" placeholder="Descripción" required><?php echo $descripcion;?></textarea>
                        </div>

                        <div class="enlaces">
                            <div class="instagram">
                                <label for="instagram">Instagram</label>
                                <div class="input">
                                    <button type="button" class="arroba">@</button>
                                    <input type="text" name="instagram" id="instagram" placeholder="Instagram" value="<?php echo $instagram;?>">
                                </div>
                            </div>
                            <div class="sitioweb">
                                <label for="sitioweb">Sitio Web</label>
                                <input type="text" name="web" id="web" placeholder="Sitio Web" value="<?php echo $web?>">
                            </div>
                            <div class="ubicacion">
                                <label for="ubicacion">Ubicación</label>
                                <input type="text" name="ubicacion" id="ubicacion" placeholder="Ubicación" value="<?php echo $ubicacion?>">
                            </div>
                        </div>

                        <div class="guardar">
                            <button type="submit" name="guardar">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>