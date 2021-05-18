<?php
    require_once "../database/database.php";
    session_start();
    //print_r($_SESSION);
    //Eliminar el cache.
    clearstatcache();

    //Variables
    date_default_timezone_set("America/Argentina/Cordoba");

    //Si NO hay una sesion activa.
    if(!isset($_SESSION['active'])){
        header("Location: ../index.php");
    }

    $date = date_create();
    $fechaPC = date_format($date, 'Y-m-d H:i:s');

    $id = $_SESSION['idusuario'];

    //Optimiza la imagen y la sube a la carpeta
    function optimizar_imagen($origen, $destino, $tipo, $calidad){
        if($tipo == 'image/jpeg'){
            $imagen = imagecreatefromjpeg($origen);
            imagejpeg($imagen, $destino, $calidad);
        }
        if($tipo == 'image/png'){
            $imagen = imagecreatefrompng($origen);
            imagepng($imagen, $destino, $calidad);
        }

        return $destino;
    }

    //POST publicación
    if(!empty($_POST)){
        $comentario = $_POST['comentario'];

        //Si el tamaño de la imagen corresponde y es PNG o JPG.
        if(($_FILES['imagen']['size'] < '10000000' && $_FILES['imagen']['type'] == 'image/png') || 
        ($_FILES['imagen']['size'] < '10000000' && $_FILES['imagen']['type'] == 'image/jpeg')){
            
            $query = mysqli_query($conection, "SELECT *
                                            FROM publicaciones 
                                            WHERE idusuario = '$id' ");

            $query = mysqli_num_rows($query) + 1;

            $name_imagen    = "IMG_id".$id."_pub".$query.".png";
            $url_tmp        = $_FILES['imagen']["tmp_name"];
            $src            = "../img/publicaciones/".$name_imagen;
            $type           = $_FILES['imagen']["type"];

            optimizar_imagen($url_tmp, $src, $type, 40);

            $query_update = mysqli_query($conection, "INSERT INTO publicaciones (idusuario, imagenpublicacion, fecha, comentario) 
                                                VALUES ('$id', '$name_imagen', '$fechaPC', '$comentario') ");
            
            if($query_update){
                //Sube la imagen a la carpeta usuarios.
                $alert = '<p class="success">Imagen publicada correctamente</p>';
                header("Refresh:1; url=../miperfil/perfil.php");
            }else{
                echo "Error al actualizar la imagen";
                $alert = '<p class="error">Error al actualizar la imagen</p>';
            }
        }else{
            //Si el tamaño de la imagen es mayor a 5 MB.
            if($_FILES['imagen']['size'] > '10000000'){
                $alert = '<p class="error">El tamaño de la imagen tiene que ser mayor a 5 MB</p>';
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
    <link rel="stylesheet" href="css/subir_foto.css">
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
            <div class="sf-contenido">
                <div class="alert">
                    <?php echo isset($alert) ? $alert : ''; ?>
                </div>
                <div class="titulo">
                    <p>Subir una foto</p>
                </div>
                <div class="mensaje">
                    <p>Revisaremos el contenido que has presentado. Si cumple nuestras normas, recibirás una notificación por correo electrónico y el contenido aparecerá en la web.</p>
                </div>
                <hr>
                <div class="datos">
                    <div class="imagen" id="sf_div_imagen">
                        <img src="" alt="" class="imagen_subida" name="Imagen" id="sf_imagen">
                        <input type="file" onchange="readURL_subir_foto(this);" name="imagen" id="sf_input" title="">
                        <div class="info" id="sf_info_img">
                            <img src="/photopost/img/icons/subir_foto.svg" alt="">
                            <p>Haz click para subir una foto</p>
                        </div>
                    </div>
                    <div class="recomendacion">
                        <p class="titulo">Recomendación:</p>
                        <p class="r-mensaje">Utiliza archivos PNG, JPG de un tamaño inferior a 5 MB</p>
                    </div>
                    <div class="comentario">
                        <div class="titulo">
                            <label for="comentario">Comentario</label>
                            <div class="caracteres">
                                 <p id="carac_actual_subir_foto"></p>
                            </div>
                        </div>
                        <textarea name="comentario" id="comentario_subir_foto" placeholder="Describe tu publicación" cols="30" rows="10" maxlength="300" required></textarea>
                    </div>
                </div>
                <div class="publicar">
                    <button type="submit" name="publicar">Publicar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>