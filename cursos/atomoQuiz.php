<?php 
session_start();

//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../index.html');
}



require("../conection/conexion.php");
  $_GET['noLectura']=1;
  $_GET['intento']=1;
  $_GET['gradoB']=$_SESSION['grado'];

  $fundamento="cnb";
  
   $sql2=("SELECT *  FROM examenesCurso where idRegistro=:idRegistro");
   $obtenerDetalleCuestionario = $dbConn->prepare($sql2);
   $obtenerDetalleCuestionario->bindparam(':idRegistro', $_GET['tokenRegister']);
   $obtenerDetalleCuestionario->execute();
    

    if($_GET['gradoB']==3){
        //url para insertar bd
      $urlCalificar='controllador/calificarCnbReconocimiento.php';
    }else{
       $urlCalificar='controllador/calificarCnb.php';
    }

    if($_GET['gradoB']==4){
         //url para insertar bd
       $urlCalificar='controllador/calificarCnbReconocimiento4p.php';
    }

    if($_GET['gradoB']==5){

      $urlCalificar='controllador/calificarCnbReconocimiento5p.php';
    }
     if($_GET['gradoB']==6){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }

      if($_GET['gradoB']==7){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }

      if($_GET['gradoB']==8){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }

      if($_GET['gradoB']==9){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }

      if($_GET['gradoB']==10){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }
      
    if($_GET['gradoB']==11){

      $urlCalificar='controllador/calificarCnbReconocimiento6p.php';
    }
      
   // echo $urlCalificar; 

    //OBTENER DATOS DEL EXAMEN CALIFICADO

 ?>
    

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Mis Cursos</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="icon" type="image/png" href="https://atomolector.com/img/icons/icon2.ico"/>
    <link href="../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link href="../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="../css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Ubuntu', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
 
    <!-- librerias para el funcionamiento del calendario -->
     <!-- JQUERY FUNCIONAL -->
    <script src='../js/jquery.min.js'></script>
    <!-- LIBRERIAS RECONOCIMIENTO DE VOZ -->
  
  <script src="../js/artyom/jquery-3.1.1.js"></script>
  <script src="../js/artyom/artyom.min.js"></script>
  <script src="../js/artyom/artyom.window.js"></script>
  <script src="../js/artyom/artyomCommands.js"></script>

<script language="Javascript"  type="text/javascript" src="../reloj/clockCountdown.js"></script>
  </head>
  <body class="txt-fuente">

  
<!--NAVEGACION CONTENIDO FIJO -->
<?php include '../static/nav.php'; $nivell=1; directorioNivelesNav($nivell); ?>
<!-- //NAVEGACION CONTENIDO FIJO -->

<!-- LATERAL IZQUIERDO CONTENIDO FIJO -->
 <?php include '../static/lat-izquierdo.php'; $nivel=1; directoriosNiveles($nivel);?>
<!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->

<!--CENTRANDO CONTENIDO ROL 1 -->
 <style type="text/css">
   .masCentrado{
    margin-top: 500px;
    margin-left: 55%;
   }
    
    .botonAgg-1 {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  background-color:#3498db;
  color: black;
  height: 30px;
  border-radius: 5px;
  padding-top: 5px;
  color: white;
}

.botonAgg-1:hover {
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;

}
  
.cajaDescripcion{
                     box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
                    }


/*radio butons estilos*/


.boxCard{
  border-radius: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

@font-face {
  
 
}
/* aqui va el estilo que tendra el clock */

/*estilos radiobutton*/


/* Variables
–––––––––––––––––––––––––––––––––––––––––––––––––– */
:root {
  --colorfondo-c: #2980b9;
  --primary-c: #74b9ff;
  --secondary-c: #74b9ff;
  --tercery-c: #74b9ff;
  --fort-c: #74b9ff;
  
  --white: #FDFBFB;
  
  --text: #082943;  
  --bg: var(--colorfondo-c);
}
ul {
  list-style-type: none;
  padding-left: 50px;
  margin: 0;
}

li {
  display: block;
  position: relative;
  padding: 20px 0px;
}

h2 {
  margin: 10px 0;
  font-weight: 900;
}


/* Card
–––––––––––––––––––––––––––––––––––––––––––––––––– */
.card {
  display: flex;
  flex-direction: column; 
  background: var(--white);
 
  padding: 20px 25px;
  border-radius: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  margin-top: 20px;
  text-align: left;

}


/* Radio Button
–––––––––––––––––––––––––––––––––––––––––––––––––– */
input[type=radio] {
  position: absolute;
  visibility: block;
  margin-left: -45px; 
  z-index: 6;
  width:30px;height:30px;
  opacity: 0;
  cursor: pointer;
}



.check {
  width: 40px; height: 40px;
  position: absolute;
  border-radius: 50%;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);


}

.check:hover{
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
}

input:hover  ~ .check {
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
}

/* Reset */
input#one ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--primary-c); 

}
input#two ~ .check { 
  transform: translate(-50px,-30px); 
  background: var(--secondary-c);
  
}
input#tree ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--tercery-c);
  
}
input#fort ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--fort-c);
  
  
}

/* Radio Input #1 */
input#one:checked ~ .check { transform: translate(-50px, -35px); 
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background: var(--colorfondo-c);



}
input#one:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}


/* Radio Input #2  */
input#two:checked ~ .check { transform: translate(-50px, -35px);
box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);
}

input#two:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}

/* Radio Input #3  */

input#tree:checked ~ .check { transform: translate(-50px, -35px);
  box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);
  
  

}
input#tree:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}

/* Radio Input #4  */

input#fort:checked ~ .check { transform: translate(-50px, -35px);
  box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);

}
input#fort:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}



/*estilo tiempo*/
  .card11{
    position: relative;
    width: 60px;
    height: 60px;
   
    background: #fff;
    box-shadow: 0 15px 60px rgba(0,0,0, .5);
    border-radius: 15px;
  }
  
  .card11 .face{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .card11 .face.face1{
    box-sizing: border-box;
    padding: 20px;
  }
  
  .card11 .face.face1 h2{
    margin: 0;
    padding: 0;
    
  }
  
  .card11.face.face1 .content{
    font-size:1.2em;
    margin:0;
    padding:0 0 1em 0;
    font-weight:500;
  }
  
  .card11 .face.face2{
    background: #111;
    transition: 0.5s;
  }
  
  .card11:nth-child(1) .face.face2{
    background: linear-gradient(45deg, #3503ad, #f7308c);
    border-radius: 15px;
  }
  
  .card11:nth-child(2) .face.face2{
    background: linear-gradient(45deg, #ccff00, #09afff);
    border-radius: 15px;
  }
  
  .card11:nth-child(2) .face.face2{
    background: linear-gradient(45deg, #e91e63, #ffeb3b);
    border-radius: 15px;
  }
  

  .card11 .face.face2:before{
    content:'';
    position: absolute;
    top:0;
    left:0;
    width: 50%;
    height: 100%;
    background: rgba(255,255,255, 0.1);
    border-radius: 15px 0 0 15px;
  }
  
  .card11 .face.face2 h2{
    margin: 0;
    padding: 0;
    font-size: 2em;
    color: #fff;
    transition: 0.5s;
    text-shadow: 0 2px 5px rgba(0,0,0, .2);
  }






 </style>



	<div class="col-md-8 col-xs-8 pag-center">
         <div class="col-md-12" style="margin-top: 60px;">
              <h3 class="text-center">Prueba En Linea</h3><br>
          <div class="salida"></div>    
         </div>
         <?php while(@$row2=$obtenerDetalleCuestionario->fetch(PDO::FETCH_ASSOC)){  
 
 ?>
      <div class="col-md-12 cajaDescripcion" style="min-height:100px; text-align: left; border-radius: 10px; border:2px solid; border-image: linear-gradient(to right, #C6426E, #642B73)1; margin-bottom: 50px;">
        <img src="https://ionicframework.com/img/getting-started/ionic-native-card.png" style=" transform: rotate(-180deg); position: absolute; height: 100%; margin-left: -15px;">
        <h4 style="text-align: center; font-weight: bold;">Datos de la prueba</h4>

        <div style="margin-left: 140px; margin-top: 60px;">
        <h4 style="font-weight: bold;">Título Examen:<span  style="font-weight: normal;"> <?php echo '"'.$row2['titulo'].'"'; ?></span></h4>
        <p id="idLectura" style="display: none;"><?php echo $row2['idLectura']; ?></p>
        <h4 style="font-weight: bold;">Instrucciones: <span  style="font-weight: normal;"><?php echo $row2['instrucciones']; ?></span> </h4>
        <h4 style="font-weight: bold;">Punteo: <span  style="font-weight: normal;"><?php echo $row2['punteo']; ?></span> </h4>
       <h4 style="font-weight: bold;">Fecha Limite: <span  style="font-weight: normal;"><?php echo $row2['fechaExamen']; ?></span> </h4>

        <h4 style="font-weight: bold;">Nombre Alumno: <span style="font-weight: normal;"><?php echo strtoupper($_SESSION['nombre'])." ".strtoupper($_SESSION['apellido']); ?></span> </h4>
       </div>

        <div style="border:0px  pink; margin-bottom: 30px; margin-top: -50px; ">
            <h1  style="margin-top:-40px; margin-left: 80%;">Tiempo:</h1>
    

    <div class="row" style="margin-left:80%;">
    <div class="card11 col-md-1" style="">
      <div class="face face2">
        <h2 id="minutos">00</h2>
        <p style="margin-left:3px; font-size: 12px; text-align: center; color: white;">min</p>
      </div>
    </div>

    <div class="card11 col-md-1" style="margin-left:10px;">
      
      <div class="face face2">
        <h2 id="segundos">00</h2>
        <p style="margin-left:3px; font-size: 12px; text-align: center; color: white;"> seg</p>
      </div>
    </div>
          </div> 
          </div> 

      </div>
  <?php } ?>   

   
<form id="formQuizCalificar">
 <input type="text" name="eventoEjecutar" value="1" style="display: none;">
 <input type="text" name="idExamen" value="<?php echo $_GET['tokenRegister']; ?>" style="display: none;">
 <input type="text" name="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;" >
<?php
    
   //buscar itemOpcionMultiple items items desordenados
   $sql2=("SELECT * from cuestionarioOpcionMultiple where idExamenCurso=:idExamen order by RAND()");
   $buscarOpcionMultiple = $dbConn->prepare($sql2);
   $buscarOpcionMultiple->bindparam(':idExamen', $_GET['tokenRegister']);
   $buscarOpcionMultiple->execute();

   while(@$datosOpcionMultiple=$buscarOpcionMultiple->fetch(PDO::FETCH_ASSOC)){  
      @$noPreguntaOpcion+=1;


 ?>





<div class="card boxCard col-md-12" style="text-align: left; margin-bottom: 20px;">
  <div style="display: inline-block; border: 3px solid white; border-radius: 20rem; color: white; text-align: center; padding: 0.5rem; box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 3px 0px; font-weight: 600; min-width: 4rem; font-size: 2rem; background: linear-gradient(to right, #C6426E, #642B73); position: absolute; margin-top: 12%; margin-left: 90%; "><?php echo @$noPreguntaOpcion; ?></div>
  <h4 style="text-align: center;"><?php echo $datosOpcionMultiple['pregunta']; ?></h4>
  <input type="text" name="<?php echo 'idPregunta'.$datosOpcionMultiple['idRegistro']; ?>" value="<?php echo $datosOpcionMultiple['idRegistro']; ?>" style="display: none;">
  <?php
    if(!empty($datosOpcionMultiple['recursoPregunta'])){
   ?>
   <img src="<?php echo $_SESSION['uriLocal'].$datosOpcionMultiple['recursoPregunta']; ?>" style="width:300px; height: 300px;">
 <?php } ?>

   <ul>
    <input value="0" type="radio" name="<?php echo 'multiple'.$datosOpcionMultiple['idRegistro']; ?>"  style="" checked />
    <li >


      <input value="1" type="radio" name="<?php echo 'multiple'.$datosOpcionMultiple['idRegistro']; ?>" id="one" style="" />
      <label ><?php echo $datosOpcionMultiple['respuesta1']; ?></label>
      
      
      <div class="check"></div>
    </li>
    
    <li>
      <input type="radio" value="2" name="<?php echo 'multiple'.$datosOpcionMultiple['idRegistro']; ?>" id="two" />
      <label ><?php echo $datosOpcionMultiple['respuesta2']; ?></label>
      
      <div class="check"></div>
    </li>
    <li>
      <input type="radio" value="3" name="<?php echo 'multiple'.$datosOpcionMultiple['idRegistro']; ?>" id="tree" />
      <label ><?php echo $datosOpcionMultiple['respuesta3']; ?></label>
      
      <div class="check"></div>
    </li>

  </ul>
</div>

<?php } ?>


<?php
    
   //buscar emparejamiento items items random
   $sqlEmp=("SELECT * from cuestionarioEmparejamiento where idExamen=:idExamen order by RAND()");
   $buscarEmparejamiento = $dbConn->prepare($sqlEmp);
   $buscarEmparejamiento->bindparam(':idExamen', $_GET['tokenRegister']);
   $buscarEmparejamiento->execute();

   while(@$datosEmparejamiento=$buscarEmparejamiento->fetch(PDO::FETCH_ASSOC)){  
      @$noPreguntaOpcion+=1;

      @$contadorInternoEmparejamiento+=1;


    ?>

<div class="boxCard col-md-12" style="text-align: left; margin-bottom: 20px;">
  <div style="display: inline-block; border: 3px solid white; border-radius: 20rem; color: white; text-align: center; padding: 0.5rem; box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 3px 0px; font-weight: 600; min-width: 4rem; font-size: 2rem; background: linear-gradient(to right, #C6426E, #642B73); position: absolute; margin-top: 12%; margin-left: 90%; "><?php echo @$noPreguntaOpcion; ?></div>
  <h4 style="text-align: center;"><?php echo $datosEmparejamiento['instrucciones']; ?></h4><br>
  <input type="text" name="<?php echo 'idEmparejamiento'.$datosEmparejamiento['idRegistro']; ?>" value="<?php echo $datosEmparejamiento['idRegistro']; ?>" style="display: none;">
    <div class="col-md-12">

    <?php
    if(!empty($datosEmparejamiento['recursoPregunta'])){
   ?>
   <img  src="<?php echo $_SESSION['uriLocal'].$datosEmparejamiento['recursoPregunta']; ?>" style="width:300px; height: 300px;">
 <?php } ?>
      
    </div><br>




    <div class="col-md-5"><p><?php echo $datosEmparejamiento['pregunta1']; ?></p></div>
 
<?php

  if(!empty($datosEmparejamiento['pregunta1'])){

 ?>
    <div class="col-md-6" style="margin-bottom: 20px;"> 
      <select class="form-control" name="<?php echo 'pregunta'.$datosEmparejamiento['idRegistro'].'opt1'; ?>" id="selectTema" required>
            <option value="0">Elije la respuesta</option>
            <option value="<?php echo $datosEmparejamiento['respuesta1']; ?>"><?php echo $datosEmparejamiento['respuesta1']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta2']; ?>"><?php echo $datosEmparejamiento['respuesta2']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta3']; ?>"><?php echo $datosEmparejamiento['respuesta3']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta4']; ?>"><?php echo $datosEmparejamiento['respuesta4']; ?></option>
      </select>
    
    </div>
<?php } ?>
    <div class="col-md-5"><p><?php echo $datosEmparejamiento['pregunta2']; ?></p></div>
   
<?php

  if(!empty($datosEmparejamiento['pregunta2'])){

 ?>
    <div class="col-md-6" style="margin-bottom: 20px;"> 

      <select class="form-control" name="<?php echo 'pregunta'.$datosEmparejamiento['idRegistro'].'opt2'; ?>" required>
            <option value="0" >Elije la respuesta</option>
            <option value="<?php echo $datosEmparejamiento['respuesta1']; ?>"><?php echo $datosEmparejamiento['respuesta1']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta2']; ?>"><?php echo $datosEmparejamiento['respuesta2']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta3']; ?>"><?php echo $datosEmparejamiento['respuesta3']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta4']; ?>"><?php echo $datosEmparejamiento['respuesta4']; ?></option>
      </select>
    
    </div>
<?php } ?>

  <div class="col-md-5"><p><?php echo $datosEmparejamiento['pregunta3']; ?></p></div>
   

<?php

  if(!empty($datosEmparejamiento['pregunta3'])){

 ?>
    <div class="col-md-6" style="margin-bottom: 20px;"> 


      <select class="form-control" name="<?php echo 'pregunta'.$datosEmparejamiento['idRegistro'].'opt3'; ?>" id="selectTema" required>
            <option value="0">Elije la respuesta</option>
            <option value="<?php echo $datosEmparejamiento['respuesta1']; ?>"><?php echo $datosEmparejamiento['respuesta1']; ?></option>
            <option value="2"><?php echo $datosEmparejamiento['respuesta2']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta2']; ?>"><?php echo $datosEmparejamiento['respuesta3']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta4']; ?>"><?php echo $datosEmparejamiento['respuesta4']; ?></option>
      </select>
    
    </div>
<?php } ?>

  <div class="col-md-5"><p><?php echo $datosEmparejamiento['pregunta4']; ?></p></div>
  
<?php

  if(!empty($datosEmparejamiento['pregunta4'])){

 ?>
    <div class="col-md-6" style="margin-bottom: 20px;"> 

      <select class="form-control" name="<?php echo 'pregunta'.$datosEmparejamiento['idRegistro'].'opt4'; ?>" id="selectTema" required>
            <option value="0">Elije la respuesta</option>
            <option value="<?php echo $datosEmparejamiento['respuesta1']; ?>"><?php echo $datosEmparejamiento['respuesta1']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta2']; ?>"><?php echo $datosEmparejamiento['respuesta2']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta3']; ?>"><?php echo $datosEmparejamiento['respuesta3']; ?></option>
            <option value="<?php echo $datosEmparejamiento['respuesta4']; ?>"><?php echo $datosEmparejamiento['respuesta4']; ?></option>
      </select>
    
    </div>
<?php } ?>



   
</div>

<?php } ?>



<?php
    
   //buscar respuesta corta items items random
   $sqlRespuestaCorta=("SELECT * from cuestionarioRespuestaCorta where idExamen=:idExamen order by RAND()");
   $buscarRespCorta = $dbConn->prepare($sqlRespuestaCorta);
   $buscarRespCorta->bindparam(':idExamen', $_GET['tokenRegister']);
   $buscarRespCorta->execute();

   while(@$datosRespuestaCorta=$buscarRespCorta->fetch(PDO::FETCH_ASSOC)){  
      @$noPreguntaOpcion+=1;

      @$noPreguntaRespuestaCorta+=1


    ?>
<div class="card col-md-12" style="min-height: 250px; margin-bottom: 50px;">
   
  <div style="display: inline-block; border: 3px solid white; border-radius: 20rem; color: white; text-align: center; padding: 0.5rem; box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 3px 0px; font-weight: 600; min-width: 4rem; font-size: 2rem; background: linear-gradient(to right, #C6426E, #642B73); position: absolute; margin-top: 12%; margin-left: 90%; "><?php echo @$noPreguntaOpcion; ?></div>
  <input type="text" name="<?php echo 'idRespCorta'.$datosRespuestaCorta['idRegistro']; ?>" value="<?php echo $datosRespuestaCorta['idRegistro']; ?>" style="display: none;">

  <h4 style="text-align: center; font-weight: bold;"><?php echo $datosRespuestaCorta['pregunta']; ?></h4>

       <?php
    if(!empty($datosRespuestaCorta['recursoPregunta'])){
   ?>
   <img src="<?php echo $_SESSION['uriLocal'].$datosRespuestaCorta['recursoPregunta']; ?>" style="width:300px; height: 300px;">
 <?php } ?>

<div class="recodinggN" id="<?php echo 'on'.$datosRespuestaCorta['idRegistro']; ?>" title="Graba tú respuesta" style="cursor: pointer; padding-top:3px; padding-left: 5px; width: 50px; height: 50px; border-radius: 100%; margin-top: 10px; background-color: #e67e22; margin-left: 40%;" onclick="quizRespuesta(this.id)"><img src="../img/micro.png" width="40" height="40" ></div>
      
      <div id="<?php echo 'off'.$datosRespuestaCorta['idRegistro']; ?>" class="recodinggN" title="Graba el concepto" style="cursor: pointer; padding-top:3px; padding-left: 5px;  width: 50px; height: 50px; border-radius: 100%; margin-top: 10px; background-color: #F72626; margin-left: 40%; display: none" onclick="finVoz(this.id)"><img src="../img/microOf.png" width="40" height="40" ></div>
      <h4>Redacta o graba tú respuesta:</h4>
      <div class="col-md-8 cajaDescripcion" style="color: white; background-color:#e67e22; border-radius: 5px; " >
      </div>
      <input type="text" name="<?php echo 'input'.$datosRespuestaCorta['idRegistro']; ?>" id='<?php echo 'span-preview'.$datosRespuestaCorta['idRegistro']; ?>' value="" style=" border-radius: 5px; height: 50px;">
      

      <a id="<?php echo 'limpiar'.$datosRespuestaCorta['idRegistro']; ?>" onclick="lipiarNew1(this.id);" class="btn btn-default botonAgg-1 col-md-3" style="border:1px solid #3498db; margin-top: 50px;">Volver a grabar o redactar</a>
    </div>
<?php } ?>




  <input style="font-size: 30px; border: 1px solid #3498db; margin-top:40px; margin-bottom: 50px;  margin-left: 10px; " onclick="calificarQuiz();"  value="Terminar Examen" name="" class="btn btn-default botonAgg-1">
  </form>

<div style="margin-top: 20px;"></div>




<p id="uriEnviar" style="display:none;"><?php echo $_SESSION['uriLocal']; ?></p>

<script language="Javascript"  type="text/javascript">
    var uri1 = $('#uriEnviar').text();


function calificarQuiz(){

 var datosGuardar= $("#formQuizCalificar").serialize();
 var minutos = $("#minutos").text();
 var segundos= $("#segundos").text();
 var idLectura=$("#idLectura").text();
    
var tiempoNew=  minutos+':'+segundos;

var datosGuardar2=datosGuardar+'&tiempo='+tiempoNew;
 //alert(datosGuardar2);

      $.ajax({
        type: "POST",
        url: uri1+'controladorModulos/crudCalificarExamen.php',
        data: datosGuardar2,
        success:function(r){
          $('.salida').html(r);
              
          setTimeout(function() {

            location.reload();

          }, 1000);
          
            
        }

      });
}





    
  window.onload=carga();

  function carga()
  {
    contador_s =0;
    contador_m =0;
    s = document.getElementById("segundos");
    m = document.getElementById("minutos");

    cronometro = setInterval(
      function(){
        if(contador_s==60)
        {
          contador_s=0;
          contador_m++;
          m.innerHTML = contador_m;

          if(contador_m==60)
          {
            contador_m=0;
          }
        }

        s.innerHTML = contador_s;
        contador_s++;

      }
      ,1000);

  }


  function quizRespuesta(clicked_id){
          var idPregunta= clicked_id.substring(2,60000);
          
          startArtyom();
          $('#'+clicked_id).css("display","none");
          $('#off'+idPregunta).css("display","block");
          capturarVoz(idPregunta);

          
  }

    function capturarVoz(idPregunta){
    // Escribir lo que escucha.
    artyom.redirectRecognizedTextOutput(function(text,isFinal){
      if (isFinal) {
        texto.val(text);
            
      }else{
        var fluidez=[text];
        $("#span-preview"+idPregunta).val(fluidez);
       
        
      }
     
    });

   }


function finVoz(clicked_id){
 

   var ocultar= clicked_id;
   var mostrar= ocultar.substring(3,60000); 
     var texto = $("#span-preview"+mostrar).val();

   $('#'+ocultar).css("display","none");
   $('#on'+mostrar).css("display","block"); 
  
   $("#input"+mostrar).val(texto);

    //confirmar guardado de grabacion

    finAsistente();
}


function lipiarNew1(clicked_id){
  var cadenaText=clicked_id;
  var idLimpiar=cadenaText.substring(7,70000);
   $("#span-preview"+idLimpiar).val('');
   $("#input"+idLimpiar).val('');
}



        </script>



          
      </div>
<!--//CENTRANDO CONTENIDO ROL 1 -->

<!--LATERAL DERECHO CONTENIDO FIJO -->
		<?php include '../static/lat-derecho.php'; $nivelll=1; directoriosNivelesDer($nivelll); ?>
 <!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->  

 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../js/jquery-3.2.1.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>