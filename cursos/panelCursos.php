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

$fecha_actual=date("d/m/Y");
$hora_actual=date('Y-m-d H:i:s',time());

//variables de niveles
$nivelPrimaria=1;
$nivelBasico=2;
$nivelDiver=3;



//funcion encargada de asignar imagen segun primer letra del nombre del curso
  $l='#2980b9';
  $m='#2980b9';
  $x='#2980b9';
  $j='#2980b9';
  $v='#2980b9';

if(date("l")=='Monday'){
$l='#2ecc71';
}

if(date("l")=='Tuesday'){
$l='#2ecc71';
}

if(date("l")=='Tuesday'){
$m='#2ecc71';
}

if(date("l")=='Wednesday'){
$x='#2ecc71';
}
if(date("l")=='Thursday'){
$j='#2ecc71';
}
if(date("l")=='Friday'){
$v='#2ecc71';
}


//obtenemos la semana actual
$noSemanaActual = date("W"); 
//Buscar Lectura Correspondiente al dia - Lecturas diarias
$semanaModificar=$noSemanaActual-6; //tiene que ser igual a = $noSemanaActual;

$query1 = ("SELECT nombreLectura,noLecturaDiaria,idLectura FROM atomolector where grado=:grado and semana=:semana");
$getLecturaDiaria = $dbConn->prepare($query1);
$getLecturaDiaria->bindParam(':grado', $_SESSION['grado'], PDO::PARAM_INT); 
$getLecturaDiaria->bindParam(':semana', $semanaModificar, PDO::PARAM_INT); 
$getLecturaDiaria->execute();
$hayLecturasDiarias=$getLecturaDiaria->rowCount();

if($hayLecturasDiarias==0){
  $_SESSION['lunesLectura']='Terminamos,bravo fue un año lector exitoso!!';
     $_SESSION['martesLectura']='Terminamos,bravo fue un año lector exitoso!!';
     $_SESSION['miercolesLectura']='Terminamos,bravo fue un año lector exitoso!!';
     $_SESSION['juevesLectura']='Terminamos,bravo fue un año lector exitoso!!';
     $_SESSION['viernesLectura']='Terminamos,bravo fue un año lector exitoso!!';
}

//Buscar Lectura Correspondiente a la semana
$query2 = ("SELECT nombreLectura,idLectura FROM atomolector where grado=:grado and noLecturaDiaria=0 and estatus=1");
$getLecturasComprension = $dbConn->prepare($query2);
$getLecturasComprension->bindParam(':grado', $_SESSION['grado'], PDO::PARAM_INT); 
$getLecturasComprension->execute();
$hayLecturasDiarias=$getLecturasComprension->rowCount();

while ($lecturaComprension=$getLecturasComprension->fetch(PDO::FETCH_ASSOC)){
  @$p+=1;
  if($p==$semanaModificar){

  $_SESSION['comprensionSemanal']=	$lecturaComprension['nombreLectura'];
  $_SESSION['idComprension']= $lecturaComprension['idLectura'];
  //echo 'Semana'.$p.' Lectura------>'.$lecturaComprension['nombreLectura'].'<br>';
  }



}


//Buscar lecturas de velocidad correspondiente a la semana 
$query3 = ("SELECT nombreLectura,semana,idLectura FROM velocidadlectora where grado=:grado and semana=:semana");
$getLecturaVelocidad = $dbConn->prepare($query3);
$getLecturaVelocidad->bindParam(':grado', $_SESSION['grado'], PDO::PARAM_INT);
$getLecturaVelocidad->bindParam(':semana',$semanaModificar, PDO::PARAM_INT);  
$getLecturaVelocidad->execute();
$hayLecturasDiarias=$getLecturaVelocidad->rowCount();

while ($lecturaVelocidadver=$getLecturaVelocidad->fetch(PDO::FETCH_ASSOC)){
   

  $_SESSION['velocidadVer']=	$lecturaVelocidadver['nombreLectura'];
  $_SESSION['idVelocidad']=  $lecturaVelocidadver['idLectura'];
 // echo 'Semana'.$h.' Lectura Velocidad------>'.$lecturaVelocidadver['nombreLectura'].'<br>';
  }



///busqueda para iteraciones para numeroLectura velocidad

$query4 = ("SELECT nombreLectura,semana,idLectura FROM velocidadlectora where grado=:grado and semana=:semana");
$obtenerVelocidad = $dbConn->prepare($query4);
$obtenerVelocidad->bindParam(':grado', $_SESSION['grado'], PDO::PARAM_INT);
$obtenerVelocidad->bindParam(':semana',$semanaModificar, PDO::PARAM_INT);  
$obtenerVelocidad->execute();
$numeroLectura=$obtenerVelocidad->rowCount();



//dia de la semana actual
$diaSemana=date("l");

switch ($diaSemana) {
  case 'Monday':
   $semanaDia='Lunes';
    break;

  case 'Tuesday':
   $semanaDia='Martes';
    break;

  case 'Wednesday':
   $semanaDia='Miércoles';
    break;
  case 'Thursday':
   $semanaDia='Jueves';
    break;
  case 'Friday':
   $semanaDia='Viernes';
    break;
  
  default:
    $semanaDia='';
    break;
}





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
<script type="text/javascript">
  //$(".timeline-panel").hide(0);

$("i").click(function() {
      $('.timeline-panel').show(0);
});
</script>

<?php











while ($lecturaDiaria=$getLecturaDiaria->fetch(PDO::FETCH_ASSOC)){
 
  switch ($lecturaDiaria['noLecturaDiaria']) {
   case 1:
     $_SESSION['lunesLectura']=$lecturaDiaria['nombreLectura'];
     $dia="Lunes";

     $_SESSION['idDiariasLunes']=$lecturaDiaria['idLectura'];

     break;
     case 2:
     $_SESSION['martesLectura']=$lecturaDiaria['nombreLectura'];
    $dia="Martes";
    $_SESSION['idDiariasMartes']=$lecturaDiaria['idLectura'];


     break;
     case 3:
     $_SESSION['miercolesLectura']=$lecturaDiaria['nombreLectura'];
    $dia="Miércoles";
    $_SESSION['idDiariasMiercoles']=$lecturaDiaria['idLectura'];


   
     break;
     case 4:
     $_SESSION['juevesLectura']=$lecturaDiaria['nombreLectura'];
    $_SESSION['miercolesLectura']=$lecturaDiaria['nombreLectura'];
    $dia="Jueves";
    $_SESSION['idDiariasJueves']=$lecturaDiaria['idLectura'];



     break;
     case 5:
     $_SESSION['viernesLectura']=$lecturaDiaria['nombreLectura'];
     $dia="Viernes";
     $_SESSION['idDiariasViernes']=$lecturaDiaria['idLectura'];

  
     break;

   
   default:
     
     break;
 }






}



 ?>


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
              <h3 class="text-center">Panel Cursos </h3>
         </div>

         <div class="salida"></div>
           

              <div class="row">
                <div class="col-md-2">
                 <a href="#" class="btnGrado btn btn-lg" data-toggle="modal" data-target="#exampleModalLong">Crear nuevo curso <span class="glyphicon glyphicon-plus"></span></a>
                </div>
              </div>   





    <div class="row">
      
            <?php 
         $query100 = ("SELECT * from curso where idProfesor=:idProfesor order by grado asc");
        $buscarCursosDocente = $dbConn->prepare($query100);
        $buscarCursosDocente->bindParam(':idProfesor', $_SESSION['idUsuario'], PDO::PARAM_INT);
        $buscarCursosDocente->execute();
        $hayCursos=$buscarCursosDocente->rowCount();

        if($hayCursos==0){


?>


  <div class="col-md-12" style="margin-top: 10%;">
    <img src="../img/empty.svg" style="width: 300px; height: 200px; text-align: center;">
    <h3 style="font-weight: bold; color: #2863eb">¡¡Aún no hay Cursos!!</h3>
    
  </div>


 <?php 

}else{
        while ($datos=$buscarCursosDocente->fetch(PDO::FETCH_ASSOC)){

          switch ($datos['grado']) {
            case 1:
                $gradoAsignado='1ero Primaria';
              break;
            case 2:
                $gradoAsignado='2do Primaria';
              break;
            case 3:
                $gradoAsignado='3ero Primaria';
              break;
            case 4:
                $gradoAsignado='4to Primaria';
              break;
            case 5:
                $gradoAsignado='5to Primaria';
              break;
            case 6:
                $gradoAsignado='6to Primaria';
              break;
            case 7:
                $gradoAsignado='1ero Básicos';
              break;
            case 8:
                $gradoAsignado='2do Básicos';
              break;
            case 9:
                $gradoAsignado='3ero Básicos';
              break;
            case 10:
                $gradoAsignado='4to Diver';
              break;
            case 11:
                $gradoAsignado='4to Diver';
              break;
            case 13:
                $gradoAsignado='Prekinder';
              break;
            case 14:
                $gradoAsignado='Kinder';
              break;
            case 15:
                $gradoAsignado='Preparatoria';
              break;
            
            default:
              # code...
              break;
          }


           ?>

      <a href="gestorCurso.php?tokenCourse=<?php echo $datos['idCurso']; ?>&course=<?php echo $datos['nombreCurso']; ?>">  
      <div class="card col-xs-12 col-md-3 col-lg-3" style="padding: 0px;">
        <div style=" height: 170px;  background: url(<?php echo $_SESSION['uriLocal'].$datos['portada']; ?>) no-repeat  center;" class="portada">
          <h5 style="color: white; text-align: left; position: absolute; padding-left: 10px;"><?php  echo $gradoAsignado; ?></h5>
        </div>

        <div style="">
          <div class="row">
          <h5 class="col-md-8 courseTitle"><?php echo $datos['nombreCurso']; ?></h5>
          <div class="col-md-3 courseUser">
            <img src="https://image.flaticon.com/icons/svg/615/615075.svg" style="width: 30px; height: 30px;">
            </div>
          </div>
        </div>

      </div>
    </a>   
    <?php  } } ?>


    </div>




           <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear nuevo curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="crearCurso">
                      <input type="text" name="eventoEjecutar" value="1" style="display: none;">
                      <input type="text" name="idProfesor" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">
                      <select class="form-control" name="txtGrado">
                           <option>Selecciona el grado</option>

                            <optgroup label="Prescolar">
                              <option value="13">Prekinder</option>
                              <option value="14">Kinder</option>
                              <option value="15">Prepa</option>
                            </optgroup>
                            <optgroup label="Primaria">
                              <option value="1">1ero Primaria</option>
                              <option value="2">2do Primaria</option>
                              <option value="3">3ero Primaria</option>
                              <option value="4">4to Primaria</option>
                              <option value="5">5to Primaria</option>
                              <option value="6">6to Primaria</option>
                            </optgroup>
                            <optgroup label="Básico">
                              <option value="7">1ero Básico</option>
                              <option value="8">2do Básico</option>
                              <option value="9">3ero Básico</option>
                            </optgroup>
                            <optgroup label="Diver">
                              <option value="10">4to Diver</option>
                              <option value="11">5to Diver</option>
                            </optgroup>
                          </select><br>
                           <select class="form-control" name="seccionGrado" id="seccionGrado">
                           <option>Selecciona la sección</option>

                            <optgroup label="seccion">
                              <option value="a">a</option>
                              <option value="b">b</option>
                              <option value="c">c</option>
                              <option value="d">d</option>
                              <option value="d">d</option>
                              <option value="d">d</option>
                              <option value="g">g</option>
                              <option value="h">h</option>
                              <option value="i">i</option>
                              <option value="j">j</option>
                              <option value="k">k</option>
                              <option value="l">l</option>
                              <option value="m">m</option>
                              <option value="n">n</option>
                              <option value="ñ">ñ</option>
                              <option value="o">o</option>
                              <option value="o">p</option>
                              <option value="p">p</option>
                              <option value="q">q</option>
                              <option value="r">r</option>
                              <option value="s">s</option>
                              <option value="t">t</option>
                              <option value="v">v</option>
                              <option value="w">w</option>
                              <option value="x">x</option>
                              <option value="y">y</option>
                              <option value="z">z</option>
                            </optgroup>
                           
                          </select><br>
                        <div class="form-group">
                          <input type="text" class="form-control" name="txtNombreCurso" id="" aria-describedby="emailHelp" placeholder="Ingresa nombre Curso">
                          <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                      

                     </form>  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btnGrado btn btn-secondary" style="background-color: grey; border:1px solid grey;" data-dismiss="modal">Close</button>
                    <button type="button" class="btnGrado" onclick="crearCurso1();">Crear Curso</button>
                  </div>
                </div>
              </div>
            </div>








<p id="uriEnviar" style="display:none;"><?php echo $_SESSION['uriLocal']; ?></p>

<script type="text/javascript" charset="UTF-8">

function crearCurso1(){
var uri1 = $('#uriEnviar').text();

 var datosGuardar= $("#crearCurso").serialize();
 //alert(datosGuardar);
 var datosSerialize=datosGuardar.split('=',10);
 //var reemplazar = /%20/g;
 //var cursoCreado=unescape(datosSerialize[3]);


var cursoCreado = decodeURI(datosSerialize[5]);

 //alert(datosSerialize);
      $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCursosC.php',
        data: datosGuardar,
        success:function(r){
          $('.salida').html(r);

          swal("Curso creado", cursoCreado+" ", "success");
              
          setTimeout(function() {

          location.reload();

          }, 2000);
          
            
        }

      });



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
