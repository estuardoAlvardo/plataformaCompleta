<?php 


session_start();

require("../conection/conexion.php");

date_default_timezone_set('America/Guatemala');
$fecha_actual=date("d/m/Y");
$fechaCompleta=date('Y-m-d H:i:s',time());

$eventoEjecutar=$_POST['eventoEjecutar'];
switch ($eventoEjecutar) {
	case 1:
		# ingresarTareas

		//obtener path de curso y tarea


		    $q1 = ("SELECT pathTareaCurso FROM  curso where idCurso=:idCurso");
			$buscarPathTarea = $dbConn->prepare($q1);
			$buscarPathTarea->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
			$buscarPathTarea->execute();

			while ($datos1=$buscarPathTarea->fetch(PDO::FETCH_ASSOC)){
		     $_SESSION['pathTareaFile']='../'.$datos1['pathTareaCurso'];

		    $_SESSION['pathTarea']=$datos1['pathTareaCurso'];
			}


			echo 'idAlumno '.$_POST['idAlumno'].'<br>';
			echo 'idCurso '.$_POST['idCurso'].'<br>';
			echo 'idTarea '.$_POST['idTarea'].'<br>';
			echo 'Comentario Alumno '.$_POST['comentarioAlumno'].'<br>';


		    $query2 = ("INSERT INTO cursoGestorTarea(idTarea,idUsuario,comentario,fechaRegistroAlumno) VALUES(:idTarea,:idUsuario,:comentario,:fechaRegistroAlumno)");
			$insertarEntrega = $dbConn->prepare($query2);
			$insertarEntrega->bindParam(':idTarea',$_POST['idTarea'], PDO::PARAM_INT);
			$insertarEntrega->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
			$insertarEntrega->bindParam(':comentario',$_POST['comentarioAlumno'], PDO::PARAM_STR);
			$insertarEntrega->bindParam(':fechaRegistroAlumno',$fechaCompleta, PDO::PARAM_STR);
			$insertarEntrega->execute();


			if ($_FILES['file3']['name'] != null) {

				echo 'hay ficheros a almacenar';

				echo 'mover a la carpeta '.$_SESSION['pathTareaFile'].'<br>';
				echo  'almacenar en bd '.$_SESSION['pathTarea'].'nombreArchivo.ext';

		foreach($_FILES["file3"]['tmp_name'] as $key => $tmp_name)
	   {
		//condicional si el fuchero existe
		if($_FILES["file3"]["name"][$key]) {
			// Nombres de archivos de temporales
			$archivonombre = $_FILES["file3"]["name"][$key]; 
			$archivoCargado = $_FILES["file3"]["tmp_name"][$key]; 
			
			$carpetaAlmacenar=$_SESSION['pathTareaFile'].$archivonombre; 

		//movemos los archivos a la carpeta del pat del curso
		move_uploaded_file($archivoCargado, $carpetaAlmacenar);


	$carpetaAlmacenarBd=$_SESSION['pathTarea'].$archivonombre;
		
    $query1 = ("INSERT INTO filesGestorTareaAlumno(idTarea,idAlumno,rutaFile) values(:idTarea,:idAlumno,:rutaFile)");
	$insertarFilesP = $dbConn->prepare($query1);
	$insertarFilesP->bindParam(':idTarea',$_POST['idTarea'], PDO::PARAM_INT);
    $insertarFilesP->bindParam(':idAlumno',$_SESSION['idUsuario'], PDO::PARAM_STR);
	$insertarFilesP->bindParam(':rutaFile',$carpetaAlmacenarBd, PDO::PARAM_STR);
	$insertarFilesP->execute();

		}
		
	}


			}else{

				echo 'no hay ficheros para almacenar';
			}



		break;
	
	default:
		# code...
		break;
}


?>