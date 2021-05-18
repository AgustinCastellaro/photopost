<?php
    if(!empty($_SESSION['active'])){
        $id = $_SESSION['idusuario'];
        $query_usuario = mysqli_query($conection, "SELECT imagenusuario
                                                    FROM usuarios
                                                    WHERE id = '$id' ");
        
        $resultado = mysqli_num_rows($query_usuario);
        if($resultado > 0){
            while($data = mysqli_fetch_array($query_usuario)){
                $imagenUsuario = $data['imagenusuario'];
            }
        }
    }
?>

<nav>
    <a href="/photopost/index.php" class="logo">
        <img src="/photopost/img/logo/logo_blanco.svg" alt="">
    </a>
    
    <label for="btn" class="iconMenu">
        <i class="fas fa-bars"></i>
    </label>
    <input type="checkbox" id="btn">

    <ul>
        <li><a href="/photopost/index.php">Inicio</a></li>
        <li><a href="#">Descubrir</a></li>
        <?php
            if(!empty($_SESSION['active'])){
        ?>
                <li>
                    <a href="/photopost/subir_foto/subir_foto.php" class="subirFoto">Subir una foto</a>
                </li>
        <?php
            }
        ?>
        <?php
            if(!empty($_SESSION['active'])){
        ?>
                <li>
                    <label for="btn-1" class="show">
                        <img src="/photopost/img/usuarios/<?php echo $imagenUsuario;?>" alt="">
                        <p>Perfil</p>
                    </label>
                    <a href="#" class="img_perfil">Perfil</a>
                    <input type="checkbox" id="btn-1">
                    <ul>
                        <li><a href="/photopost/miperfil/perfil.php">Mi Perfil</a></li>
                        <li><a href="/photopost/miperfil/perfil.php">Mis Publicaciones</a></li>
                        <li><a href="/photopost/includes/salir.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
        <?php
            }
            if(empty($_SESSION['active'])){
        ?>
                <li>
                    <a href="login/login.php" class="login">Unete</a>
                </li>
        <?php
            }
        ?>
    </ul>
</nav>

