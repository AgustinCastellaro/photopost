<?php
    require_once "../database/database.php";
    session_start();

    //Si NO hay una sesion activa.
    if(!isset($_SESSION['active'])){
        header("Location: ../index.php");
    }

    if($_GET['id']){
        $idPublicacion = $_GET['id'];
        
        $query = mysqli_query($conection, "SELECT p.id, p.comentario, p.imagenpublicacion
                                        FROM publicaciones p  
                                        WHERE p.id = $idPublicacion ");
    
        $resultado = mysqli_num_rows($query);
        if($resultado == 0){
            header('Location: ../index.php');
        }else{
            while($data = mysqli_fetch_array($query)){
                $comentario         = $data['comentario'];
                $imagenPublicacion  = $data['imagenpublicacion'];
            }
        }
    }

    //POST guardar
    if(isset($_POST['guardar'])){
        if(!empty($_POST['comentario'])){
            //Se actualizan los datos.
            $comentario = $_POST['comentario'];

            $query_update = mysqli_query($conection, "UPDATE publicaciones 
                                                    SET comentario = '$comentario'
                                                    WHERE id = $idPublicacion ");
                
            if($query_update){
                $alert = '<p class="success">Publicación actualizada correctamente</p>';
                header("Refresh:1; url=perfil.php");
            }else{
                $alert = '<p class="error">Error al actualizar la publicación</p>';
            }
        }
    }

    //POST eliminar
    if(isset($_POST['eliminar'])){
        //Elimina "imagen" de la base de datos.
        $query_delete = mysqli_query($conection, "DELETE FROM publicaciones 
                                                    WHERE id = $idPublicacion ");
            
        //Elimina imagen de la carpeta.
        $imagenEliminada = unlink("../img/publicaciones/".$imagenPublicacion);
        if($imagenEliminada && $query_delete){
            $alert = '<p class="success">Publicación eliminada correctamente</p>';
            header("Refresh:1; url=perfil.php");
        }else{
            $alert = '<p class="error">Error al eliminar la publicación</p>';
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
        <form method="post" enctype="multipart/form-data">
            <div class="ef-contenido">
                <div class="alert">
                    <?php echo isset($alert) ? $alert : ''; ?>
                </div>
                <div class="titulo">
                    <p>Editar publicación</p>
                </div>
                <div class="datos">
                    <div class="imagen">
                        <img src="../img/publicaciones/<?php echo $imagenPublicacion;?>" alt="" class="imagen_subida" name="Imagen" id="sf_imagen">
                    </div>
                    <div class="comentario">
                        <div class="titulo">
                            <label for="comentario">Comentario</label>
                            <div class="caracteres">
                                 <p id="carac_actual_editar_publicacion"></p>
                            </div>
                        </div>
                        <textarea name="comentario" id="comentario_editar_publicacion" placeholder="Describe tu publicación" cols="30" rows="10" maxlength="300" required><?php echo $comentario;?></textarea>
                    </div>
                </div>
                <div class="guardar">
                    <button type="submit" name="guardar" id="guardar">Guardar</button>
                </div>
                <div class="eliminar">
                    <button type="submit" name="eliminar" id="eliminar">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>