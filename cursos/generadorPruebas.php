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



//obtenemos la semana actual
$noSemanaActual = date("W"); 
//Buscar Lectura Correspondiente al dia - Lecturas diarias
$semanaModificar=$noSemanaActual-6; //tiene que ser igual a = $noSemanaActual;


  $q1 = ("SELECT * FROM temaCurso where idCurso=:idCurso");
  $temasPublicacion = $dbConn->prepare($q1);
  $temasPublicacion->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $temasPublicacion->execute();
  $hayTemas=$temasPublicacion->rowCount();


  $q3=  ("SELECT idRegistro FROM examenesCurso");
  $obtenerIdExamenes = $dbConn->prepare($q3);
  $obtenerIdExamenes->bindParam(':idCurso',$_GET['tokenCourse'], PDO::PARAM_INT);
  $obtenerIdExamenes->execute();
  $idExamenInsertar=$obtenerIdExamenes->rowCount()+1;


  $q4=  ("SELECT *, DATE_FORMAT(fechaExamen, '%Y-%m-%d') fechaEntrega,  DATE_FORMAT(fechaExamen,'%H:%i:%s') horaEntrega   FROM examenesCurso where idRegistro=:idRegistro limit 1");
  $obtenerDetalleExamen = $dbConn->prepare($q4);
  $obtenerDetalleExamen->bindParam(':idRegistro',$_GET['tokenQ'], PDO::PARAM_INT);
  $obtenerDetalleExamen->execute();



 ?>



<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Generador Pruebas</title>
 
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
                       height:40px;background-color:#2980b9;
                       text-decoration: none;
                       color: white;
                       background-color: #273c75;
                       border:1px solid #273c75;
                       border-radius: 10px;
                       padding: 5px;
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


/*estilos cards Cursos*/

.courseUser{
  border:1px solid black; 
  color: white; 
  background-color:; 
  border-radius:120px;
  margin-top: 5px;

}

.courseUser:hover{
    background-color:white; 
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    cursor:pointer;

}

.courseTitle{
  font-size: bold; 
  text-align: left;
  margin-left: 5px;
}


.portada{
  
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
   height: 100%;
   width: 100% ;
   text-align: center;
   border-radius: 15px 15px 0 0;
 
}

.boxCard{
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.colorBtn{
  background-color: #e67e22;
  border: 1px solid #e67e22;
}


.colorBtn:hover{
background-color: #e67e22;
  border: 1px solid #e67e22;
}

.colorBtn2{
  background-color: #2ecc71;
  border:1px solid #2ecc71;

}

.colorBtn2:hover{
  background-color: #2ecc71;
  border:1px solid #2ecc71;
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
         <div class="col-md-12" style="">
         </div>

         <div class="salida"></div>
         <div id="pageMessages" ></div>
         <div class="col-md-2" style=" margin-left: 40%;">
              <a href="gestorCurso.php?tokenCourse=<?php echo $_GET['tokenCourse']; ?>&course=<?php echo $_GET['course']; ?>" class="btnGrado btn btn-lg colorBtn"  style="margin-top: 20px; background-color: #273c75; border:1px solid #273c75;"> Regresar a mi curso <span class="glyphicon glyphicon-arrow-left"></span></a>
            </div>
           

 <?php while ($datosCuestionario=$obtenerDetalleExamen->fetch(PDO::FETCH_ASSOC)){ ?>

         <div class="col-md-12 boxCard" style="margin-top: 50px; min-height: 620px;">
          <h3>Creando prueba en linea</h3>
           
            <form id="detallesCuestionario" style="margin-top: 50px;">
               <input type="text" name="eventoEjecutar" value="5" style="display: none;">
                      <input type="text" name="idCuestionario" value="<?php echo $_GET['tokenQ']; ?>" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <input type="text" name="idCurso" value="<?php echo $_GET['tokenCourse']; ?>" style="display: none;">
                  
              <div class="col-md-12">
                  <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Paso 1: Título de la prueba</span>
                        <input type="text" class="form-control" name="tituloPrueba" id="basic-url" aria-describedby="basic-addon3" placeholder="Cuestionario 1 Lenguaje" value="<?php echo $datosCuestionario['titulo']; ?>"><br>

                      </div><br>

                  <textarea id="editor" name="editor" rows="10" cols="80"><?php echo $datosCuestionario['instrucciones']; ?></textarea><br>

                    <div class="col-md-6">
                       <select class="form-control" name="idTema" id="selectTema" required>
                           <option>Paso 3: Seleccionar en donde quieres asignar la prueba</option>

                      <?php 
                      
                           
                          if($hayTemas==0){
                            

                      ?>
                       <option value="0">Necesitas crear un tema!!</option>
                     <?php  }else{   ?>

                     <?php while ($datosTemasPublicacion=$temasPublicacion->fetch(PDO::FETCH_ASSOC)){ 

                     if($datosTemasPublicacion['idTema']==$datosCuestionario['idTema']){
                          $selecciono="selected";
                     }else{
                      $selecciono="";
                     }

                      ?>




                    <option  value="<?php echo $datosTemasPublicacion['idTema']; ?>" <?php echo $selecciono; ?>> <?php echo $datosTemasPublicacion['nombreTema']; ?></option>

                       <?php } } ?>     
                          </select><br>
                  </div>


                     <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Punteo</span>
                        <input type="number" class="form-control" name="punteo" placeholder="5pts" aria-describedby="basic-addon1" value="<?php echo $datosCuestionario['punteo']; ?>">
                      </div>
                      
                    </div>

              


              </div>
            
                  <div class="row" style="margin-left: 15px;">

                   <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Fecha Prueba</span>
                        <input type="date" name="fechaEntrega" id="datepicker2" min="<?php echo $fecha_actual; ?>"  class="form-control" aria-describedby="basic-addon1" value="<?php echo $datosCuestionario['fechaEntrega']; ?>">
                      </div>
                    </div>
                     <div class="col-md-5" style="margin-left: 55px;">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Hora</span>
                        <input type="time" name="horaEntrega" id="datepicker2"   class="form-control" aria-describedby="basic-addon1" value="<?php echo $datosCuestionario['horaEntrega']; ?>">
                      </div>
                    </div>
                     
                 </div> <br> <br>
                 <div>
                   
                 </div>
                 <div class="col-md-12">
                  <a href="#" id="guardarDetalle" class="btnGrado btn btn-lg colorBtn2"  onclick="actualizarDetalle();">Actualizar Cuestionario <span class="glyphicon glyphicon-send"></span></a>
                  </div><br>
                  </form>

                     
         </div>
    <?php } ?>

         <div class="col-md-12 boxCard" style="margin-top: 20px; margin-bottom: 100px;">
          <h4 style="text-align: left;">Crear una pregunta</h4>
          <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-2" style="">

              <a href="#" class="btnGrado btn btn-lg colorBtn" data-toggle="modal" data-target="#opcionM" style="margin-top: 20px;"> Opcion Multiple <span class="glyphicon glyphicon-th-list"></span></a>

            </div>
            <div class="col-md-2" style=" margin-left: 50px;">
              <a href="#" class="btnGrado btn btn-lg colorBtn" data-toggle="modal" data-target="#emparejamiento" style="margin-top: 20px;"> Emparejamiento <span class="glyphicon glyphicon-resize-small"></span></a>
            </div>
            <div class="col-md-2" style=" margin-left: 50px;">
               <a href="#" class="btnGrado btn btn-lg colorBtn" data-toggle="modal" data-target="#respuestaCorta" style="margin-top: 20px;"> Respuesta corta <span class="glyphicon glyphicon-align-left"></span></a>
            </div>
            <div class="col-md-2" style=" margin-left: 50px;">
              <a href="#" class="btnGrado btn btn-lg colorBtn" data-toggle="modal" data-target="#preguntaC" style="margin-top: 20px;"> Pregunta calculada <span class="glyphicon glyphicon-superscript"></span></a>
            </div>
          </div>

          <div >
            
          </div>

         </div>






         <div ><br>
              <h3 style="text-align: left;">Solucionario</h3>

          </div>

         <div class="col-md-12" id="tablePreguntas" style="margin-bottom: 20px;">
          
           
         </div>







           <div class="modal fade" id="opcionM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Crear pregunta opción multiple</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="formCrearOpcionMultiple" enctype="multipart/form-data">
                      <input type="text" name="eventoEjecutar" value="2" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>"
                       style="display: none;">
                       <input type="text" name="idCuestionario" value="<?php echo $_GET['tokenQ']; ?>" style="display: none;">
                        <div class="form-group">
                          
                       <input type="file" name="file2"   id="btnAdjuntarArchivo1" accept="image/*" style="display: none ;" >

                        <div class="row">
                          <div class="col-md-9"> 
                            <input type="text" class="form-control"  id="preguntaLimpiar" name="txtPregunta" id="" aria-describedby="emailHelp" placeholder="Ingrese una pregunta o elija una imágen">
                              
                          </div>

                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; margin-top:-5px; text-align: right; cursor: pointer;"  onclick="subirAdjunto();" >
                     </div>

                    </div>

                    <div class="row" style="margin-top: 20px;">
                      
                     <div class="col-md-6">
                            <input type="number" class="form-control" name="txtRespuestaCorrecta" id="respuestaCorrectaLimpiar" aria-describedby="emailHelp" placeholder="Ingrese que respuesta es la correcta">
                              
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta1" id="respuesta1Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 1">
                              
                      </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                       <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta2" id="respuesta2Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 2">
                              
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta3" id="respuesta3Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 3">         
                      </div>
                      
                    </div>

                  </div>
                      

                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Close</button>
                    <button type="button" class="btnGrado" onclick="crearOpcionMultiple();">Crear Pregunta</button>
                  </div>
                </div>
              </div>
            </div>



           <div class="modal fade" id="emparejamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Crear Item Emparejamiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="formCrearEmparejamiento" enctype="multipart/form-data">
                      <input type="text" name="eventoEjecutar" value="3" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>"
                       style="display: none;">
                       <input type="text" name="idCuestionario" value="<?php echo $_GET['tokenQ']; ?>" style="display: none;">
                        <div class="form-group">
                          
                       <input type="file" name="file3"   id="btnAdjuntarArchivo2" accept="image/*" style="display: none;" >

                        <div class="row">
                          <div class="col-md-9"> 
                            <input type="text" class="form-control"  id="preguntaLimpiar2" name="instrucciones" id="" aria-describedby="emailHelp" placeholder="Ingrese Instrucciones o imágen">
                              
                          </div>

                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; margin-top:-5px; text-align: right; cursor: pointer;"  onclick="subirAdjunto2();" >
                     </div>

                    </div>

                    <div class="row" style="margin-top: 20px;">
                      
                     <div class="col-md-6">
                            <input type="text" class="form-control" name="txtPregunta1" id="txtPregunta1" aria-describedby="emailHelp" placeholder="Ingrese Pregunta 1">
                              
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta1" id="respuesta1Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 1">
                              
                      </div>
                    </div>

                      <div class="row" style="margin-top: 20px;">
                      
                     <div class="col-md-6">
                            <input type="text" class="form-control" name="txtPregunta2" id="txtPregunta2" aria-describedby="emailHelp" placeholder="Ingrese Pregunta 2">
                              
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta2" id="respuesta2Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 2">
                              
                      </div>
                    </div>

                       <div class="row" style="margin-top: 20px;">
                      
                     <div class="col-md-6">
                            <input type="text" class="form-control" name="txtPregunta3" id="txtPregunta3" aria-describedby="emailHelp" placeholder="Ingrese Pregunta 3">
                              
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta3" id="respuesta3Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 3">
                              
                      </div>
                    </div>

                 <div class="row" style="margin-top: 20px;">      
                     <div class="col-md-6">
                            <input type="text" class="form-control" name="txtPregunta4" id="txtPregunta4" aria-describedby="emailHelp" placeholder="Ingrese Pregunta 4">
                      </div>
                      <div class="col-md-6">
                            <input type="text" class="form-control" name="txtRespuesta4" id="respuesta4Limpiar" aria-describedby="emailHelp" placeholder="Respuesta 4">
                              
                      </div>
                  </div>

                  </div>
                      

                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Close</button>
                    <button type="button" class="btnGrado" onclick="crearEmparejamiento();">Crear Pregunta</button>
                  </div>
                </div>
              </div>
            </div>




           <div class="modal fade" id="respuestaCorta" tabindex="-1" role="dialog" aria-labelledby="respuestaCorta" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Crear Item Respuesta Corta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="formCrearRespuestaCorta" enctype="multipart/form-data">
                      <input type="text" name="eventoEjecutar" value="4" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>"
                       style="display: none;">
                       <input type="text" name="idCuestionario" value="<?php echo $_GET['tokenQ']; ?>" style="display: none;">
                        <div class="form-group">
                          
                       <input type="file" name="file4"   id="btnAdjuntarArchivo3" accept="image/*" style="display: none;" >

                        <div class="row">
                          <div class="col-md-9"> 
                            <input type="text" class="form-control"  id="preguntaLimpiar2" name="txtPregunta" id="" aria-describedby="emailHelp" placeholder="Ingrese Pregunta o instrucciones">
                              
                          </div>

                     <div class="col-md-3">
                     <img src="../img/attach2.svg" class="vibrar" width="50" height="50" style="text-align: left; padding: 0px; margin-top:-5px; text-align: right; cursor: pointer;"  onclick="subirAdjunto3();" >
                     </div>

                    </div>

                    <div class="row" style="margin-top: 20px;">
                      
                     <div class="col-md-12">
                            <textarea class="form-control" name="txtComparar" id="txtComparar" aria-describedby="emailHelp" rows="10" placeholder="Ingrese el texto para que LOLA lo compare con la respuesta del alumno."></textarea> 
                              
                      </div>
                      
                    </div>



                  </div>
                      

                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Close</button>
                    <button type="button" class="btnGrado" onclick="crearRespuestaCorta();">Crear Pregunta</button>
                  </div>
                </div>
              </div>
            </div>





<input type="text" id="tokenCourse" value="<?php echo $_GET['tokenCourse'] ?>" style="display: none;" >
<input type="text" id="tokenQ" value="<?php echo $_GET['tokenQ'] ?>" style="display: none;" >



<p id="uriEnviar" style="display:none;"><?php echo $_SESSION['uriLocal']; ?></p>


<script type="text/javascript" charset="UTF-8">

var uri1 = $('#uriEnviar').text();
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



function subirAdjunto(){
  $('#btnAdjuntarArchivo1').click();

}

function subirAdjunto2(){
  $('#btnAdjuntarArchivo2').click();

}

function subirAdjunto3(){
  $('#btnAdjuntarArchivo3').click();

}







function crearOpcionMultiple(){

  var paqueteDeDatos = new FormData($('#formCrearOpcionMultiple')[0]);




 $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGeneradorPrueba.php',
        data: paqueteDeDatos,
        contentType: false,
        processData: false,
        success:function(r){
          $('.salida').html(r);
          createAlert('',' ¡Se guardo la pregunta!','Falta poco.','success',true,true,'pageMessages');              
          //cerramos modal
          $('#opcionM').modal('toggle');

          //limpiamos cajas de texto
          $('#btnAdjuntarArchivo1').val(null);
          $('#preguntaLimpiar').val('');
          $('#respuestaCorrectaLimpiar').val('');
          $('#respuesta1Limpiar').val('');
          $('#respuesta2Limpiar').val('');
          $('#respuesta3Limpiar').val('');
            
        }

      });


}


function  crearEmparejamiento(){

  var paqueteDeDatos = new FormData($('#formCrearEmparejamiento')[0]);


 $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGeneradorPrueba.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);
          createAlert('',' ¡Se guardo la pregunta!','Falta poco.','success',true,true,'pageMessages');              
          //cerramos modal
          $('#emparejamiento').modal('toggle');

          //limpiamos cajas de texto

            
        }

      });

  
}


function crearRespuestaCorta(){
  var paqueteDeDatos = new FormData($('#formCrearRespuestaCorta')[0]);


 $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGeneradorPrueba.php',
        data:paqueteDeDatos,
        contentType:false,
        processData:false,
        success:function(r){
          $('.salida').html(r);
          createAlert('',' ¡Se guardo la pregunta!','Falta poco.','success',true,true,'pageMessages');              
          //cerramos modal
          $('#respuestaCorta').modal('toggle');

          //limpiamos cajas de texto

            
        }

      });

}

///virificar consultar preguntas creadas
 function consultarPreguntas(){

      var tokenCourse=$('#tokenCourse').val();
      var tokenQ=$('#tokenQ').val();
      var registroEventos= $.ajax({
        url: uri1+'controladorModulos/crudGeneradorPrueba.php?idCuestionario='+tokenQ+'&idCurso='+tokenCourse,
        dataType: "text",
        async: false

      }).responseText;
      document.getElementById('tablePreguntas').innerHTML = registroEventos;

    }
    setInterval(consultarPreguntas,1000);






function ocultarBtnDetalle(){
  $('#guardarDetalle').css("display","none");
}



function actualizarDetalle(){

 var datosGuardar= $("#detallesCuestionario").serialize();
 var value = CKEDITOR.instances['editor'].getData();
  var datosCompletos=datosGuardar+'&editor='+value;

  //alert(datosCompletos);

    $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudGeneradorPrueba.php',
        data: datosCompletos,
        success:function(r){
          $('.salida').html(r);
          createAlert('',' ¡Se Actualizo Cuestionario!','Listo','success',true,true,'pageMessages');              
          
            
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
