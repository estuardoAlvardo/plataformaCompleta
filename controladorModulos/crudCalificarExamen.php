<?php 
session_start();

			require("../conection/conexion.php");

			date_default_timezone_set('America/Guatemala');

			$fecha_actual=date("d/m/Y");
			$fechaCompleta=date('Y-m-d H:i:s',time());

switch ($_POST['eventoEjecutar']) {
	case 1:
		# guardarRegistro de examen


//cantidad preguntasOpcionMultiple
   $examenes=("SELECT * from examenesCurso where idRegistro=:idExamen");
   $buscarExamen = $dbConn->prepare($examenes);
   $buscarExamen->bindparam(':idExamen', $_POST['idExamen']);
   $buscarExamen->execute();

while(@$datosExamen=$buscarExamen->fetch(PDO::FETCH_ASSOC)){
		$_SESSION['punteoQuiz']=$datosExamen['punteo'];
}

//cantidad preguntasOpcionMultiple
   $sql2=("SELECT * from cuestionarioOpcionMultiple where idExamenCurso=:idExamen");
   $buscarOpcionMultiple = $dbConn->prepare($sql2);
   $buscarOpcionMultiple->bindparam(':idExamen', $_POST['idExamen']);
   $buscarOpcionMultiple->execute();
   $cantidadOpcionMultiple=$buscarOpcionMultiple->rowCount();

//Cantidad preguntasEmparejamiento

   $sqlEmp=("SELECT * from cuestionarioEmparejamiento where idExamen=:idExamen");
   $buscarEmparejamiento = $dbConn->prepare($sqlEmp);
   $buscarEmparejamiento->bindparam(':idExamen', $_POST['idExamen']);
   $buscarEmparejamiento->execute();
   $cantidadEmparejamiento=$buscarEmparejamiento->rowCount();

//cantidadItem respuesta corta

   $sqlRespuestaCorta=("SELECT * from cuestionarioRespuestaCorta where idExamen=:idExamen");
   $buscarRespCorta = $dbConn->prepare($sqlRespuestaCorta);
   $buscarRespCorta->bindparam(':idExamen', $_POST['idExamen']);
   $buscarRespCorta->execute();
   $cantidadRespCorta=$buscarRespCorta->rowCount();



$cantidadPreguntasQuiz=$cantidadOpcionMultiple+$cantidadEmparejamiento+$cantidadRespCorta;

$punteoItem=$_SESSION['punteoQuiz']/$cantidadPreguntasQuiz;
$punteoQuiz=0;


   		$identificadorCalificador= hexdec(uniqid());
   		//echo 'idRegistroCalificado '.$identificadorCalificador.'<br>';
		//echo 'idExamen: '.$_POST['idExamen'].'<br>';
		//echo 'idUsuario: '.$_POST['idUsuario'].'<br>';
		//echo 'Hora Registro '.$_POST['tiempo'].'<br>';
		//echo 'Fecha Regsitro '.$fechaCompleta.'<br>';



while(@$datosOpcionMultiple=$buscarOpcionMultiple->fetch(PDO::FETCH_ASSOC)){
	@$i+=1;  
		//echo 'Respuesta Opcion Multiple '.$i.': '.$_POST['multiple'.$datosOpcionMultiple['idRegistro']].' Punteo '.round($punteoItem,2).'<br>';
	

		//calificamos y damos un punteo

		if($datosOpcionMultiple['respuestaCorrecta']==$_POST['multiple'.$datosOpcionMultiple['idRegistro']]){
			$punteoQuiz+=$punteoItem;
		}else{
			$punteoQuiz+=0;
		}








		//insertamos respuestas que el alumno respondio
		$respuestasOpcionMultiple=("INSERT INTO cuestionarioROpcionMultiple(idQuizCalificado,idUsuario,idPregunta,respuesta)VALUES(:idQuizCalificado,:idUsuario,:idPregunta,:respuesta)");
		   $insertarResOpcion = $dbConn->prepare($respuestasOpcionMultiple);
		   $insertarResOpcion->bindparam(':idQuizCalificado', $identificadorCalificador, PDO::PARAM_STR);
		   $insertarResOpcion->bindparam(':idUsuario', $_POST['idUsuario'], PDO::PARAM_INT);
		   $insertarResOpcion->bindparam(':idPregunta', $_POST['idPregunta'.$datosOpcionMultiple['idRegistro']], PDO::PARAM_INT);
		   $insertarResOpcion->bindparam(':respuesta', $_POST['multiple'.$datosOpcionMultiple['idRegistro']], PDO::PARAM_INT);
		   $insertarResOpcion->execute();

         


		}


		echo 'punteo quiz opcionMultiple '.$punteoQuiz.'<br>';

while(@$datosEmparejamiento=$buscarEmparejamiento->fetch(PDO::FETCH_ASSOC)){
			
			$respuestasEmparejamiento=("INSERT INTO cuestionarioREmparejamiento(idQuizCalificado,idUsuario,idPregunta,opcion1,opcion2,opcion3,opcion4)VALUES(:idQuizCalificado,:idUsuario,:idPregunta,:opcion1,:opcion2,:opcion3,:opcion4)");
		   $insertarEmparejamiento = $dbConn->prepare($respuestasEmparejamiento);
		   $insertarEmparejamiento->bindparam(':idQuizCalificado', $identificadorCalificador, PDO::PARAM_STR);
		   $insertarEmparejamiento->bindparam(':idUsuario', $_POST['idUsuario'], PDO::PARAM_INT);
		   $insertarEmparejamiento->bindparam(':idPregunta', $_POST['idEmparejamiento'.$datosEmparejamiento['idRegistro']], PDO::PARAM_INT);

		   $punteoFraccionado=$punteoItem/4;
		   $punteoEmparejamiento=0;

			for ($j=1; $j <=4 ; $j++) {

				//calificar pregunta
				if(isset($_POST['pregunta'.$datosEmparejamiento['idRegistro'].'opt'.$j])==true){

				if($datosEmparejamiento['respuesta'.$j]==$_POST['pregunta'.$datosEmparejamiento['idRegistro'].'opt'.$j]){

					$punteoEmparejamiento+=$punteoFraccionado;


				}else{

					$punteoEmparejamiento+=0;


				}
			}


			//insertar opciones
			if(isset($_POST['pregunta'.$datosEmparejamiento['idRegistro'].'opt'.$j])==true){
			
			//echo 'Respuesta Emparejamiento pregunta '.$datosEmparejamiento['idRegistro'].' opcion'.$j.' :'. $_POST['pregunta'.$datosEmparejamiento['idRegistro'].'opt'.$j].' Punteo'.round($punteoFraccionado,2).'<br>';

			$opcionR=":opcion".$j;

		   $insertarEmparejamiento->bindparam($opcionR,$_POST['pregunta'.$datosEmparejamiento['idRegistro'].'opt'.$j], PDO::PARAM_STR);




			}else{
				$opcionR=":opcion".$j;
				$insertar='';

		   $insertarEmparejamiento->bindparam($opcionR,$insertar, PDO::PARAM_STR);

			}
		}

		$insertarEmparejamiento->execute();

		
	}

	echo 'punteo quiz emparejamiento '.$punteoEmparejamiento.'<br>';

while(@$datosRespuestaCorta=$buscarRespCorta->fetch(PDO::FETCH_ASSOC)){
    @$l+=1;
			
    		//calificar
    		$porcentajeRespuesta=similar_text($datosRespuestaCorta['textoComparar'], $_POST['input'.$datosRespuestaCorta['idRegistro']]);

    		if($porcentajeRespuesta>=10){
    			$punteoQuiz+=$punteoItem;
    		}else{
    			$punteoQuiz+=0;
    		}


			# insertar respuesta
   // echo 'Respuesta corta pregunta '.$l.':'. $_POST['input'.$datosRespuestaCorta['idRegistro']].' PunteoItem '.round($punteoItem,2).'<br>';

             

		   $respuestaCorta=("INSERT INTO cuestionarioRRespuestaCorta(idQuizCalificado,idUsuario,idPregunta,respuestaAlumno) VALUES(:idQuizCalificado,:idUsuario,:idPregunta,:respuestaAlumno)");
		   $insertarRespuestaCorta = $dbConn->prepare($respuestaCorta);
		   $insertarRespuestaCorta->bindparam(':idQuizCalificado', $identificadorCalificador, PDO::PARAM_STR);
		   $insertarRespuestaCorta->bindparam(':idUsuario', $_POST['idUsuario'], PDO::PARAM_INT);
		   $insertarRespuestaCorta->bindparam(':idPregunta', $_POST['idRespCorta'.$datosRespuestaCorta['idRegistro']], PDO::PARAM_INT);
		   $insertarRespuestaCorta->bindparam(':respuestaAlumno',$_POST['input'.$datosRespuestaCorta['idRegistro']], PDO::PARAM_STR);
		   $insertarRespuestaCorta->execute();

		}	


			echo 'punteo quiz Respuesta Corta '.$punteoQuiz.'<br>';



		$sumaPunteo=$punteoQuiz+$punteoEmparejamiento;

		//echo 'punteo Cuestionario '.ceil($sumaPunteo);
		//insertamos Detalle de cuestionario
		$insertarDetalleExamen=("INSERT INTO registroExamenCalificado(idCuestionarioCalificado,idUsuario,tiempo,fechaRegistro,idExamen,punteoObtenido)VALUES(:idCuestionarioCalificado,:idUsuario,:tiempo,:fechaRegistro,:idExamen,:punteoObtenido)");
		   $insertarDetalle = $dbConn->prepare($insertarDetalleExamen);
		   $insertarDetalle->bindparam(':idCuestionarioCalificado', $identificadorCalificador, PDO::PARAM_STR);

		   $insertarDetalle->bindparam(':idUsuario', $_POST['idUsuario'], PDO::PARAM_INT);
		   $insertarDetalle->bindparam(':tiempo', $_POST['tiempo'], PDO::PARAM_STR);
		   $insertarDetalle->bindparam(':fechaRegistro', $fechaCompleta, PDO::PARAM_STR);
		   $insertarDetalle->bindparam(':idExamen', $_POST['idExamen'], PDO::PARAM_INT);
		   $insertarDetalle->bindparam(':punteoObtenido', $sumaPunteo, PDO::PARAM_INT);
		   $insertarDetalle->execute();
			

		  


		break;
	
	default:
		# code...
		break;
}