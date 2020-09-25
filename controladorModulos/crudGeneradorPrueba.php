<?php 
session_start();
require("../conection/conexion.php");


date_default_timezone_set('America/Guatemala');
$fecha_actual=date("d/m/Y");
$fechaCompleta=date('Y-m-d H:i:s',time());


switch (@$_POST['eventoEjecutar']) {
	case 1:
		# almacenamiento de detalle de prueba
			//echo ' estoy almacenando detalle prueba';

		     $fechaEntregaCompleta= $_POST['fechaEntrega'].' '.$_POST['horaEntrega'];
		     /*
		     echo 'titulo :'.$_POST['tituloPrueba'].'<br>';
		     echo 'instrucciones :'.$_POST['editor'].'<br>';
		     echo 'idTema :'.$_POST['idTema'].'<br>';
		     echo 'punteo :'.$_POST['punteo'].'<br>';
		     echo 'fechaExamen :'.$fechaEntregaCompleta.'<br>';
		     echo 'idProfesor :'.$_POST['idProfesor'].'<br>';
		     echo 'idCurso :'.$_POST['idCurso'].'<br>';
		     echo 'fechaRegistro :'.$fechaCompleta.'<br>';
		     */

			  $q1 = ("INSERT INTO examenesCurso(idRegistro,titulo,instrucciones,idTema,punteo,fechaExamen,idProfesor,idCurso,fechaRegistro) VALUES(:idRegistro,:titulo,:instrucciones,:idTema,:punteo,:fechaExamen,:idProfesor,:idCurso,:fechaRegistro)");
			  $insertarDetalleExamen = $dbConn->prepare($q1);
			  $insertarDetalleExamen->bindParam(':idRegistro',$_POST['idCuestionario'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':titulo',$_POST['tituloPrueba'], PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':instrucciones',$_POST['editor'], PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':idTema',$_POST['idTema'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':punteo',$_POST['punteo'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':fechaExamen',$fechaEntregaCompleta, PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':fechaRegistro',$fechaCompleta, PDO::PARAM_STR);
			  $insertarDetalleExamen->execute();

		break;


		case 2:

			//echo 'pregunta '.$_POST['txtPregunta'].'<br>';

			//echo 'Respuesta correcta '.$_POST['txtRespuestaCorrecta'].'<br>';
			//echo 'Respuesta 1 '.$_POST['txtRespuesta1'].'<br>';
			//echo 'Respuesta 2 '.$_POST['txtRespuesta2'].'<br>';
			//echo 'Respuesta 3 '.$_POST['txtRespuesta3'].'<br>';
			//echo 'ID del examen '.$_POST['idCuestionario'].'<br>';
			//echo 'ID Profesor '.$_POST['idProfesor'].'<br>';



		   if(!empty($_FILES["file2"]['name'])){

			//echo 'Hay Recurso '.$_FILES["file2"]['name'].'<br>';
			
			$archivoCargado=$_FILES['file2']['tmp_name'];
			$rutaAlmacenarRecurso='../cursos/recursosPrueba/'.$_FILES['file2']['name'];
		    $rutaAlmacenarBd= 'cursos/recursosPrueba/'.$_FILES['file2']['name'];

		   // echo 'se almaceno recurso Prueba en '.$rutaAlmacenarBd;

			move_uploaded_file($archivoCargado,$rutaAlmacenarRecurso);

			}else{

			//echo 'No tiene recurso la pregunta<br>';
			$rutaAlmacenarBd='';

			}


			$query1 = ("INSERT INTO cuestionarioOpcionMultiple(pregunta,recursoPregunta,respuestaCorrecta,respuesta1,respuesta2,respuesta3,idExamenCurso) values(:pregunta,:recursoPregunta,:respuestaCorrecta,:respuesta1,:respuesta2,:respuesta3,:idExamenCurso)");
				$insertarPregunta = $dbConn->prepare($query1);
				$insertarPregunta->bindParam(':pregunta',$_POST['txtPregunta'], PDO::PARAM_STR);
				$insertarPregunta->bindParam(':recursoPregunta',$rutaAlmacenarBd, PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuestaCorrecta',$_POST['txtRespuestaCorrecta'], PDO::PARAM_INT);
			    $insertarPregunta->bindParam(':respuesta1',$_POST['txtRespuesta1'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta2',$_POST['txtRespuesta2'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta3',$_POST['txtRespuesta3'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':idExamenCurso',$_POST['idCuestionario'], PDO::PARAM_INT);
				$insertarPregunta->execute();

		break;
	

		case 3:

			echo 'idCuestionario '.$_POST['idCuestionario'].'<br>';
			echo 'Instrucciones '.$_POST['instrucciones'].'<br>';
			echo 'Pregunta1 '.$_POST['txtPregunta1'].'<br>';
			echo 'Respuesta1 '.$_POST['txtRespuesta1'].'<br>';
			echo 'Pregunta2 '.$_POST['txtPregunta2'].'<br>';
			echo 'Respuesta2 '.$_POST['txtRespuesta2'].'<br>';
			echo 'Pregunta3 '.$_POST['txtPregunta3'].'<br>';
			echo 'Respuesta3 '.$_POST['txtRespuesta3'].'<br>';
			echo 'Pregunta4 '.$_POST['txtPregunta4'].'<br>';
			echo 'Respuesta4 '.$_POST['txtRespuesta4'].'<br>';
			echo 'idProfesor '.$_POST['idProfesor'].'<br>';
			echo 'idCuestionario '.$_POST['idCuestionario'].'<br>';

			if(!empty($_FILES["file3"]['name'])){

			//echo 'Hay Recurso '.$_FILES["file3"]['name'].'<br>';
			
			$archivoCargado=$_FILES['file3']['tmp_name'];
			$rutaAlmacenarRecurso='../cursos/recursosPrueba/'.$_FILES['file3']['name'];
		    $rutaAlmacenarBd= 'cursos/recursosPrueba/'.$_FILES['file3']['name'];

		  //  echo 'se almaceno recurso Prueba en '.$rutaAlmacenarBd;

			move_uploaded_file($archivoCargado,$rutaAlmacenarRecurso);

			}else{

			echo 'No tiene recurso la pregunta<br>';
			$rutaAlmacenarBd='';

			}



			$query1 = ("INSERT INTO cuestionarioEmparejamiento(instrucciones,recursoPregunta,pregunta1,respuesta1,pregunta2,respuesta2,pregunta3,respuesta3,pregunta4,respuesta4,idExamen) values(:instrucciones,:recursoPregunta,:pregunta1,:respuesta1,:pregunta2,:respuesta2,:pregunta3,:respuesta3,:pregunta4,:respuesta4,:idExamen)");
				$insertarPregunta = $dbConn->prepare($query1);
				$insertarPregunta->bindParam(':instrucciones',$_POST['instrucciones'], PDO::PARAM_STR);
				$insertarPregunta->bindParam(':recursoPregunta',$rutaAlmacenarBd, PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':pregunta1',$_POST['txtPregunta1'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta1',$_POST['txtRespuesta1'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':pregunta2',$_POST['txtPregunta2'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta2',$_POST['txtRespuesta2'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':pregunta3',$_POST['txtPregunta3'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta3',$_POST['txtRespuesta3'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':pregunta4',$_POST['txtPregunta4'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':respuesta4',$_POST['txtRespuesta4'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':idExamen',$_POST['idCuestionario'], PDO::PARAM_INT);
				$insertarPregunta->execute();


		break;

		case 4: {

			//echo 'idCuestionar '.$_POST['idCuestionario'].'<br>';
			//echo 'Pregunta '.$_POST['txtPregunta'].'<br>';
			//echo 'Respuesta a comparar'.$_POST['txtComparar'].'<br>';

			if(!empty($_FILES["file4"]['name'])){

			//echo 'Hay Recurso '.$_FILES["file4"]['name'].'<br>';
			
			$archivoCargado=$_FILES['file4']['tmp_name'];
			$rutaAlmacenarRecurso='../cursos/recursosPrueba/'.$_FILES['file4']['name'];
		    $rutaAlmacenarBd= 'cursos/recursosPrueba/'.$_FILES['file4']['name'];

		   // echo 'se almaceno recurso Prueba en '.$rutaAlmacenarBd;

			move_uploaded_file($archivoCargado,$rutaAlmacenarRecurso);

			}else{

			//echo 'No tiene recurso la pregunta<br>';
			$rutaAlmacenarBd='';

			}

		}


			$query1 = ("INSERT INTO cuestionarioRespuestaCorta(pregunta,recursoPregunta,textoComparar,idExamen) values(:pregunta,:recursoPregunta,:textoComparar,:idExamen)");
				$insertarPregunta = $dbConn->prepare($query1);
				$insertarPregunta->bindParam(':pregunta',$_POST['txtPregunta'], PDO::PARAM_STR);
				$insertarPregunta->bindParam(':recursoPregunta',$rutaAlmacenarBd, PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':textoComparar',$_POST['txtComparar'], PDO::PARAM_STR);
			    $insertarPregunta->bindParam(':idExamen',$_POST['idCuestionario'], PDO::PARAM_INT);
				$insertarPregunta->execute();



		break;

		case 5:


		$fechaEntregaCompleta= $_POST['fechaEntrega'].' '.$_POST['horaEntrega'];

		$q1 = ("UPDATE  examenesCurso SET titulo=:titulo,instrucciones=:instrucciones,idTema=:idTema,punteo=:punteo,fechaExamen=:fechaExamen,idProfesor=:idProfesor,idCurso=:idCurso,fechaRegistro=:fechaRegistro where idRegistro=:idRegistro ");
			  $insertarDetalleExamen = $dbConn->prepare($q1);
			  $insertarDetalleExamen->bindParam(':titulo',$_POST['tituloPrueba'], PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':instrucciones',$_POST['editor'], PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':idTema',$_POST['idTema'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':punteo',$_POST['punteo'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':fechaExamen',$fechaEntregaCompleta, PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
			  $insertarDetalleExamen->bindParam(':fechaRegistro',$fechaCompleta, PDO::PARAM_STR);
			  $insertarDetalleExamen->bindParam(':idRegistro',$_POST['idCuestionario'], PDO::PARAM_INT);
			  $insertarDetalleExamen->execute();


		break;

		default:


		@$_GET['idCuestionario'];


		$query1 = ("SELECT * FROM cuestionarioOpcionMultiple where idExamenCurso=:idExamenCurso");
			$buscarOpcionMultiple = $dbConn->prepare($query1);
			$buscarOpcionMultiple->bindParam(':idExamenCurso',$_GET['idCuestionario'], PDO::PARAM_INT);
			$buscarOpcionMultiple->execute();
			$hayPregOpcionMultiple=$buscarOpcionMultiple->rowCount();


		$query2 = ("SELECT * FROM cuestionarioEmparejamiento where idExamen=:idExamen");
			$buscarEmparejamiento = $dbConn->prepare($query2);
			$buscarEmparejamiento->bindParam(':idExamen',$_GET['idCuestionario'], PDO::PARAM_INT);
			$buscarEmparejamiento->execute();	
			$hayPregEmparajamiento=$buscarEmparejamiento->rowCount();

	       $query3 = ("SELECT * FROM cuestionarioRespuestaCorta where idExamen=:idExamen");
			$buscarRespCorta = $dbConn->prepare($query3);
			$buscarRespCorta->bindParam(':idExamen',$_GET['idCuestionario'], PDO::PARAM_INT);
			$buscarRespCorta->execute();	
			$hayPregRespuestaCorta=$buscarRespCorta->rowCount();





			echo '
			

			<div><h4>Preguntas Opción Multiple</h4></div>
			<div class="table-responsive">
			<table class="table table-striped responsive"  style="overflow-x: auto">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pregunta</th>
                  <th scope="col">Recurso Preguntas</th>
                  <th scope="col">respuestaCorrecta</th>
                  <th scope="col">Respuesta 1</th>
                  <th scope="col">Respuesta 2</th>
                  <th scope="col">Respuesta 3</th>


                </tr>
              </thead>
              <tbody>';

              if($hayPregOpcionMultiple>=1){
			while ($datos1=$buscarOpcionMultiple->fetch(PDO::FETCH_ASSOC)){
				@$contador+=1;
				$iteradorCompleto=$contador;

         echo   '<tr>
                  <th scope="row">'.$iteradorCompleto.'</th>
                  <td>'.$datos1['pregunta'].'</td>
                  <td>'.$datos1['recursoPregunta'].'</td>
                  <td>'.$datos1['respuestaCorrecta'].'</td>
                  <td>'.$datos1['respuesta1'].'</td>
                  <td>'.$datos1['respuesta2'].'</td>
                  <td>'.$datos1['respuesta3'].'</td>
                </tr>';

               }
              }else{
              	echo   '<tr>
                  <td colspan="11">Aun no hay preguntas opción multiple!!</th>
                </tr>';


              }

           echo      '</tbody>
            		</table>
            		</div>
            		';


           echo '
           	<div class="row table-responsive" >
           	<div><h4>Preguntas Emparejamiento</h4></div>
           <table class="table table-striped">

              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pregunta</th>
                  <th scope="col">Recursos</th>
                  <th scope="col">Opción 1</th>
                  <th scope="col">Resp 1</th>
                  <th scope="col">Opción 2</th>
                  <th scope="col">Resp 2</th>
                  <th scope="col">Opción 3</th>
                  <th scope="col">Resp 3</th>
                  <th scope="col">Opción 4</th>
                  <th scope="col">Resp 4</th>


                </tr>
              </thead>
              <tbody>';


              if($hayPregEmparajamiento>=1){

           while($datos2=$buscarEmparejamiento->fetch(PDO::FETCH_ASSOC)){

				 $iteradorCompleto+=1;
				
         echo   '<tr>
                  <th scope="row">'.$iteradorCompleto.'</th>
                  <td>'.$datos2['instrucciones'].'</td>
                  <td>'.$datos2['recursoPregunta'].'</td>
                  <td>'.$datos2['pregunta1'].'</td>
                  <td>'.$datos2['respuesta1'].'</td>
                  <td>'.$datos2['pregunta2'].'</td>
                  <td>'.$datos2['respuesta2'].'</td>
                  <td>'.$datos2['pregunta3'].'</td>
                  <td>'.$datos2['respuesta3'].'</td>
                  <td>'.$datos2['pregunta4'].'</td>
                  <td>'.$datos2['respuesta4'].'</td>
                </tr>';

               }
           }else{
           	echo   '<tr>
                  <td colspan="11">Aun no hay preguntas de emparejamiento!!</td>
                 
                </tr>';

           }


            echo      '</tbody>
            		</table>
            	 </div>
            		';


           echo '
           	<div class="row table-responsive" >
           	<div><h4>Preguntas Respuesta Corta</h4></div>
           <table class="table table-striped">

              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pregunta</th>
                  <th scope="col">Recursos</th>
                  <th scope="col">Texto a Comparar con Inteligencia Artificial</th>
                </tr>
              </thead>
              <tbody>';


              if($hayPregRespuestaCorta>=1){
           while($datos3=$buscarRespCorta->fetch(PDO::FETCH_ASSOC)){
				
				$iteradorCompleto+=1;

         echo   '<tr>
                  <th scope="row">'.$iteradorCompleto.'</th>
                  <td>'.$datos3['pregunta'].'</td>
                  <td>'.$datos3['recursoPregunta'].'</td>
                  <td style="height:1em; overflow:hidden;">'.$datos3['textoComparar'].'</td>
                </tr>';

               }
              }else{

             echo  '<tr>
                  <td colspan="9">Aun no hay preguntas respuesta corta!!</td>
                  
                </tr>';

               }


              

            echo      '</tbody>
            		</table>
            	 </div>
            		';







		break;
}

?>