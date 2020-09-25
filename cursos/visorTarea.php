<?php 
session_start();
//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../index.html');
}

require("../conection/conexion.php");


//fecha y hora actual
date_default_timezone_set('America/Guatemala');

$fecha_actual=date("d/m/Y");
$hora_actual=date('Y-m-d H:i:s',time());


$fechaCompleta=$fecha_actual.$hora_actual;
//variables de niveles
$nivelPrimaria=1;
$nivelBasico=2;
$nivelDiver=3;




//obtenemos la semana actual
$noSemanaActual = date("W"); 
//Buscar Lectura Correspondiente al dia - Lecturas diarias
$semanaModificar=$noSemanaActual-6; //tiene que ser igual a = $noSemanaActual;



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



 ?>



<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Mi Tarea</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link href="../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Ubuntu', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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


 /*estilos para push notificacion final*/


 .boxCard{
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

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
                       height:35px;
                       background-color:#2980b9;
                       text-decoration: none;
                       color: white;
                       background-color: #273c75;
                       border:1px solid #273c75;
                       border-radius: 10px;
                       margin-top: 5px;
                       margin-bottom: 20px;

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
       

.fileDowload > img{
  height: 50px;

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


.btnDescarga{
margin-top: 20px; background-color: #e67e22; border:1px solid #e67e22;
}

.btnDescarga:hover{
margin-top: 20px; background-color: #e67e22; border:1px solid #e67e22;
}

.boxCard{
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}


/*ondas circulares*/
.gps_ring {
    border: 2px solid #1a237e;
    -webkit-border-radius: 50%;
    height: 18px;
    width: 18px;
    position: absolute;
    left:200px;
    top:80px;
    -webkit-animation: pulsate 1s ease-out;
    -webkit-animation-iteration-count: infinite; 
    opacity: 0.0;
}
.gps_ring:before {
    content:"";
    display:block;
    border: 2px solid #1a237e;
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
    border:2px solid #1a237e;
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


 </style>







 <div class="col-md-8 col-xs-8 pag-center">
         <div class="col-md-12" style="margin-top: 20px;">
              <h3 class="text-center">Mi Tarea <?php echo $_GET['course']; ?></h3>
         </div>

           <a href="<?php echo 'gestorCursoAlumno.php?tokenCourse='.$_GET['tokenCourse'].'&course='.$_GET['course']; ?>" style="font-size: 30px; border: 1px solid #3498db; margin-top:40px; margin-bottom: 50px;  margin-left: 10px; height: 50px;   background-color:#3498db; color: white;"  class="btn btn-default botonAgg-1">Volver a mi curso</a>
         <div class="salida"></div>
         <div id="pageMessages" ></div>

           

    <?php
    
      $queryTarea = ("SELECT * FROM tareaCurso where idTarea=:idTarea limit 1");
      $datosTarea = $dbConn->prepare($queryTarea);
      $datosTarea->bindParam(':idTarea',$_GET['tokenTar'], PDO::PARAM_INT);
      $datosTarea->execute();




     while ($detalleTarea=$datosTarea->fetch(PDO::FETCH_ASSOC)){

      $fechaPublicacion=fechaCastellano($detalleTarea['fechaEntrega']);
      $horaEntregaTarea= substr($detalleTarea['fechaEntrega'],11,20);
      $_SESSION['punteo']=$detalleTarea['punteo'];





     ?>     
            
     
      <div class="col-md-12 boxCard" style="text-align: left; margin-top: 20px;">
          <div class="chip boxCard" style="float: right; margin-bottom: 20px; margin-top: 5px;">
              <div class="chip-head"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
              <div class="chip-content"><?php echo 'Fecha Entrega: '.$fechaPublicacion.' '.$horaEntregaTarea; ?></div>
              <div class="chip-close">
                  <svg class="chip-svg" focusable="false" viewBox="0 0 24 24" aria-hidden="true"></svg>
              
              </div>
            </div>
        <h3 ><span class="glyphicon glyphicon-list-alt"></span> <?php echo $detalleTarea['titulo'] ?></h3>
        <div class="instrucciones">
          <h5>Instrucciones: <?php echo $detalleTarea['descripcion']; ?></h5>
          <h5>Punteo: <span style="font-weight: bold; font-size: 18pt;"><?php echo $detalleTarea['punteo']; ?></span></h5>

          
        </div>


        <?php
//verificamos si hay url y mostramos el video
  if(!empty($detalleTarea['urlRecurso'])){

     $dirPat = pathinfo($detalleTarea['urlRecurso'], PATHINFO_BASENAME);
 ?>
<iframe width="300" height="200" src="https://www.youtube.com/embed/<?php echo $dirPat; ?>" style="margin-top: 20px;" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
 

<?php } ?>


          <div class="row" style="padding: 10px;">
    
    <p style="text-align: left; font-weight: bold; color: #2863eb;">Tarea Entregada</p>


    <?php


  $q5 = ("SELECT * FROM filesTarea where idTarea=:idTarea");
  $buscarFicherosP = $dbConn->prepare($q5);
  $buscarFicherosP->bindParam(':idTarea',$detalleTarea['idTarea'], PDO::PARAM_INT);
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

      if($extension=='png' or $extension=='jpg' or $extension=='svg' or $extension=='jpeg' or $extension=='gif') {
        $rutaMostrar='../'.$ficherosP['rutaFile'];

      ?> 





      <div class="col-md-1 fileDowload">
      <a href="#" class="" data-toggle="modal" data-target="<?php echo '#img'.$ficherosP['idRegistro']; ?>"><img src="<?php echo $rutaMostrar; ?>"   class="vibrar"  style="margin-left: 20px; width: 50px; height: 50px;"  ></a><br>
      <a class="btnGrado btn btn-xs btnDescarga"  href="<?php echo '../'.$ficherosP['rutaFile']; ?>" target="_blank" download="<?php echo $nombreFichero; ?>" >Descargar <span class="glyphicon glyphicon-download-alt"></span></a>

 

      </div>


           <?php 
      //mostramos notas y comentario dependiendo si esta solvente
     if($_SESSION['verNotasAlumnoSolvente']==1){

      //buscamos la tarea 
       $queryTarea2 = ("SELECT * FROM cursoGestorTarea where idUsuario=:idUsuario and idTarea=:idTarea limit 1");
       $buscarTareaCalificacion = $dbConn->prepare($queryTarea2);
       $buscarTareaCalificacion->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
       $buscarTareaCalificacion->bindParam(':idTarea',$_GET['tokenTar'], PDO::PARAM_INT);
       $buscarTareaCalificacion->execute();
       $hayTareasCalificada=$buscarTareaCalificacion->rowCount();

       if($hayTareasCalificada>=1){
      while ($calificacionTarea=$buscarTareaCalificacion->fetch(PDO::FETCH_ASSOC)){


      ?>
      <br><br><br><br><br>
       <div class="row">
        <div class="col-md-11" style="margin-left: 15px; border:2px dashed; border-image: linear-gradient(to right, #C6426E, #642B73)1;">
        <div class="col-md-5">
            <p style="font-size: 14pt; font-weight: bold;">Punteo Obtenido: <span style="font-weight: bold; font-size: 18pt; color:#0652DD;"><?php echo $calificacionTarea['punteo']; ?></span></p>
        </div>
        <div class="col-md-6">
          <p style="font-size: 14pt; font-weight: bold;">Comentario del docente:  <span style="font-weight: bold; font-size: 12pt; color:#0652DD;"><?php echo $calificacionTarea['comentarioDocente']; ?></span></p>
        </div>
        </div>
      </div>

     <?php } } }else{ }?>

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
                    <img src="<?php echo $rutaMostrar; ?>"   class="vibrar"  style=" max-width:500px; min-height: 300px;"  >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>


      <?php }elseif($extension!='png' or $extension!='jpg' or $extension!='svg' or $extension!='jpeg'){ ?>


<div class="row">
      <div class="col-md-1 fileDowload">
      <img src="<?php echo $imagenFicheros; ?>"  class="vibrar"  style="margin-left: 20px;"><br>
       <a class="btnGrado btn btn-xs btnDescarga" href="<?php echo '../'.$ficherosP['rutaFile']; ?>" target="_blank" download="<?php echo $nombreFichero; ?>" >Descargar <span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
</div>




     


    <?php }  ?>  


<?php }} ?>



  </div>


        
      </div>
       
   


   <?php } ?>


<?php
//verificar si tarea fue enviada

 $query2 = ("SELECT idTarea FROM cursoGestorTarea where idUsuario=:idUsuario and idTarea=:idTarea limit 1");
       $buscarTarea = $dbConn->prepare($query2);
       $buscarTarea->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
       $buscarTarea->bindParam(':idTarea',$_GET['tokenTar'], PDO::PARAM_INT);
       $buscarTarea->execute();
       $hizoTarea= $buscarTarea->rowCount();

       if($hizoTarea>=1){
        $desactivarBtnEnviar='pointer-events:none;';
        $desactivarBtnEnviar1='background-color:grey; border:1px solid grey;';
        $desactivarCaja='pointer-events:none';
        $tituloEnviarTarea="Tarea Enviada exitosamente!!";

       }else{
        $desactivarBtnEnviar='';
        $desactivarBtnEnviar1='';
        $desactivarCaja='';
        $tituloEnviarTarea="Enviar Tarea";

       }




 ?>


<div class="col-md-12 boxCard" style="margin-top:30px; margin-bottom: 50px; margin-bottom: 20px;background-color: #fafafa; border:4px solid; border-image: linear-gradient(to right, #C6426E, #642B73)1; <?php echo $desactivarCaja; ?>" >




  <h3><?php echo $tituloEnviarTarea; ?></h1>
    <div class="gps_ring" style="margin-left: 800px; margin-top: 20px;"></div>
     <div class="row">
      <form id="formTareaAlumno">
                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; text-align: right;"  onclick="subirAdjunto2();" >
                     <p class="" style="text-align: center; font-weight: bold;  margin-top: 10px; padding: 0;">Adjuntar Archivos</p>
                     </div>
                
                     <div class="col-md-8">
                      <input type="text" name="eventoEjecutar" value="1" style="display: none;">
                      <input type="text" name="idAlumno" value="<?php echo $_SESSION['idUsuario']; ?>"  style="display: none;">
                      <input type="text" name="idTarea" value="<?php  echo $_GET['tokenTar']; ?>"  style="display: none;">
                      <input type="text" name="idCurso" value="<?php  echo $_GET['idCurso']; ?>"  style="display: none;">
                    <textarea class="form-control" name="comentarioAlumno" id="exampleFormControlTextarea1"  rows="3" placeholder="Enviar Comentario (opcional)" ></textarea>
                       
                     </div>
                </div>

                     <input type="file" name="file3[]" id="btnAdjuntarArchivo2" multiple style="display: none;" >
              </form>
                   <div class="col-md-10">
                    <a class="btnGrado btn btn-lg" style="margin-top: 10px; <?php echo $desactivarBtnEnviar.$desactivarBtnEnviar1; ?>" onclick="subirTarea();">Enviar Tarea <span class="glyphicon glyphicon-send" ></span></a>
                    </div>
                    <div class="col-md-2 statusTarea">

                      <?php if($hizoTarea>=1){ ?>
                      <img src="../img/leido1.png" width="50" height="50" style="position: absolute;">
                    <?php }else{ ?>
                        <img src="../img/enviado1.png" width="50" height="50" style="position: absolute;">
                    <?php } ?>
                    </div>

  
</div>








<p id="uriEnviar" style="display:none;"><?php echo $_SESSION['uriLocal']; ?></p>

<script type="text/javascript" charset="UTF-8">
var uri1 = $('#uriEnviar').text();



function subirTarea(){
  createAlert('',' ¡Se envio la tarea!','Espera a que el profesor la califique','success',true,true,'pageMessages');  


  var paqueteDeDatos = new FormData($('#formTareaAlumno')[0]);
  
 
$.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGestorTareas.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);


          setTimeout(function() {

          /// location.reload();

          }, 1000);
            
        }

      });


}




  function subirAdjunto2(){
    $('#btnAdjuntarArchivo2').click();

  

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
