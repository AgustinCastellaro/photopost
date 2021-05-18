$(document).ready(function(){ 

    /*--  Variables  --*/
    /* URL Actual */
    var URLactual = window.location;

    /* Header */
    var header = document.getElementById("header");

    /* Editar mi perfil */
    var ep_imagen = document.getElementById("ep_imagen");
    
    /* Subir foto */
    var sf_div_imagen = document.getElementById("sf_div_imagen");
    var sf_imagen = document.getElementById("sf_imagen");
    var sf_input = document.getElementById("sf_input");
    var sf_info_img = document.getElementById("sf_info_img");

    /* Publicacion */
    var seguir                      = document.getElementById("seguir");
    var like                        = document.getElementById("like");

    //Modal Login (Cuando no hay una sesion activa)
    var modal_login = document.getElementById("modal_login");
    
    
    /*--  Funciones  --*/
    /* Input textarea */
    //Descripcion Editar perfil
    if(URLactual.pathname == "/photopost/miperfil/editar_perfil.php"){
        var initial = $("#descripcion_editar_perfil").val().length;
        $('#carac_actual_editar_perfil').text(initial + " / 300");

        $("#descripcion_editar_perfil").on('input', function() {
            var limite = 300;
            $("#descripcion_editar_perfil").attr('maxlength', limite);
            initial = $("#descripcion_editar_perfil").val().length - 1;

            if(initial < limite){
                initial++;
            $('#carac_actual_editar_perfil').text(initial + " / 300");
            }
        });
    }

    //Comentario Subir foto
    if(URLactual.pathname == "/photopost/subir_foto/subir_foto.php"){
        var init = $("#comentario_subir_foto").val().length;
        $('#carac_actual_subir_foto').text(init + " / 300");

        $("#comentario_subir_foto").on('input', function() {
            var limit = 300;
            $("#comentario_subir_foto").attr('maxlength', limit);
            init = $("#comentario_subir_foto").val().length - 1;

            if(init < limit){
            init++;
            $('#carac_actual_subir_foto').text(init + " / 300");
            }
        });
    }

    //Comentario Editar publicación
    if(URLactual.pathname == "/photopost/miperfil/editar_publicacion.php"){
        var init = $("#comentario_editar_publicacion").val().length;
        $('#carac_actual_editar_publicacion').text(init + " / 300");

        $("#comentario_editar_publicacion").on('input', function() {
            var limit = 300;
            $("#comentario_editar_publicacion").attr('maxlength', limit);
            init = $("#comentario_editar_publicacion").val().length - 1;

            if(init < limit){
            init++;
            $('#carac_actual_editar_publicacion').text(init + " / 300");
            }
        });
    }


    /* URL cambia color Header */
    if(URLactual.pathname == "/photopost/subir_foto/subir_foto.php" || 
        URLactual.pathname == "/photopost/miperfil/perfil.php" || 
        URLactual.pathname == "/photopost/miperfil/editar_perfil.php"){
        header.style.background = "#1F2733";
    }

});//End ready.



/*--  Funciones  --*/

/* Editar mi perfil */
function readURL_editar_perfil(input){
    if (input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            $(ep_imagen).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/* Subir foto */
function readURL_subir_foto(input){
    if (input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(){
            sf_imagen.src = reader.result;

            //Una vez que se cargue la imagen
            sf_imagen.onload = function(){
                width_img = sf_imagen.naturalWidth;
                height_img = sf_imagen.naturalHeight;

                //Si el ancho es mayor al alto
                if(width_img >= height_img){
                    sf_div_imagen.style.width = "100%";
                    sf_div_imagen.style.height = "220px";
                    
                    sf_input.style.width = "100%";
                    sf_input.style.height = "220px"
                }
                //Si el ancho es menor al alto
                else{
                    sf_div_imagen.style.width = "280px";
                    sf_div_imagen.style.height = "400px";

                    sf_input.style.width = "280px";
                    sf_input.style.height = "400px"
                    
                }
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
    
    sf_div_imagen.style.border = "none";
    sf_imagen.style.display = "flex";
    sf_info_img.style.display = "none";
}

/* Modal login */
function abrir_modal_login(){
    modal_login.style.display = "flex";
    console.log("aaaaa");
}

function cerrar_modal_login(){
    modal_login.style.display = "none";
    $("body").css("overflow", "auto");
}


function seguir_usuario(id){
    console.log(id);
    
    const id_usuario = id
    const action = 'seguirUsuario';

    $.ajax({
        url: '/photopost/includes/ajax_publicacion.php',
        type: 'POST',
        async: true,
        data: {
                action:action, 
                id_usuario:id_usuario
            },
        beforeSend: function(){
        },
        success: function(response){
            console.log(response);
            if(response != "error"){
                console.log("seguido");
            }
        },
    });
}

function like_publicacion(id){
    console.log(id);
}