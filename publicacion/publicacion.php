<?php
    require_once "../database/database.php";
    session_start();
    //print_r($_SESSION);
    //Eliminar el cache.
    clearstatcache();
    
    if($_GET['id']){
        $idPublicacion = $_GET['id'];
        
        $query = pg_query($conection, "SELECT p.id, p.comentario, p.imagenpublicacion, u.id, u.nombre, u.apellido, u.imagenusuario
                                            FROM publicaciones p 
                                            INNER JOIN usuarios u 
                                            ON p.idusuario = u.id 
                                            WHERE p.id = $idPublicacion ");
    
        $resultado = pg_num_rows($query);
        if($resultado == 0){
            header('Location: ../index.php');
        }else{
            while($data = pg_fetch_array($query)){
                $id                 = $data['0'];
                $comentario         = $data['1'];
                $imagenPublicacion  = $data['2'];
                $idUsuario          = $data['3'];
                $nombre             = $data['4'];
                $apellido           = $data['5'];
                $imagenusuario      = $data['6'];
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
    <link rel="stylesheet" href="css/publicacion.css">
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
        <div class="publicacion">
            <div class="p-imagen">
                <img src="../img/publicaciones/<?php echo $imagenPublicacion;?>" alt="">
            </div>
            <div class="info">
                <a href="../img/publicaciones/<?php echo $imagenPublicacion;?>" class="descargar" download="photopost-<?php echo $nombre . "-" . $idPublicacion . "-" . $apellido?>.png">Descargar</a>
                <div class="usuario">
                    <p class="titulo_usuario">Subido por</p>
                    <div class="perfil">
                        <div class="datos">
                            <img src="../img/usuarios/<?php echo $imagenusuario;?>" id="img_usuario" alt="">
                            <p id="nombre_usuario"><?php echo $nombre;?> <?php echo $apellido;?></p>
                        </div>
                        <div class="verPerfil">
                            <?php
                                // Si la publicación es del usuario logueado.
                                if($idUsuario == $_SESSION['idusuario']){
                            ?>
                                    <a href="../miperfil/perfil.php">Ver perfil</a>
                            <?php
                                }else{
                            ?>
                                    <a href="../usuario/usuario.php?id=<?php echo $idUsuario;?>">Ver perfil</a>
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
                <?php 
                    if($comentario != ""){
                    ?>
                        <hr>
                        <div class="comentario">
                            <h1>Comentario</h1>
                            <p id="comentario_publicacion"><?php echo $comentario;?></p>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>