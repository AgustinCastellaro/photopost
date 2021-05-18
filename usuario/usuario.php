<?php
    require_once "../database/database.php";
    session_start();
    //print_r($_SESSION);
    //Eliminar el cache.
    clearstatcache();
    
    if($_GET['id']){
        $iduser = $_GET['id'];
        $query_usuario = mysqli_query($conection, "SELECT nombre, apellido, email, descripcion, instagram, web, ubicacion, imagenusuario 
                                                    FROM usuarios 
                                                    WHERE id = '$iduser' ");
    
        $resultado = mysqli_num_rows($query_usuario);
        if($resultado == 0){
            header('Location: ../index.php');
        }else{
            while($data = mysqli_fetch_array($query_usuario)){
                $imagenusuario  = $data['imagenusuario'];
                $nombre         = $data['nombre'];
                $apellido       = $data['apellido'];
                $email          = $data['email'];
                $descripcion    = $data['descripcion'];
                $instagram      = $data['instagram'];
                $sitioweb       = $data['web'];
                $ubicacion      = $data['ubicacion'];
            }
        }
        
    
        $query_publicaciones = mysqli_query($conection, "SELECT p.id, p.imagenpublicacion 
                                                    FROM publicaciones p
                                                    INNER JOIN usuarios u 
                                                    ON u.id = p.idusuario 
                                                    WHERE p.idusuario = '$iduser' ");
        
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
    <link rel="stylesheet" href="css/usuario.css">
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
        <div class="usuario">
            <div class="info">
                <div class="imagen">
                    <img src="/photopost/img/usuarios/<?php echo $imagenusuario;?>" alt="">
                </div>
                <p id="nombre">
                    <?php echo $nombre;?>
                    <?php echo $apellido;?>
                </p>
                <div class="descripcion">
                    <p><?php echo $descripcion;?></p>
                </div>
                <div class="enlaces">
                <?php
                    if($instagram != ""){
                        ?>
                        <div class="enlace">
                            <i class="fab fa-instagram"></i>
                            <a href="https://www.instagram.com/<?php echo $instagram;?>" target="_blank"><?php echo $instagram;?></a>
                        </div>
                        <?php
                    }
                ?>
                <?php
                    if($sitioweb != ""){
                        ?>
                        <div class="enlace">
                            <i class="fas fa-link"></i>
                            <a href="https://www.<?php echo $sitioweb;?>" target="_blank"><?php echo $sitioweb;?></a>
                        </div>
                        <?php
                            
                    }
                ?>
                <?php
                    if($ubicacion != ""){
                        ?>
                        <div class="enlace">
                            <i class="fas fa-map-marker"></i>
                            <a href="#"><?php echo $ubicacion;?></a>
                        </div>
                        <?php
                            
                    }
                ?>
                </div>
            </div>

            <div class="submenu">
                <div class="opciones">
                    <div class="publicacionesUsuario">
                        <button id="active">Publicaciones</button>
                    </div>
                </div>
                <hr>
            </div>

            <?php
                if(mysqli_num_rows($query_publicaciones) == 0){ 
                    ?>
                    <div class="mensaje_publicaciones">
                        <a href="../subir_foto/subir_foto.php">
                            <img src="../img/icons/perfil/upload.svg" alt="">
                            <p>Comienza a subir imagenes</p>
                        </a>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="grid-container">
                    <?php
                        while($result = mysqli_fetch_assoc($query_publicaciones)){
                            list($width, $height) = getimagesize("../img/publicaciones/".$result["imagenpublicacion"]);
                            if($width < $height){
                                //tipo 1
                                ?>
                                    <a href="/photopost/publicacion/publicacion.php?id=<?php echo $result['id'];?>" class="grid-item tall">
                                        <img src="../img/publicaciones/<?php echo $result["imagenpublicacion"];?>" loading="lazy" alt="">
                                    </a>
                                <?php
                            }else{
                                //tipo 2
                                ?>
                                    <a href="/photopost/publicacion/publicacion.php?id=<?php echo $result['id'];?>" class="grid-item">
                                        <img src="../img/publicaciones/<?php echo $result["imagenpublicacion"];?>" loading="lazy" alt="">
                                    </a>
                                <?php
                            }
                        }
                    ?>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</body>
</html>