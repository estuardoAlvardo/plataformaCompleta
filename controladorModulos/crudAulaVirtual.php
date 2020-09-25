<?php 
session_start();

			require("../conection/conexion.php");

			date_default_timezone_set('America/Guatemala');

			$fecha_actual=date("d/m/Y");
			$fechaCompleta=date('Y-m-d H:i:s',time());


switch ($_POST['eventoEjecutar']) {
	case 1:
			#crear aula virtual de grado
			

			//validacion de alumnos en otro curso
			 $query2 = ("SELECT * FROM aulaVirtual where grado=:grado and seccion=:seccion");
			 $validarGrado = $dbConn->prepare($query2);
			 $validarGrado->bindParam(':grado',$_POST['grado'], PDO::PARAM_INT);
			 $validarGrado->bindParam(':seccion',$_POST['seccion'], PDO::PARAM_STR);
			 $validarGrado->execute();
			 $hayAulaActiva= $validarGrado->rowCount();

			 

			 if($hayAulaActiva>=1){

			 	while ($datos1=$validarGrado->fetch(PDO::FETCH_ASSOC)){
	     	
				    $_SESSION['nombreProfesor']=$datos1['nombreProfesor'];

			     }

			 	echo '<div class="notificacionAulaVirtualFalse boxCard"><h4> Grado aun en clase, Nombre del docente dando clases <em>'. $_SESSION['nombreProfesor'].'.</em></h4></div>';

			 }else{

			 //Buscamos si ya creo curso el docente
			 $query2 = ("SELECT * FROM aulaVirtual where idUsuario=:idUsuario");
			 $validamosInsertUsuario = $dbConn->prepare($query2);
			 $validamosInsertUsuario->bindParam(':idUsuario',$_POST['idUsuario'], PDO::PARAM_INT);
			 $validamosInsertUsuario->execute();
			 $yaCreoCursoDocente= $validamosInsertUsuario->rowCount();

			 if($yaCreoCursoDocente>=1){
			 	 //crear cursos
		    $query1 = ("UPDATE  aulaVirtual set grado=:grado, uriAula=:uriAula, nombreReunion=:nombreReunion, seccion=:seccion where idUsuario=:idUsuario");
			$actualizarCurso = $dbConn->prepare($query1);
			$actualizarCurso->bindParam(':grado',$_POST['grado'], PDO::PARAM_INT);
		    $actualizarCurso->bindParam(':uriAula',$_POST['uriAula'], PDO::PARAM_STR);
		    $actualizarCurso->bindParam(':nombreReunion',$_POST['nombreReunion'], PDO::PARAM_STR);
		    $actualizarCurso->bindParam(':seccion',$_POST['seccion'], PDO::PARAM_STR);
		    $actualizarCurso->bindParam(':idUsuario',$_POST['idUsuario'], PDO::PARAM_INT);
			$actualizarCurso->execute();

			echo '<div class="notificacionAulaVirtualTrue boxCard"><img src="../img/atomoLive.png" width="50" heigth="50"><h4> Se actualizo nuevo curso de manera correcta el aula virtual, los alumnos ya podrán acceder.</h4></div>';


			 }else{

		    //crear cursos
		    $query1 = ("INSERT INTO aulaVirtual(idUsuario,grado,uriAula,nombreReunion,seccion,nombreProfesor) values(:idUsuario,:grado,:uriAula,:nombreReunion,:seccion,:nombreProfesor)");
			$insertarCurso = $dbConn->prepare($query1);
			$insertarCurso->bindParam(':idUsuario',$_POST['idUsuario'], PDO::PARAM_INT);
			$insertarCurso->bindParam(':grado',$_POST['grado'], PDO::PARAM_INT);
		    $insertarCurso->bindParam(':uriAula',$_POST['uriAula'], PDO::PARAM_STR);
		    $insertarCurso->bindParam(':nombreReunion',$_POST['nombreReunion'], PDO::PARAM_STR);
		    $insertarCurso->bindParam(':seccion',$_POST['seccion'], PDO::PARAM_STR);
		    $insertarCurso->bindParam(':nombreProfesor',$_POST['nombreDocente'], PDO::PARAM_STR);
			$insertarCurso->execute();

			echo '<div class="notificacionAulaVirtualTrue boxCard"><img src="../img/atomoLive.png" width="50" heigth="50"><h4> Se creo de manera correcta el aula virtual, los alumnos ya podrán acceder.</h4></div>'.$_POST['idUsuario'];
			}

		}

		 	
		
		break;
	
	default:
		# code...
		break;
}


?>