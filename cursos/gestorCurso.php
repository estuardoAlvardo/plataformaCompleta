<?php 
session_start();
//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../index.html');
}

require("../conection/conexion.php");


$_SESSION['idUsuario'];


//fecha y hora actual
date_default_timezone_set('America/Guatemala');

$fecha_actual=date("Y-m-d");
$hora_actual=date('Y-m-d H:i:s',time());

//variables de niveles


//convertir fechas mas amigables y en espanol
      function fechaCastellano ($fecha) {



            $fecha = substr($fecha, 0, 10);
            $numeroDia = date('d', strtotime($fecha));
            $dia = date('l', strtotime($fecha));
            $mes = date('F', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));
           




            $dias_ES = array("Lun", "Mart", "Miér", "Jue", "Vier", "Sáb", "Dom");
            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

              return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;


}



  $queryNew1 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasPublicacion4 = $dbConn->prepare($queryNew1);
  $temasPublicacion4->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasPublicacion4->execute();
  $hayTemas4=$temasPublicacion4->rowCount();




  $q2 = ("SELECT * FROM curso where idCurso=:idCurso");
  $datosCurso = $dbConn->prepare($q2);
  $datosCurso->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $datosCurso->execute();










       while ($datosPrincipales=$datosCurso->fetch(PDO::FETCH_ASSOC)){
        $_SESSION['portada']=$datosPrincipales['portada'];

                  //verificamos cuantos alumnos estan en el curso
          $queryAlumnos = ("SELECT * FROM usuarios where grado=:grado and seccion=:seccion ");
          $buscarAlumnos = $dbConn->prepare($queryAlumnos);
          $buscarAlumnos->bindParam(':grado',$datosPrincipales['grado'], PDO::PARAM_INT);
          $buscarAlumnos->bindParam(':seccion',$datosPrincipales['seccion'], PDO::PARAM_INT);
          $buscarAlumnos->execute();
          $cantidadAlumnos=$buscarAlumnos->rowCount();

       }

  $qu1 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
                      $temasPublicacion = $dbConn->prepare($qu1);
                      $temasPublicacion->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
                      $temasPublicacion->execute();
                      $hayTemas=$temasPublicacion->rowCount();

 $qu5 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
                      $temasPublicacion2 = $dbConn->prepare($qu5);
                      $temasPublicacion2->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
                      $temasPublicacion2->execute();
                      $hayTemas2=$temasPublicacion2->rowCount();

 ?>



<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Mis plan lector</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link href="../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Ubuntu', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>

    <!-- librerias para el funcionamiento del calendario -->
     <!-- JQUERY FUNCIONAL -->
    <script src='../js/jquery.js'></script>
    <script src="../pushnotification/push.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="txt-fuente">

  
<!--NAVEGACION CONTENIDO FIJO -->
<?php include '../static/nav.php'; $nivell=1; directorioNivelesNav($nivell); ?>
<!-- //NAVEGACION CONTENIDO FIJO -->

<!-- LATERAL IZQUIERDO CONTENIDO FIJO -->
 <?php include '../static/lat-izquierdo.php';  $nivel=1; directoriosNiveles($nivel); ?>
<!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->

<!--CENTRANDO CONTENIDO ROL 1 -->
 <style type="text/css">


  /*estilos para push notificacion inicio*/
#pageMessages {
  position: fixed;
  bottom: 15px;
  right: 15px;
  width: 30%;
  z-index: 100000000;
}



.alert .close {
  position: absolute;
  top: 5px;
  right: 5px;
  font-size: 1em;
}

.alert .glyphicon {
  margin-right:.5em;
}

.alert{
  background-color: #2ecc71;
  border:1px solid #2ecc71;
  color: white;
  border-radius: 10px;
  position: relative;
  transition: ease 3s all;
}
  /*estilos para push notificacion fin*/
   
.cajaCards{
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  border-radius: 5px;
  height: 150px; 
  margin-bottom: 20px;
  padding-top: 10px;
  color: black;
                    }

   .cajaCards:hover{
box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
background: #642B73;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #C6426E, #642B73);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #C6426E, #642B73); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
color: white;
font-size: bold;
padding-top: 10px;

}
                 


/* card material design style*/
.card {
  display: inline-block;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  margin: 20px;
  position: relative;
  margin-bottom: 50px;
  transition: all .2s ease-in-out;
  text-decoration: none;
  color: black; 
  min-height: 250px;
  border-radius: 15px;
}

.card:hover {
  /*box-shadow: 0 5px 22px 0 rgba(0,0,0,.25);*/
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
  
}

.image {
  height: 150px;
  opacity: .7;
  overflow: hidden;
  transition: all .2s ease-in-out;
   background: -webkit-linear-gradient(to right, #C6426E, #642B73);  /* Chrome 10-25, Safari 5.1-6 */
   background: linear-gradient(to right, #C6426E, #642B73); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}

.image:hover,
.card:hover .image {
  height: 150px;
  opacity: 1;
}

.text {
  background: #FFF;
  padding: 20px;
  min-height: 200px;
}

.text p {
  margin-bottom: 0px;
}

.fab {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  position: absolute;
  margin-top: -50px;
  right: 20px;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, .3);
  color: #fff;
  font-size: 48px;
  line-height: 48px;
  text-align: center;
  background: #0066A2;
  -webkit-transition: -webkit-transform .2s ease-in-out;
  transition: transform .2s ease-in-out;
}

.fab:hover {
  background: #549D3C;
  cursor: pointer;
  -ms-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
}


/*timeline lecturas diarias*/


#timeline-wrap{
  margin:10% 20%;
  top:10;
  position:relative;
 
}

#timeline{
  height:2px;
  width: 130%;
  background-color:#2980b9;
  position:relative;
  margin-left: -10px;
  margin-top: -10px;
 
}

 .marker{
   z-index:1000;
   color: #fff;
  width: 35px;
  height:35px;
  line-height: 50px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  margin-left: -40px;
  background-color: #999999;
  border-radius: 50%;

        }

 .marker p {
  margin-top: -5px;

 }

 .marker:hover{
   -moz-transform: scale(1.2);
-webkit-transform: scale(1.2);
-o-transform: scale(1.2);
-ms-transform: scale(1.2);
transform: scale(1.2);
   
   -webkit-transition: all 300ms ease;
-moz-transition: all 300ms ease;
-ms-transition: all 300ms ease;
-o-transition: all 300ms ease;
transition: all 300ms ease;
 }


.timeline-icon.one {
    background-color:<?php echo $l;?> !important;
}

.timeline-icon.two {
    background-color:<?php echo $m;?>!important;
}

.timeline-icon.three{
    background-color: <?php echo $x;?> !important;
}

.timeline-icon.four {
    background-color: <?php echo $j;?>!important;
}

.timeline-icon.five {
    background-color: <?php echo $v;?> !important;
}



.mfirst{
     top:-25px;
}

.m2{
     top:-25px;
      left:32.5%
}

.m3{
     top:-25px;
    left:66%
}


.mlast{
     top:-25px;
    left:100%
}

.timeline-panel {
  margin-top: 20%;
  width: 500px;
  height: 200px;
  background-color: #cbd0df;
  border-radius:2px;
  position:relative;
  text-align:left;
  padding:10px;
  font-size:20px;
  font-weight:bold;
  line-height:20px;
  float:left;
  display: none;
}

.timeline-panel:after {
  content:'';
  position:absolute;
  margin-top: -12%;
  left:10%;
  width:0;
  height:0;
  border:12px solid transparent;
  border-bottom: 15px solid #cbd0df;
}


/*chip material*/
.md-chip {
  display: inline-block;
  border-radius: 42px;
  padding: 0;
  height: 42px;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -webkit-transition: .2s ease-out;
          transition: .2s ease-out;
}

.md-chip:hover {
  box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
  cursor: pointer;
}

.md-chip-img .md-chip-span {
  display: block;
  height: 42px;
}

.md-chip-img {
  border-radius: 50%;
  width: 42px;
  height: 42px;
  overflow: hidden;
  float: left;
  box-shadow: 2px 0px rgba(0,0,0,.3);
}
.md-chip-text {
  display: inline-block;
  font-weight: 400;
  font-size: 16px;
  height: 42px;
  float: left;
  padding: 12px 18px 12px 10px;
  color: rgba(255, 255, 255, .87);
}
.pink {
  background-color: #E91E63;
}

.indigo {
  background-color: #3f51b5;
}
.md-chip {
  margin: 0 20px 20px 0px;
}


/* ondas*/
#state {
  margin:auto;
  width:100px;
  display:block;
  height:100px;
  position:relative;
}
.gps_ring {
    border: 2px solid #f48fb1;
    -webkit-border-radius: 50%;
    height: 18px;
    width: 18px;
    position: absolute;
    left:-26px;
    top:13px;
    -webkit-animation: pulsate 1s ease-out;
    -webkit-animation-iteration-count: infinite; 
    opacity: 0.0;
}
.gps_ring:before {
    content:"";
    display:block;
    border: 2px solid #f48fb1;
    -webkit-border-radius: 50%;
    height: 30px;
    width: 30px;
    position: absolute;
    left:-8px;
    top:-8px;
    -webkit-animation: pulsate 1s ease-out;
    -webkit-animation-iteration-count: infinite; 
    -webkit-animation-delay: 0.1s;
    opacity: 0.0;
}
.gps_ring:after {
    content:"";
    display:block;
    border:2px solid #f48fb1;
    -webkit-border-radius: 50%;
    height: 50px;
    width: 50px;
    position: absolute;
    left:-18px;
    top:-18px;
    -webkit-animation: pulsate 1s ease-out;
    -webkit-animation-iteration-count: infinite; 
    -webkit-animation-delay: 0.3s;
    opacity: 0.0;
}
@-webkit-keyframes pulsate {
    0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
    50% {opacity: 2.0;}
    100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
}




 .btnGrado{
                       box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                       transition: all 0.3s cubic-bezier(.25,.8,.25,1);
                       height:30px;background-color:#2980b9;
                       text-decoration: none;
                       color: white;
                       background-color: #273c75;
                       border:1px solid #273c75;
                       border-radius: 10px;
                       padding:3px;
                    }
                    .btnGrado:hover{
                      background-color:#273c75;
                      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
                      cursor: pointer;
                      text-decoration: none;
                       color: white;
                       border:1px solid #273c75;
                    }

                    .btnGrado:focus{
                      color: white;
                    }

          


 </style>
<script type="text/javascript">
  //$(".timeline-panel").hide(0);

$("i").click(function() {
      $('.timeline-panel').show(0);
});
</script>



  <div class="componenteNotificacion" style="">
      <style type="text/css">
           .swal-text {
  background: linear-gradient(to right, #C6426E, #642B73);
  padding: 17px;
  display: block;
  margin: 22px;
  text-align: center;
  color: white;
  text-align: center;
  border-radius: 5px;
   box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}
.swal-icon img{
  width: 200px;
  height: 200px;
}


/*estilos Navs Cursos*/

.nav-tabs{
  color: black;
  font-weight: bold;

}

.nav-tabs a{
  color: black;
  font-weight: bold;


}

  .nav-tabs .active{
  font-weight: bold;
  font-size: 18pt;

}

.portada{
  
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
   height: 100%;
   width: 100% ;
   text-align: center;
   border-radius: 15px 15px 15px 15px;
   padding: 0px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);

 
}


.titleCourse{
  color: white;
  font-weight: bold;
  text-align: left;
  padding-left: 20px;
}

.btnEditarPortada{
  text-align: right;
  padding-top: 5px;
}


.vibrar:hover {
  -webkit-animation: tiembla 0.2s 1;
  -moz-animation: tiembla 0.2s 1;
  -o-animation: tiembla 0.2s 1;
 -ms-animation: tiembla 0.2s 1;
 cursor:pointer;
}

@-webkit-keyframes tiembla {
  0%  { -webkit-transform:rotateZ(-5deg); }
  50% { -webkit-transform:rotateZ( 0deg) scale(1.4); }
  100%{ -webkit-transform:rotateZ( 5deg);
}
/*menu Dropdown publicacion*/

.dropdown .dropdown-menu 
      </style>

       <input type="text" name="nombreUsuario" id="nombreUsuarioN" value="<?php echo $_SESSION['nombre']; ?>" style="display: none;">
       <input type="text" name="nombreUsuario" id="semanaN" value="<?php echo $semanaModificar; ?>"  style="display: none;">     
       
       <script type="text/javascript">
        /*
         var nombreUsuario=$("#nombreUsuarioN").val();
         var semana=$("#semanaN").val();

         swal({
        title: "Felicidades "+nombreUsuario+"!!",
        text: "Llegamos a la semana número "+semana+" leyendo sin interrupción, juntos estamos desarrollando tu hábito lector, es momento que tomes un descanso, encontraras nuevas lecturas a partir de lunes 13 de abril.  Puedes seguir leyendo y practicando las lecturas anteriores.",
        imageClass: "contact-form-image",
        icon: "../img/task/wave-2.gif",
        button: "Muy bien",
        timer: 9000
        
      });
  */
       </script>

       </div>






 <div class="col-md-8 col-xs-8 pag-center">
         <div class="col-md-12" style="margin-bottom: 50px;">
              <h3 class="text-center">Administrar curso</h3>
         </div>

         <div class="salida"></div>
          <div id="pageMessages" ></div>
           

<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active" style=""><a href="#tab1" data-toggle="tab" onclick="activarPrimerPend(1);">curso</a></li>
    <li><a href="#tab2" data-toggle="tab" onclick="activarPrimerPend(2);">Tareas Asignadas</a></li>
    <li><a href="#tab3" id="pruebaEnlink" data-toggle="tab" onclick="activarPrimerPend(3)">Pruebas en linea</a></li>
    <li><a href="#tab4" data-toggle="tab" onclick="activarPrimerPend(4);" >Reportes de curso</a></li>

  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1" style="margin-top: 50px;">

    <div class="portada col-md-12" style="height: 200px;  background: url(<?php echo $_SESSION['uriLocal'].$_SESSION['portada']; ?>);">

      <div class="row">
      <div class="col-md-6 titleCourse">
        <h5 style="font-size: 20pt;"><?php echo @$_GET['course']; ?></h5>
      </div>
      <div class="col-md-6 btnEditarPortada" title="Cambiar Portada" >
        <img class="vibrar" src="https://image.flaticon.com/icons/svg/2489/2489796.svg" width="50" height="50" onclick="cambiarPortada();">
        <p style="color: white; padding-right: 7px;">Editar</p>

        <form id="actualizarPortada" enctype="multipart/form-data">
        <input type="file" id="btnInputFile" name="file" accept="image/*" style="display: none;">
        <input type="text"  name="idCurso2" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">

        <input type="text" name="eventoEjecutar" value="3" style="display: none;">
        </form>
      </div>  
      </div>

      <h5></h5>
      
    </div>

    <div class="row">
      <div class="col-md-2">
         <a href="#" class="btnGrado btn btn-lg" data-toggle="modal" data-target="#exampleModalLong" style="margin-top: 20px;">Crear Tema <span class="glyphicon glyphicon-plus"></span></a>
       </div>

      <div class="col-md-2">
         <a href="#" class="btnGrado btn btn-lg" data-toggle="modal" data-target="#modal2" style="margin-top: 20px;">Subir material de apoyo <span class="glyphicon glyphicon-pencil"></span></a>
       </div>



<input type="text" id="idCursoEnviar" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;" >
<input type="text" id="nombreCursoEnviar" value="<?php echo $_GET['course']; ?>"  style="display: none;">
<input type="text" id="profesorEnviar" value="<?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?>"  style="display: none;">

<script language="javascript" type="text/javascript">
var idCurso = document.getElementById('idCursoEnviar');
var nombreCurso = document.getElementById('nombreCursoEnviar');
var profesor = document.getElementById('profesorEnviar');



</script>

<div class="dropdown col-md-4">
  <button class="btnGrado btn dropdown-toggle" style="margin-top: 20px; margin-left:100px;" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-plus"></span> Asignar tarea o prueba en linea
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li> <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal3">Crear una tarea</a></li>
    <li><a class="dropdown-item"  href="#" data-toggle="modal" data-target="#pruebaEnLinea">Crear una prueba en linea</a></li>
  </ul>
</div>         





      
    </div>


<style>
 
/* Style the tab --------------------------------- tab 1 */
.tab {
  float: right;
  background-color: #f1f1f1;
  min-width: 10%;
  min-height: 200px;
  border-radius: 10px;
  margin-top: 50px;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 10px 15px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 14px;
  border-radius: 5px;


}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #273c75;
  color: white;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color:#273c75;
  color: white;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  width: 85%;
  border-left: none;
  min-height: 300px;
  margin-top: 50px;
}














/*estilos publicaciones*/

.publicacionCompleta{
  padding: 0px;    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border-radius: 5px;
  background-color: #f1f1f1;
}

.fechaPublicacion{
  text-align: right; font-weight: bold; color: #2863eb; font-size: 10pt; 
}

.cuerpoPublicacion{
   padding:10px; word-break: break-all;
}
.btnDescarga{
margin-top: 20px; background-color: #e67e22; border:1px solid #e67e22;
}

.btnDescarga:hover{
margin-top: 20px; background-color: #e67e22; border:1px solid #e67e22;
}

.boxCard{
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.fileDowload > img{
  width: 50px;
  height: 50px;

}


/* desactivar button*/
.desactivarButton{
  background-color: red;
  color: white;
  border:1px solid red;
  cursor: no-drop;
}

.desactivarButton:hover{
   background-color: red;
  color: white;
  border:1px solid red;
    cursor: no-drop;


}



/* estilos chip*/
.chip{
    display: inline-flex;
    flex-direction: row;
    background-color: #ffffff;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    font-color: #333333;
    font-family:"Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
}
.chip-head{
    display: flex;
    position: relative;
    overflow: hidden;
    background-color: #32C5D2;
    font-size: 1.25rem;
    flex-shrink: 0;
    align-items: center;
    user-select: none;
    border-radius: 50%;
    justify-content: center;
    width: 36px;
    color: #fff;
    height: 36px;
    font-size: 20px;
    margin-right: -4px;
}
.chip-content{
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
    font-size: 9pt;
}
.chip-svg{
        color: #999999;
    cursor: pointer;
    height: auto;
    margin: 4px 4px 0 -8px;
  fill: currentColor;
    width: 1em;
    height: 1em;
    display: inline-block;
    font-size: 24px;
    transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    user-select: none;
    flex-shrink: 0;
}
.chip-svg:hover{
    color: #666666;
}
</style>



<div class="tab" style="min-height: 500px;">
  <h5>Temas</h5>
  
<?php
  $q1 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $buscarTemas = $dbConn->prepare($q1);
  $buscarTemas->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $buscarTemas->execute();
       
     while ($datos=$buscarTemas->fetch(PDO::FETCH_ASSOC)){
        @$iteracion+=1;

        if($iteracion==1){

    

   ?>
  <button class="tablinks active"  onclick="openCity(event, '<?php echo $datos['idTema']; ?>')" id="defaultOpen1"><?php echo $datos['nombreTema']; ?></button>

<?php   }else{
            

     ?>
       <button class="tablinks"  onclick="openCity(event, '<?php echo $datos['idTema']; ?>')" ><?php echo $datos['nombreTema']; ?></button>
    <?php }} ?>   
</div>


<?php
 
 if($hayTemas==0){


 ?>
 <div class="col-md-12" style="position: absolute; margin-top: 20%; margin-left: -10%;">
    <img src="../img/empty.svg" style="width: 200px; height: 100px; text-align: center;">
    <h4 style="font-weight: bold; color: #2863eb">¡¡Aún no hay Temas!!</h4>
  </div>

<?php
}

$q2 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $buscarTema1 = $dbConn->prepare($q2);
  $buscarTema1->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $buscarTema1->execute();


       
     while ($datos1=$buscarTema1->fetch(PDO::FETCH_ASSOC)){



$q4 = ("SELECT * FROM publicacionCurso where idCurso=:idCurso and idTema=:idTema order by  fechaPublicacion desc");
  $buscarPubliTema = $dbConn->prepare($q4);
  $buscarPubliTema->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $buscarPubliTema->bindParam(':idTema',$datos1['idTema'], PDO::PARAM_INT);
  $buscarPubliTema->execute();
  $hayPublicacionTema=$buscarPubliTema->rowCount();

if($hayPublicacionTema==0){


 ?>

<div id="<?php echo $datos1['idTema']; ?>" class="tabcontent" style="position: absolute;" >

  <h3><?php echo $datos1['nombreTema']; ?></h3>

    <div class="col-md-12" style=";">
    <img src="../img/empty.svg" style="width: 200px; height: 100px; text-align: center;">
    <h4 style="font-weight: bold; color: #2863eb">¡¡Aún no hay contenido!!</h4>
  </div>
</div><br><br>



<?php }else{ ?>
<div id="<?php echo $datos1['idTema']; ?>" class="tabcontent" >

  <h3><?php echo $datos1['nombreTema']; ?></h3>
<?php 


  while ($publicacionT=$buscarPubliTema->fetch(PDO::FETCH_ASSOC)){

$fechaPublicacion=fechaCastellano($publicacionT['fechaPublicacion']);
$horaEntregaTarea= substr($publicacionT['fechaPublicacion'],11,20);
 ?>
<div class="publicacionCompleta">
<div class="PublicacionTema col-md-12">
  <div class="chip boxCard" style="float: right; margin-bottom: 20px; margin-top: 5px;">
  <div class="chip-head"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
  <div class="chip-content"><?php echo 'Publicado: '. $fechaPublicacion.' '.$horaEntregaTarea; ?></div>
  <div class="chip-close">
      <svg class="chip-svg" focusable="false" viewBox="0 0 24 24" aria-hidden="true"></svg>
  
  </div>
</div>
</div>

<div class="cuerpoPublicacion">
 <?php echo $publicacionT['textPublicacion']; ?>

<?php 

//verificamos si hay url y mostramos el video
  if(!empty($publicacionT['urlRecurso'])){

     $dirPat = pathinfo($publicacionT['urlRecurso'], PATHINFO_BASENAME);
 ?>
<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $dirPat; ?>" style="margin-top: 20px;" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
 

<?php } ?>


 
   
  <div class="row" style="padding: 10px;">
    
    <p style="text-align: left; font-weight: bold; color: #2863eb;">Archivos Adjuntos</p>


    <?php


  $q5 = ("SELECT * FROM filesPublicacion where idPublicacion=:idPublicacion");
  $buscarFicherosP = $dbConn->prepare($q5);
  $buscarFicherosP->bindParam(':idPublicacion',$publicacionT['idPublicacion'], PDO::PARAM_INT);
  $buscarFicherosP->execute();
  $hayFicherosP=$buscarFicherosP->rowCount();



  if($hayFicherosP==0){

     ?>

    <div class="col-md-5 fileDowload">
      <p style="font-weight: bold; color:black;">No hay archivos adjuntos!</p>
        </div>
      <div class="col-md-1 "></div>



    <?php }else{ 


      while ($ficherosP=$buscarFicherosP->fetch(PDO::FETCH_ASSOC)){


      //codigo para colocar imagenes al archivo
      $extension = pathinfo($ficherosP['rutaFile'], PATHINFO_EXTENSION);
      $nombreFichero=pathinfo($ficherosP['rutaFile'], PATHINFO_BASENAME);

      $imagen=$extension.'.png';
      $imagenFicheros='../img/files2/'.$imagen;

      if($extension=='png' or $extension=='jpg' or $extension=='svg' or $extension=='jpeg'){
        $rutaMostrar='../'.$ficherosP['rutaFile'];

      ?> 
      <div class="col-md-1 fileDowload">
      <a href="#" class="" data-toggle="modal" data-target="<?php echo '#img'.$ficherosP['idRegistro']; ?>"><img src="<?php echo $rutaMostrar; ?>"   class="vibrar"  style="margin-left: 20px; width: 50px; height: 50px;"  ></a>
      <a class="btnGrado btn btn-xs btnDescarga" href="<?php echo '../'.$ficherosP['rutaFile']; ?>" target="_blank" download="<?php echo $nombreFichero; ?>" >Descargar <span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
      <div class="col-md-1 "></div>


           <div class="modal fade" id="<?php echo 'img'.$ficherosP['idRegistro']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Vista Previa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <img src="<?php echo $rutaMostrar; ?>"   class="vibrar"  style=" max-width:400px; min-height: 300px;"  >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>


      <?php }elseif($extension!='png' or $extension!='jpg' or $extension!='svg' or $extension!='jpeg'){ ?>



      <div class="col-md-1 fileDowload">
      <img src="<?php echo $imagenFicheros; ?>"  class="vibrar"  style="margin-left: 20px;">
       <a class="btnGrado btn btn-xs btnDescarga" href="<?php echo '../'.$ficherosP['rutaFile']; ?>" target="_blank" download="<?php echo $nombreFichero; ?>" >Descargar <span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
      <div class="col-md-1 "></div>




     


    <?php } } } ?>  

  </div>

</div>

</div><br><br>
<?php } ?>


</div>
<?php } } ?>

    </div>



<div class="tab-pane" id="tab2" style="min-height: 500px;"><br>

<div class="tab">
  <h4>Temas</h4>

<?php
$buscarTemas1 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTarea = $dbConn->prepare($buscarTemas1);
  $temasTarea->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTarea->execute();
     
  while ($temasTareasDatos=$temasTarea->fetch(PDO::FETCH_ASSOC)){
      @$k+=1;

      if($k==1){
        $visualizar2='defaultOpen2';
        $activo2='active';


 ?>

  <button class="tablinks active" onclick="openCity(event, <?php echo '\'new1'.$temasTareasDatos['idTema'].'\''; ?>)" id="defaultOpen2"><?php echo $temasTareasDatos['nombreTema']; ?></button>
<?php }else{ ?>

<button class="tablinks" onclick="openCity(event, <?php echo '\'new1'.$temasTareasDatos['idTema'].'\''; ?>)" id=" "><?php echo $temasTareasDatos['nombreTema']; ?></button>

 <?php }} ?> 
</div>


<?php 

$buscarTemas2 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTarea2 = $dbConn->prepare($buscarTemas2);
  $temasTarea2->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTarea2->execute();
     
  while ($temasTareasDatos2=$temasTarea2->fetch(PDO::FETCH_ASSOC)){

$queryTarea = ("SELECT * FROM tareaCurso where idCurso=:idCurso and idTema=:idTema order by  fechaEntrega asc");
  $buscarTareas = $dbConn->prepare($queryTarea);
  $buscarTareas->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $buscarTareas->bindParam(':idTema',$temasTareasDatos2['idTema'], PDO::PARAM_INT);
  $buscarTareas->execute();
  $hayTareasTema=$buscarTareas->rowCount();


?>
<div id="<?php echo 'new1'.$temasTareasDatos2['idTema']; ?>" class="tabcontent" >
  <h3><?php echo $temasTareasDatos2['nombreTema']; ?></h3>
  
<?php 
if($hayTareasTema==0){

?>

<div class="col-md-12" style="position: absolute; margin-top: 10px; margin-left: -10%;">
    <img src="../img/empty.svg" style="width: 200px; height: 100px; text-align: center;">
    <h4 style="font-weight: bold; color: #2863eb">¡¡Aún no hay tareas asignadas!!</h4>
  </div>



<?php }else{

while ($datosTarea2=$buscarTareas->fetch(PDO::FETCH_ASSOC)){

    //funcion para fechas mas legibles
$fechaEntrega=fechaCastellano($datosTarea2['fechaEntrega']);
$horaEntregaTarea= substr($datosTarea2['fechaEntrega'],11,20);


    ///buscar cuantas tareas hay recibidas por idTarea
  $query10 = ("SELECT * FROM cursoGestorTarea where idTarea=:idTarea");
  $entregasTareasR = $dbConn->prepare($query10);
  $entregasTareasR->bindParam(':idTarea',$datosTarea2['idTarea'], PDO::PARAM_INT);
  $entregasTareasR->execute();
  $conteoEntregas=$entregasTareasR->rowCount();

  while ($datosEntregaR=$entregasTareasR->fetch(PDO::FETCH_ASSOC)){

    if($datosEntregaR['punteo']!=null || !empty($datosEntregaR['punteo'])){

      @$contadorCalificado+=1;

    }else{
      @$contadorCalificado+=0;
    }
  }


 ?>

<br>
<div class="col-md-12">
<a href="<?php echo 'calificadorDocente.php?tokenTar='.$datosTarea2['idTarea']; ?>" style="text-decoration: none; color: black"><div class="row boxCard" style=" text-align: left; border-radius: 5px;">
  <div class="col-md-7" style="">
    <h4 style="font-weight: bold;"><?php echo  $datosTarea2['titulo']; ?></h4>
    <div class="chip boxCard" style="background-color: #f1f1f1;">
  <div class="chip-head"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
  <div class="chip-content"><?php echo 'Entrega: '.$fechaEntrega.' '.$horaEntregaTarea; ?></div>
  <div class="chip-close">
      <svg class="chip-svg" focusable="false" viewBox="0 0 24 24" aria-hidden="true"></svg>
  
  </div>
</div>

  </div><br>
    <div class="col-md-5">
    <div class="row">
      <div class="col-md-4">
        <h5 style="text-align: center;">Recibidas:<span style="font-weight: bold; font-size: 15pt;"> <?php echo $conteoEntregas; ?> / <?php echo $cantidadAlumnos; ?></span></h5>
        
      </div>
      <div class="col-md-3">
        <h5 style="text-align: center;">Tareas Calificadas: <span style="font-weight: bold; font-size: 15pt;"><?php echo @$contadorCalificado; ?></span></h5>
        
      </div>


      <div class="col-md-5" style="text-align: right; margin-top:10px; display: block">
       <h4>punteo: <?php echo $datosTarea2['punteo']; ?></h4>
      </div>
      
    </div>
    
  </div>
  
</div></a>

<br>
</div>



<?php  } } ?>
</div>




<?php } ?>




</div>






<div class="tab-pane" id="tab3">
           <div class="tab">
  <h4>Temas</h4>

<?php
$buscarTemasTab3 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTab3 = $dbConn->prepare($buscarTemasTab3);
  $temasTab3->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTab3->execute();
     
  while ($temasTabDatos=$temasTab3->fetch(PDO::FETCH_ASSOC)){
      @$l+=1;

      if($l==1){
        $visualizar3='defaultOpen3';
        $activo3='active';


 ?>

  <button class="tablinks active" onclick="openCity(event, <?php echo '\'tab3'.$temasTabDatos['idTema'].'\''; ?>)" id="defaultOpen3"><?php echo $temasTabDatos['nombreTema']; ?></button>
<?php }else{ ?>

<button class="tablinks" onclick="openCity(event, <?php echo '\'tab3'.$temasTabDatos['idTema'].'\''; ?>)" id=" "><?php echo $temasTabDatos['nombreTema']; ?></button>

 <?php }} ?> 
</div>

<?php 

$buscarTab3Otro = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTab32 = $dbConn->prepare($buscarTab3Otro);
  $temasTab32->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTab32->execute();
     
  while ($temasPruebasTab3=$temasTab32->fetch(PDO::FETCH_ASSOC)){

  $buscarExamenes = ("SELECT * FROM examenesCurso where idTema=:idTema and idCurso=:idCurso");
  $examenesCurso = $dbConn->prepare($buscarExamenes);
  $examenesCurso->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $examenesCurso->bindParam(':idTema',$temasPruebasTab3['idTema'], PDO::PARAM_INT);
  $examenesCurso->execute();
  $hayExamenes=$examenesCurso->rowCount();


?>
<div id="<?php echo 'tab3'.$temasPruebasTab3['idTema']; ?>" class="tabcontent" >
  <h3><?php echo $temasPruebasTab3['nombreTema']; ?></h3>
  
<?php 
if($hayExamenes==0){

?>

<div class="col-md-12" style="position: absolute; margin-top: 10px; margin-left: -10%;">
    <img src="../img/empty.svg" style="width: 200px; height: 100px; text-align: center;">
    <h4 style="font-weight: bold; color: #2863eb">¡¡Aún no hay pruebas asignadas!!</h4>
  </div>



<?php }else{ 

  while ($datosExamenes=$examenesCurso->fetch(PDO::FETCH_ASSOC)){

      $buscarOpcionMultiple = ("SELECT * FROM cuestionarioOpcionMultiple where idExamenCurso=:idExamen");
  $preguntasOpcionMultiple = $dbConn->prepare($buscarOpcionMultiple);
  $preguntasOpcionMultiple->bindParam(':idExamen',$datosExamenes['idRegistro'], PDO::PARAM_INT);
  $preguntasOpcionMultiple->execute();
  $conteoPreguntas=$preguntasOpcionMultiple->rowCount();


    //buscar itemEmparejamiento
   $buscarEmparejamiento = ("SELECT * FROM cuestionarioEmparejamiento where idExamen=:idExamen");
  $preguntasEmparejamiento = $dbConn->prepare($buscarEmparejamiento);
  $preguntasEmparejamiento->bindParam(':idExamen',$datosExamenes['idRegistro'], PDO::PARAM_INT);
  $preguntasEmparejamiento->execute();
  $conteoEmparejamiento=$preguntasEmparejamiento->rowCount();

    //buscar itemRespuestaCorta

  $buscarRespuestaCorta = ("SELECT * FROM cuestionarioRespuestaCorta where idExamen=:idExamen");
  $preguntasRespuestaCorta = $dbConn->prepare($buscarRespuestaCorta);
  $preguntasRespuestaCorta->bindParam(':idExamen',$datosExamenes['idRegistro'], PDO::PARAM_INT);
  $preguntasRespuestaCorta->execute();
  $conteoRespuestaCorta=$preguntasRespuestaCorta->rowCount();

  $cantidadPreguntas= $conteoPreguntas+$conteoEmparejamiento+$conteoRespuestaCorta;


  ?>

<br>

<div class="col-md-12">
<a href="<?php echo 'generadorPruebas.php?tokenQ='.$datosExamenes['idRegistro'].'&tokenCourse='.$_GET['tokenCourse']; ?>&course=<?php echo $_GET['course']; ?>" style="text-decoration: none; color: black"><div class="row boxCard" style=" text-align: left; border-radius: 5px;">
  <div class="col-md-7" style="">
    <h4 style="font-weight: bold;"><?php echo $datosExamenes['titulo']; ?></h4>
    <div class="chip boxCard" style="background-color: #f1f1f1;">
  <div class="chip-head"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
  <div class="chip-content">Fecha Limite<?php echo $datosExamenes['fechaRegistro']; ?></div>
  <div class="chip-close">
      <svg class="chip-svg" focusable="false" viewBox="0 0 24 24" aria-hidden="true"></svg>
  </div>
</div>

  </div><br>
    <div class="col-md-5">
    <div class="row">
      <div class="col-md-3">
        <h5 style="text-align: center;">Cantidad Preguntas:<br><span style="font-weight: bold; font-size: 18pt;"><?php echo $cantidadPreguntas; ?></span></h5>
        
      </div>
      <div class="col-md-3">
        <h5 style="text-align: center;">Examenes Realizados: <span style="font-weight: bold; font-size: 18pt;">1</span></h5>
        
      </div>

      <div class="col-md-6" style="text-align: right; margin-top:10px; display: none">
        <img src="../img/enviado1.png" style="width: 60px; height: 60px;">
        
      </div>

      <div class="col-md-6" style="text-align: right; margin-top:10px; display: block">
       <h4>punteo: <?php echo $datosExamenes['punteo']; ?> </h4>
      </div>
      
    </div>
    
  </div>
  
</div></a>

<br>
</div>


<?php }  } ?>
</div>



<?php } ?>




    </div>




       <div class="tab-pane" id="tab4">
        <div class="tab">
        <h4>Temas</h4>

       <?php
$buscarTemasTab4 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTab4 = $dbConn->prepare($buscarTemasTab4);
  $temasTab4->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTab4->execute();
     
  while ($datosTemaTab4=$temasTab4->fetch(PDO::FETCH_ASSOC)){
      @$l+=1;

      if($l==1){
        $visualizar4='defaultOpen4';
        $activo3='active';


 ?>

  <button class="tablinks active" onclick="openCity(event, <?php echo '\'tab4'.$datosTemaTab4['idTema'].'\''; ?>)" id="defaultOpen4"><?php echo $datosTemaTab4['nombreTema']; ?></button>
<?php }else{ ?>

<button class="tablinks" onclick="openCity(event, <?php echo '\'tab4'.$datosTemaTab4['idTema'].'\''; ?>)" id=" "><?php echo $datosTemaTab4['nombreTema']; ?></button>

 <?php }} ?> 

</div>

<?php 

$buscarTab4Otro = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasTab42 = $dbConn->prepare($buscarTab4Otro);
  $temasTab42->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasTab42->execute();
     
  while ($temasPruebasTab4=$temasTab42->fetch(PDO::FETCH_ASSOC)){

  $buscarExamenes = ("SELECT * FROM examenesCurso where idTema=:idTema and idCurso=:idCurso");
  $examenesCurso = $dbConn->prepare($buscarExamenes);
  $examenesCurso->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $examenesCurso->bindParam(':idTema',$temasPruebasTab4['idTema'], PDO::PARAM_INT);
  $examenesCurso->execute();
  $hayExamenes=$examenesCurso->rowCount();


?>
<div id="<?php echo 'tab4'.$temasPruebasTab4['idTema']; ?>" class="tabcontent" >
  <h3><?php echo $temasPruebasTab4['nombreTema']; ?></h3>
  
<?php 
if($hayExamenes==0){

?>

<div class="col-md-12" style="position: absolute; margin-top: 10px; margin-left: -10%;">
    <img src="../img/empty.svg" style="width: 200px; height: 100px; text-align: center;">
    <h4 style="font-weight: bold; color: #2863eb">¡¡Aún no hay pruebas asignadas!!</h4>
  </div>



<?php }else{ 

  while ($datosExamenes=$examenesCurso->fetch(PDO::FETCH_ASSOC)){
 
    @$contador2+=1;

    if($contador2==1){
  ?>

      

      <button type="button" class="btnGrado">Descargar Reporte</button>

<table class="table">

  <thead>
    <tr>
      <th colspan="5">Reporte Tareas</th>
    </tr>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre alumno</th>
      <th scope="col">Tarea 1</th>
      <th scope="col">Tarea 2</th>
      <th scope="col">Tarea 3</th>
      <th scope="col">Promedio</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Jose Alvarez</td>
      <td>50</td>
      <td>30</td>
      <td>30</td>
      <td>50</td>


    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>30</td>
      <td>50</td>
      <td>50</td>
      <td>30</td>

    </tr>
    <tr>
       <th scope="row">3</th>
      <td>Jacob</td>
      <td>30</td>
      <td>50</td>
      <td>50</td>
      <td>60</td>

    </tr>
  </tbody>
</table>




<br>



<?php }elseif($contador2==2){ ?>

      <button type="button" class="btnGrado">Descargar Reporte</button>

<table class="table">
  <thead>
     <tr>
      <th colspan="5">Reporte Examenes</th>
    </tr>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre alumno</th>
      <th scope="col">Examen 1</th>
      <th scope="col">Examen 2</th>
      <th scope="col">Examen 3</th>
      <th scope="col">Promedio</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Jose Alvarez</td>
      <td>50</td>
      <td>30</td>
      <td>50</td>
      <td>70</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>30</td>
      <td>50</td>
      <td>50</td>
      <td>60</td>

    </tr>
    <tr>
       <th scope="row">3</th>
      <td>Jacob</td>
      <td>30</td>
      <td>50</td>
      <td>50</td>
      <td>60</td>
    </tr>
  </tbody>
</table>


<?php } }  } ?>

</div>



<?php } ?>






      </div>
    </div>
  </div>





           <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear nuevo tema</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="crearNuevoTemaF">
                      <input type="text" name="eventoEjecutar" value="2" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">

                  
                        <div class="form-group">
                          <input type="text" class="form-control" name="txtTema" id="" aria-describedby="emailHelp" placeholder="Ingresa el tema">
                          <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                      

                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Close</button>
                    <button type="button" class="btnGrado" onclick="crearTema();">Crear Tema</button>
                  </div>
                </div>
              </div>
            </div>
<?php


                      if($hayTemas==0){
                        //variables para modal crear publiacion
                        $desactivar='disabled="true"';
                            $estilos='desactivarButton';
                            $tituloPublicacion='!Para crear una publicación necesita crear un tema!';
                            $btnPublicacion='No puedes crear publicación';

                        //variables para modal tarea    
                           $desactivar2='disabled="true"';
                            $estilos2='desactivarButton';
                            $tituloTarea='!Para crear una publicación necesita crear un tema!';
                            $btnCrearTarea='No puedes crear publicación';
    
                      }else{

                           $desactivar='';
                            $estilos='';
                            $tituloPublicacion='¡¡Compartir publicación!!';
                           $btnPublicacion='Compartir publicación';

                              //variables para modal tarea    
                        $desactivar2='';
                            $estilos2='';
                            $tituloTarea='!Crear nueva tarea!';
                            $btnCrearTarea='Crear Tarea';



                      }


 ?>

          <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $tituloPublicacion; ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="crearPublicacion" enctype="multipart/form-data" >
                       <select class="form-control" name="idTema" id="selectTema" required>
                           <option>Seleccionar Tema</option>

                      <?php 
                      
                           
                         
                          if($hayTemas==0){
                            

                      ?>
                       <option value="0">Necesitas crear un tema!!</option>
                     <?php  }else{   ?>

                     <?php while ($datosTemasPublicacion=$temasPublicacion->fetch(PDO::FETCH_ASSOC)){ ?>

                    <option  value="<?php echo $datosTemasPublicacion['idTema']; ?>"><?php echo $datosTemasPublicacion['nombreTema']; ?></option>

                       <?php } } ?>     
                          </select><br>

                      <input type="text" name="eventoEjecutar" value="4" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">
                  
                       <textarea id="editor" name="editor" rows="80" cols="80">Cuerpo de la publicación..</textarea><br>
                       <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">video de YOUTUBE</span>
                        <input type="text" class="form-control" name="urlRecurso" id="basic-url" aria-describedby="basic-addon3" placeholder="https://www.youtube.com/watch?v=HOQN3kmJ0dg"><br>

                      </div><br>
                    <div class="row">
                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; text-align: right;"  onclick="subirAdjunto();" >
                     <p class="" style="text-align: center; font-weight: bold;  margin-top: 10px; padding: 0;">Adjuntar Archivos</p>
                     </div>
                    </div>
                     <input type="file" name="file2[]" id="btnAdjuntarArchivo1" multiple style="display: none;" >


                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btnGrado <?php echo $estilos; ?>" <?php echo $desactivar; ?> onclick="guardarPublicacion();"><?php echo $btnPublicacion; ?></button>
                  </div>
                </div>
              </div>
            </div>




<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $tituloTarea; ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="crearTarea" enctype="multipart/form-data" >
                       <select class="form-control" name="idTema2" id="selectTema" required>
                           <option>Seleccionar Tema</option>
                            <?php 
                               
                                if($hayTemas2==0){

                            ?>
                             <option value="0">Necesitas crear un tema!!</option>
                           <?php  }else{   ?>

                           <?php while ($datosTemasPublicacion2=$temasPublicacion2->fetch(PDO::FETCH_ASSOC)){ ?>

                          <option  value="<?php echo $datosTemasPublicacion2['idTema']; ?>"><?php echo $datosTemasPublicacion2['nombreTema']; ?></option>

                             <?php } } ?>     
                      </select><br>

                      <input type="text" name="eventoEjecutar" value="5" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Título Tarea</span>
                        <input type="text" class="form-control" name="titulo" placeholder="Título Tarea" aria-describedby="basic-addon1">
                      </div><br>
                  
                   <textarea id="editor2" name="editor2" rows="80" cols="80">Instrucciones..</textarea><br>
                   <div class="row">
                    <div class="col-md-7">
                   <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Video YOUTUBE</span>
                        <input type="text" class="form-control"  name="urlRecurso" id="basic-url" aria-describedby="basic-addon3" placeholder="https://www.youtube.com/watch?v=HOQN3kmJ0dg"><br>

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Punteo</span>
                        <input type="number" class="form-control" name="punteo" placeholder="5pts" aria-describedby="basic-addon1">
                      </div>
                    
                    </div>
                    </div>
                    <br>

                  <div class="row">

                   <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Fecha Entrega</span>
                        <input type="date" name="fechaEntrega" id="datepicker2" min="<?php echo $fecha_actual; ?>"  class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Hora</span>
                        <input type="time" name="horaEntrega" id="datepicker2"   class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     
                 </div> <br> <br>



                    <div class="row">
                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; text-align: right;"  onclick="subirAdjunto2();" >
                     <p class="" style="text-align: center; font-weight: bold;  margin-top: 10px; padding: 0;">Adjuntar Archivos</p>
                     </div>
                    </div>

                     <input type="file" name="file3[]" id="btnAdjuntarArchivo2" multiple style="display: none;" >


                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btnGrado <?php echo $estilos; ?>" <?php echo $desactivar2; ?> onclick="guardarTarea();"><?php echo $btnCrearTarea; ?></button>
                  </div>
                </div>
              </div>
            </div>


<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $tituloTarea; ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="crearTarea" enctype="multipart/form-data" >
                       <select class="form-control" name="idTema2" id="selectTema" required>
                           <option>Seleccionar Tema</option>
                            <?php 
                               
                                if($hayTemas2==0){

                            ?>
                             <option value="0">Necesitas crear un tema!!</option>
                           <?php  }else{   ?>

                           <?php while ($datosTemasPublicacion2=$temasPublicacion2->fetch(PDO::FETCH_ASSOC)){ ?>

                          <option  value="<?php echo $datosTemasPublicacion2['idTema']; ?>"><?php echo $datosTemasPublicacion2['nombreTema']; ?></option>

                             <?php } } ?>     
                      </select><br>

                      <input type="text" name="eventoEjecutar" value="5" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Título Tarea</span>
                        <input type="text" class="form-control" name="titulo" placeholder="Título Tarea" aria-describedby="basic-addon1">
                      </div><br>
                  
                   <textarea id="editor2" name="editor2" rows="80" cols="80">Instrucciones..</textarea><br>
                   <div class="row">
                    <div class="col-md-7">
                   <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Video YOUTUBE</span>
                        <input type="text" class="form-control"  name="urlRecurso" id="basic-url" aria-describedby="basic-addon3" placeholder="https://www.youtube.com/watch?v=HOQN3kmJ0dg"><br>

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Punteo</span>
                        <input type="number" class="form-control" name="punteo" placeholder="5pts" aria-describedby="basic-addon1">
                      </div>
                    
                    </div>
                    </div>
                    <br>

                  <div class="row">

                   <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Fecha Entrega</span>
                        <input type="date" name="fechaEntrega" id="datepicker2" min="<?php echo $fecha_actual; ?>"  class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Hora</span>
                        <input type="time" name="horaEntrega" id="datepicker2"   class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     
                 </div> <br> <br>



                    <div class="row">
                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; text-align: right;"  onclick="subirAdjunto2();" >
                     <p class="" style="text-align: center; font-weight: bold;  margin-top: 10px; padding: 0;">Adjuntar Archivos</p>
                     </div>
                    </div>

                     <input type="file" name="file3[]" id="btnAdjuntarArchivo2" multiple style="display: none;" >


                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btnGrado <?php echo $estilos; ?>" <?php echo $desactivar2; ?> onclick="guardarTarea();"><?php echo $btnCrearTarea; ?></button>
                  </div>
                </div>
              </div>
            </div>









<div class="modal fade" id="pruebaEnLinea" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Creando prueba en linea</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                     <form id="detallesCuestionario" style="margin-top: 50px;">
               <input type="text" name="eventoEjecutar" value="1" style="display: none;">
                      <input type="text" name="idCuestionario" value="<?php echo $idExamenInsertar; ?>" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">
                  
              <div class="col-md-12">
                  <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Paso 1: Título de la prueba</span>
                        <input type="text" class="form-control" name="tituloPrueba" id="basic-url" aria-describedby="basic-addon3" placeholder="Cuestionario 1 Lenguaje"><br>

                      </div><br>

                  <textarea id="editor4" name="editor4" rows="10" cols="80">Instrucciones..</textarea><br>

                    <div class="col-md-6">
                       <select class="form-control" name="idTema" id="selectTema" required>
                           <option>Paso 3: Donde quieres el examen</option>

                      <?php 
                      
                           
                         
                          if($hayTemas4==0){
                            

                      ?>
                       <option value="0">Necesitas crear un tema!!</option>
                     <?php  }else{   ?>

                     <?php while ($datosTemasPublicacion=$temasPublicacion4->fetch(PDO::FETCH_ASSOC)){ ?>

                    <option  value="<?php echo $datosTemasPublicacion['idTema']; ?>"><?php echo $datosTemasPublicacion['nombreTema']; ?></option>

                       <?php } } ?>     
                          </select><br>
                  </div>


                     <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Punteo</span>
                        <input type="number" class="form-control" name="punteo" placeholder="5pts" aria-describedby="basic-addon1">
                      </div>
                      
                    </div>

              


              </div>
            
                  <div class="row" style="margin-left: 15px;">

                   <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Fecha Prueba</span>
                        <input type="date" name="fechaEntrega" id="datepicker2" min="<?php echo $fecha_actual; ?>"  class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     <div class="col-md-5" style="margin-left: 55px;">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Hora</span>
                        <input type="time" name="horaEntrega" id="datepicker2"   class="form-control" aria-describedby="basic-addon1">
                      </div>
                    </div>
                     
                 </div> <br> <br>
                 <div>
                   
                 </div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btnGrado <?php echo $estilos; ?>" <?php echo $desactivar2; ?> onclick="guardarDetalleCuestionario();">Crear Prueba en linea</button>
                  </div>
                </div>
              </div>
            </div>






















<p id="uriEnviar" style="display:none;"><?php echo $_SESSION['uriLocal']; ?></p>

<script type="text/javascript" charset="UTF-8">

CKEDITOR.replace('editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] }
             ]
});


CKEDITOR.replace('editor2', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] }
             ]
});


CKEDITOR.replace('editor4', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] }
             ]
});
//FUNCION PARA TAB VERTICAL TEMAS tab horizontal 1





var uri1 = $('#uriEnviar').text();






function crearTema(){

 var datosGuardar= $("#crearNuevoTemaF").serialize();
 alert(datosGuardar);

      $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCursosC.php',
        data: datosGuardar,
        success:function(r){
          $('.salida').html(r);

          swal("Tema Creado!!","Muy bien", "success");
              
          setTimeout(function() {

            location.reload();

          }, 1000);
          
            
        }

      });



}




//actualizar portada
//funcion que activa input file
function cambiarPortada(){

  $('#btnInputFile').click();      

}
//evento que verifica que ya el input se encuentra lleno preparado para actualizar portada
$("#btnInputFile").change(function(){
    //alert('se ha cargado el archivo '+this.files[0].name);

    swal({
  title: "Quieres actualizar la portada?",
  text: "La nueva portada es "+this.files[0].name,
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("actualizando", {
      icon: "success",
    });

    actualizandoPortada();

  } else {
    swal("No se actualizo la portada");
  }
});
});


function actualizandoPortada(){
  var paqueteDeDatos = new FormData($('#actualizarPortada')[0]);


    // alert(paqueteDeDatos);
      $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCursosC.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);
            

          setTimeout(function() {

           location.reload();

          }, 1000);
          
            
        }

      });
}











function subirAdjunto(){
  $('#btnAdjuntarArchivo1').click();

}

function subirAdjunto2(){
    $('#btnAdjuntarArchivo2').click();


}

$("#btnAdjuntarArchivo1").change(function(){

  var nombreArchivo=this.value();

  alert(nombreArchivo);
});


function guardarPublicacion(){
var paqueteDeDatos = new FormData($('#crearPublicacion')[0]);
var value = CKEDITOR.instances['editor'].getData();
 
 paqueteDeDatos.append("textoFormateado", value);
 
 //alert(paqueteDeDatos);

$.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCursosC.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);
          swal("Publicando..!!","Muy bien", "success");


          setTimeout(function() {

           location.reload();

          }, 1000);
          
            
        }

      });






}



function guardarTarea(){

var paqueteDeDatos = new FormData($('#crearTarea')[0]);
var value = CKEDITOR.instances['editor2'].getData();
 
 paqueteDeDatos.append("textoFormateado", value);
 
 //alert(paqueteDeDatos);

$.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCursosC.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);
          swal("Creando Tarea..!!","Muy bien", "success");


          setTimeout(function() {

          /// location.reload();

          }, 1000);
          
            
        }

      });


}

       </script>

<script type="text/javascript">
  function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    i

    tablinks[i].className = tablinks[i].className.replace(" active", "");

  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it


$('#defaultOpen1').click();


// Get the element with id="defaultOpen" and click on it
function activarPrimerPend(pestana){
  if(pestana==2){
$('#defaultOpen2').click();



}

  if(pestana==1){
    $('#defaultOpen1').click();


  }

    if(pestana==3){
    $('#defaultOpen3').click();


  }
      if(pestana==4){
    $('#defaultOpen4').click();

  }
}



//funcion para conteo regresivo de tareas

function guardarDetalleCuestionario(){

 var datosGuardar= $("#detallesCuestionario").serialize();
 var value = CKEDITOR.instances['editor4'].getData();
  var datosCompletos=datosGuardar+'&editor='+value;

  //alert(datosCompletos);

    $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGeneradorPrueba.php',
        data: datosCompletos,
        success:function(r){
          $('.salida').html(r);
          createAlert('',' ¡Se guardo Cuestionario!','Te falta crear preguntas','success',true,true,'pageMessages');              
          $('#pruebaEnLinea').modal('toggle');
          $('#preubaEnlineaClick').click();
  

          
            
        }

      });

}




//funcion para alertas

function createAlert(title, summary, details, severity, dismissible, autoDismiss, appendToId) {
  var iconMap = {
    info: "glyphicon glyphicon-info-sign",
    success: "glyphicon glyphicon-ok",
    warning: "glyphicon glyphicon-warning-sign",
    danger: "glyphicon glyphicon-remove"
  };

  var iconAdded = false;

  var alertClasses = ["alert", "animated", "flipInX"];
  alertClasses.push("alert-" + severity.toLowerCase());

  if (dismissible) {
    alertClasses.push("alert-dismissible");
  }

  var msgIcon = $("<i />", {
    "class": iconMap[severity] // you need to quote "class" since it's a reserved keyword
  });

  var msg = $("<div />", {
    "class": alertClasses.join(" ") // you need to quote "class" since it's a reserved keyword
  });

  if (title) {
    var msgTitle = $("<h4 />", {
      html: title
    }).appendTo(msg);
    
    if(!iconAdded){
      msgTitle.prepend(msgIcon);
      iconAdded = true;
    }
  }

  if (summary) {
    var msgSummary = $("<strong />", {
      html: summary
    }).appendTo(msg);
    
    if(!iconAdded){
      msgSummary.prepend(msgIcon);
      iconAdded = true;
    }
  }

  if (details) {
    var msgDetails = $("<p />", {
      html: details
    }).appendTo(msg);
    
    if(!iconAdded){
      msgDetails.prepend(msgIcon);
      iconAdded = true;
    }
  }
  

  if (dismissible) {
    var msgClose = $("<span />", {
      "class": "close", // you need to quote "class" since it's a reserved keyword
      "data-dismiss": "alert",
      html: "<span class='glyphicon glyphicon-remove'></span>"
    }).appendTo(msg);
  }
  
  $('#' + appendToId).prepend(msg);
  
  if(autoDismiss){
    setTimeout(function(){
      msg.addClass("flipOutX");
      setTimeout(function(){
        msg.remove();
      },2000);
    }, 2000);
  }
}


</script>



</script>

    </div>
<!--//CENTRANDO CONTENIDO ROL 1 -->

<!--LATERAL DERECHO CONTENIDO FIJO -->
    <?php include '../static/lat-derecho.php'; $nivelll=1; directoriosNivelesDer($nivelll); ?>
 <!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->  

 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
