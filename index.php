<?php
    require_once "database/database.php";
    session_start();

    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 1 Jan 1900 05:00:00 GMT");

    $query = mysqli_query($conection, "SELECT * FROM publicaciones 
                                        ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.style.css">
    <!-- JS -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/functions.js"></script>
    <link rel="icon" href="img/logo/icono/logo.png" type="image/icon type">
    <title>Photopost</title>
</head>
<body>
    <!-- Nav -->
    <?php include "includes/nav.php"?>

    <div class="contenido">
        <div class="grid-container">
            <?php
                while($result = mysqli_fetch_assoc($query)){
                    list($width, $height) = getimagesize("img/publicaciones/".$result["imagenpublicacion"]);
                    if($width < $height){
                        //tipo 1
                        ?>
                            <a href="/photopost/publicacion/publicacion.php?id=<?php echo $result['id'];?>" class="grid-item tall">
                                <img src="img/publicaciones/<?php echo $result["imagenpublicacion"];?>" loading="lazy" alt="">
                            </a>
                        <?php
                    }else{
                        //tipo 2
                        ?>
                            <a href="/photopost/publicacion/publicacion.php?id=<?php echo $result['id'];?>" class="grid-item">
                                <img src="img/publicaciones/<?php echo $result["imagenpublicacion"];?>" loading="lazy" alt="">
                            </a>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>