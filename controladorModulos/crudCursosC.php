<?php 

session_start();

require("../conection/conexion.php");

date_default_timezone_set('America/Guatemala');

$fecha_actual=date("d/m/Y");
$fechaCompleta=date('Y-m-d H:i:s',time());

switch ($_POST['eventoEjecutar']) {
	case 1:
		//echo 'nombre Curso '.$_POST['txtNombreCurso'].' idUsuario '.$_POST['idProfesor'];

	//portadaDefault
	$portadaDefault='img/portadasCurso/portadaDefault/font5.jpg';

	//creamosPatCurso para manejo de archivos
	$nombreCarpetaCurso=uniqid('curso');
	$pathCurso='../cursos/archivoCursos/'.$nombreCarpetaCurso.'/';
	$pathTareaCurso='../cursos/archivoCursos/'.$nombreCarpetaCurso.'/tarea/';

	$dirmake = mkdir($pathCurso, 0777);
    $dirTarea= mkdir($pathTareaCurso,0777);
	//formateamos pathCursos par almacenar quitandole el back

	$pathCursoAlmacenar='cursos/archivoCursos/'.$nombreCarpetaCurso.'/';
	$pathTareaCursoAlmacenar='cursos/archivoCursos/'.$nombreCarpetaCurso.'/tearea/';


//crear cursos
    $query1 = ("INSERT INTO curso(nombreCurso,idProfesor,portada,fechaCreacion,grado,seccion,pathCurso,pathTareaCurso) values(:nombreCurso,:idProfesor,:portada,:fechaCreacion,:grado,:seccion,:pathCurso,:pathTareaCurso)");
	$insertarCurso = $dbConn->prepare($query1);
	$insertarCurso->bindParam(':nombreCurso',$_POST['txtNombreCurso'], PDO::PARAM_STR);
	$insertarCurso->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
    $insertarCurso->bindParam(':portada',$portadaDefault, PDO::PARAM_STR);
    $insertarCurso->bindParam(':fechaCreacion',$fechaCompleta, PDO::PARAM_STR);
    $insertarCurso->bindParam(':grado',$_POST['txtGrado'], PDO::PARAM_INT);
    $insertarCurso->bindParam(':seccion',$_POST['seccionGrado'], PDO::PARAM_STR);
    $insertarCurso->bindParam(':pathCurso',$pathCursoAlmacenar, PDO::PARAM_STR);
    $insertarCurso->bindParam(':pathTareaCurso',$pathTareaCursoAlmacenar, PDO::PARAM_STR);
	$insertarCurso->execute();

    break;

    case 2:



    $query1 = ("INSERT INTO temaCurso(idCurso,nombreTema,idProfesor) values(:idCurso,:nombreTema,:idProfesor)");
	$insertarCurso = $dbConn->prepare($query1);
	$insertarCurso->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
    $insertarCurso->bindParam(':nombreTema',$_POST['txtTema'], PDO::PARAM_STR);
	$insertarCurso->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
	$insertarCurso->execute();

    break;

    case 3:
    	# actualizar portada
    	//obtenemos la ruta si es la ruta default creamos directorio
    $query1 = ("SELECT portada FROM curso where idCurso=:idCurso limit 1");
	$buscarRutaPortada = $dbConn->prepare($query1);
	$buscarRutaPortada->bindParam(':idCurso',$_POST['idCurso2'], PDO::PARAM_INT);
	$buscarRutaPortada->execute();


	     while ($datos1=$buscarRutaPortada->fetch(PDO::FETCH_ASSOC)){
	     	
		    $portada = pathinfo($datos1['portada'], PATHINFO_BASENAME);

		    $_SESSION['portadaPersonalizada']=$datos1['portada'];

	     }



	if (strcmp ($portada , 'font5.jpg' ) == 0) {
		$nombreUnico=uniqid('portadaUser');
		
		$directorio = "../img/portadasCurso/portadaPersonalizada/".$nombreUnico."/";
		$dirmake = mkdir($directorio, 0777);

		//echo 'portada Por default - crear directorio y almacenamos el archivo, actualizamos bdCursos <br>directorio creado en :'.$directorio;

    $nombrePortada = $_FILES['file']['name'];
	$archivoCargado=$_FILES['file']['tmp_name'];
	$rutayArchivo= $directorio.$nombrePortada;
	move_uploaded_file($archivoCargado,$rutayArchivo);


	$directoriosinRetroceder="img/portadasCurso/portadaPersonalizada/".$nombreUnico."/";
	$rutaAlmacenar=$directoriosinRetroceder.$nombrePortada;

		//echo '<br>se subio el archivo en '.$directorio.$nombrePortada;
	$q10 = ("UPDATE curso SET portada=:portada where idCurso=:idCurso");
	$actualizarPortada = $dbConn->prepare($q10);
	$actualizarPortada->bindParam(':idCurso',$_POST['idCurso2'], PDO::PARAM_INT);
    $actualizarPortada->bindParam(':portada',$rutaAlmacenar, PDO::PARAM_STR);
	$actualizarPortada->execute();	


	}else{

		$directorio= '../'.$_SESSION['portadaPersonalizada'];
		unlink($directorio); //remove the file





	$nombreArchivoUnico=uniqid('img');
	$extension = pathinfo($_SESSION['portadaPersonalizada'], PATHINFO_EXTENSION);
	$rutaSinArchivo = pathinfo($_SESSION['portadaPersonalizada'], PATHINFO_DIRNAME);




    $nombrePortada2 = $nombreArchivoUnico.'.'.$extension;
	$archivoCargado=$_FILES['file']['tmp_name'];
	$rutayArchivo= '../'.$rutaSinArchivo.'/'.$nombrePortada2;
	move_uploaded_file($archivoCargado,$rutayArchivo);


	$directoriosinRetroceder=$_SESSION['portadaPersonalizada'];
	$rutaAlmacenar=$rutaSinArchivo.'/'.$nombrePortada2;


		//echo 'Se actualizo'.$rutaAlmacenar;


		//echo '<br>se subio el archivo en '.$directorio.$nombrePortada;
	$q10 = ("UPDATE curso SET portada=:portada where idCurso=:idCurso");
	$actualizarPortada = $dbConn->prepare($q10);
	$actualizarPortada->bindParam(':idCurso',$_POST['idCurso2'], PDO::PARAM_INT);
    $actualizarPortada->bindParam(':portada',$rutaAlmacenar, PDO::PARAM_STR);
	$actualizarPortada->execute();		

	
	}

    	break;

    case 4:
    //Como primer paso obtenemos path de curso en caso de que venga adjunto algun archivo

    $q1 = ("SELECT pathCurso FROM  curso where idCurso=:idCurso");
	$buscarPathCurso = $dbConn->prepare($q1);
	$buscarPathCurso->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
	$buscarPathCurso->execute();


  while ($datos1=$buscarPathCurso->fetch(PDO::FETCH_ASSOC)){

  	 $_SESSION['pathCursoFile']='../'.$datos1['pathCurso'];
  	 $_SESSION['pathCursoAlmacenar']=$datos1['pathCurso'];

 		}


 		//buscamos Ultimo Id
    $q2= ("SELECT idPublicacion FROM  publicacionCurso order by  idPublicacion desc limit 1");
	$buscarIdPublicacion = $dbConn->prepare($q2);
	$buscarIdPublicacion->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
	$buscarIdPublicacion->execute();
	$hayPublicacion=$buscarIdPublicacion->rowCount();

	if($hayPublicacion==0){
		$_SESSION['idPublicacion']=1;

	}else{


			  while ($datos2=$buscarIdPublicacion->fetch(PDO::FETCH_ASSOC)){

			  	 $_SESSION['idPublicacion']=$datos2['idPublicacion']+1;

			 		}

   		}


 		//verificamos si hay archivos Adjuntos, para crear path

		if ($_FILES['file2']['name'] != null) {
		
		//si no esta vacio almacenamos datos y ficheros

		echo 'Almacenar en tema :'.$_POST['idTema'].'<br>';	
		echo 'Cuerpo de la publicacion: '.$_POST['textoFormateado'].'<br>';
		echo 'idCurso :'.$_POST['idCurso'].'<br>';
		echo  'idProfesor: '.$_POST['idProfesor'].'<br>';

foreach($_FILES["file2"]['tmp_name'] as $key => $tmp_name)
	{
		//condicional si el fuchero existe
		if($_FILES["file2"]["name"][$key]) {
			// Nombres de archivos de temporales
			$archivonombre = $_FILES["file2"]["name"][$key]; 
			$archivoCargado = $_FILES["file2"]["tmp_name"][$key]; 
			
			$carpetaAlmacenar=$_SESSION['pathCursoFile'].$archivonombre; 

		//movemos los archivos a la carpeta del pat del curso
		move_uploaded_file($archivoCargado, $carpetaAlmacenar);


	$carpetaAlmacenarBd=$_SESSION['pathCursoAlmacenar'].$archivonombre;
		
    $query1 = ("INSERT INTO filesPublicacion(idPublicacion,rutaFile) values(:idPublicacion,:rutaFile)");
	$insertarFilesP = $dbConn->prepare($query1);
	$insertarFilesP->bindParam(':idPublicacion',$_SESSION['idPublicacion'], PDO::PARAM_INT);
    $insertarFilesP->bindParam(':rutaFile',$carpetaAlmacenarBd, PDO::PARAM_STR);
	$insertarFilesP->execute();




		}

		
	}

    $query4 = ("INSERT INTO publicacionCurso(idPublicacion,textPublicacion,idCurso,idProfesor,fechaPublicacion,idTema,urlRecurso) values(:idPublicacion,:textPublicacion,:idCurso,:idProfesor,:fechaPublicacion,:idTema,:urlRecurso)");
	$insertarPublicacion = $dbConn->prepare($query4);
	$insertarPublicacion->bindParam(':idPublicacion',$_SESSION['idPublicacion'], PDO::PARAM_INT);
    $insertarPublicacion->bindParam(':textPublicacion',$_POST['textoFormateado'], PDO::PARAM_STR);
	$insertarPublicacion->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
	$insertarPublicacion->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
	$insertarPublicacion->bindParam(':fechaPublicacion',$fechaCompleta, PDO::PARAM_STR);
	$insertarPublicacion->bindParam(':idTema',$_POST['idTema'], PDO::PARAM_INT);
    $insertarPublicacion->bindParam(':urlRecurso',$_POST['urlRecurso'], PDO::PARAM_STR);

	$insertarPublicacion->execute();






		}else{

	   //si no hay archivosAdjuntos	
	
		}


    break;	


    case 5:



    //Como primer paso obtenemos path de curso en caso de que venga adjunto algun archivo

    $q1 = ("SELECT pathCurso FROM  curso where idCurso=:idCurso");
	$buscarPathCurso = $dbConn->prepare($q1);
	$buscarPathCurso->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
	$buscarPathCurso->execute();


	  while ($datos1=$buscarPathCurso->fetch(PDO::FETCH_ASSOC)){

  	 $_SESSION['pathCursoFile']='../'.$datos1['pathCurso'];
  	 $_SESSION['pathCursoAlmacenar']=$datos1['pathCurso'];

 		}


 			//buscamos Ultimo Id
    $q2= ("SELECT idTarea FROM  tareaCurso order by  idTarea desc limit 1");
	$buscarTareas = $dbConn->prepare($q2);
	$buscarTareas->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
	$buscarTareas->execute();
	$hayTareas=$buscarTareas->rowCount();

	if($hayTareas==0){
		$_SESSION['idTarea']=1;

	}else{


			  while ($datos2=$buscarTareas->fetch(PDO::FETCH_ASSOC)){

			  	 $_SESSION['idTarea']=$datos2['idTarea']+1;

			 		}

   		}



   	//verificamos si hay archivos Adjuntos, para crear path

		if ($_FILES['file3']['name'] != null) {
		
		//si no esta vacio almacenamos datos y ficheros



foreach($_FILES["file3"]['tmp_name'] as $key => $tmp_name)
	{
		//condicional si el fichero existe
		if($_FILES["file3"]["name"][$key]) {
			// Nombres de archivos de temporales
			$archivonombre = $_FILES["file3"]["name"][$key]; 
			$archivoCargado = $_FILES["file3"]["tmp_name"][$key]; 
			
			$carpetaAlmacenar=$_SESSION['pathCursoFile'].$archivonombre; 

			
		//movemos los archivos a la carpeta del pat del curso
		move_uploaded_file($archivoCargado, $carpetaAlmacenar);


	$carpetaAlmacenarBd=$_SESSION['pathCursoAlmacenar'].$archivonombre;



    $query1 = ("INSERT INTO filesTarea(idTarea,rutaFile) values(:idTarea,:rutaFile)");
	$insertarFileTarea = $dbConn->prepare($query1);
	$insertarFileTarea->bindParam(':idTarea',$_SESSION['idTarea'], PDO::PARAM_INT);
    $insertarFileTarea->bindParam(':rutaFile',$carpetaAlmacenarBd, PDO::PARAM_STR);
	$insertarFileTarea->execute();

	


		}

		
	}



	/**
			echo 'idTarea seleccionado :'.$_SESSION['idTarea'].'<br>';
		    echo 'idTema seleccionado :'.$_POST['idTema2'].'<br>';
    		echo 'idProfesor seleccionado :'.$_POST['idProfesor'].'<br>';
    		echo 'idCurso seleccionado :'.$_POST['idCurso'].'<br>';
    		echo 'Titulo seleccionado :'.$_POST['titulo'].'<br>';
    		echo 'Descripcion seleccionado :'.$_POST['textoFormateado'].'<br>';
    		echo 'URL youtube :'.$_POST['urlRecurso'].'<br>';
    		echo 'Punteo:'.$_POST['punteo'].'<br>';
    		echo 'fechaEntrega:'.$_POST['fechaEntrega'].'<br>';
    		echo 'fechaRegistro:'.$fechaCompleta.'<br>';
*/


   $fechaInsertarCompleta= $_POST['fechaEntrega'].' '.$_POST['horaEntrega'];

    $query4 = ("INSERT INTO tareaCurso(idTarea,titulo,descripcion,urlRecurso,punteo,fechaEntrega,idCurso,idProfesor,fechaRegistro,idTema) values(:idTarea,:titulo,:descripcion,:urlRecurso,:punteo,:fechaEntrega,:idCurso,:idProfesor,:fechaRegistro,:idTema)");
	$insertarTarea = $dbConn->prepare($query4);
	$insertarTarea->bindParam(':idTarea',$_SESSION['idTarea'], PDO::PARAM_INT);
    $insertarTarea->bindParam(':titulo',$_POST['titulo'], PDO::PARAM_STR);
	$insertarTarea->bindParam(':descripcion',$_POST['textoFormateado'], PDO::PARAM_STR);
	$insertarTarea->bindParam(':urlRecurso',$_POST['urlRecurso'], PDO::PARAM_STR);
	$insertarTarea->bindParam(':punteo',$_POST['punteo'], PDO::PARAM_INT);
	$insertarTarea->bindParam(':fechaEntrega',$fechaInsertarCompleta, PDO::PARAM_STR);
    $insertarTarea->bindParam(':idCurso',$_POST['idCurso'], PDO::PARAM_INT);
    $insertarTarea->bindParam(':idProfesor',$_POST['idProfesor'], PDO::PARAM_INT);
    $insertarTarea->bindParam(':fechaRegistro',$fechaCompleta, PDO::PARAM_STR);
    $insertarTarea->bindParam(':idTema',$_POST['idTema2'], PDO::PARAM_INT);
	$insertarTarea->execute();



    
    	



		}else{

	   //si no hay archivosAdjuntos	
	
		}




    	break;

    	case 6:
    		#insertarNota de tareas y otros datos


    		$idTareaInsertar=$_POST['idTarea'.$_POST['idUsuario']];
    		$fechaCacionInsertar=$_POST['fechaCalificar'.$_POST['idUsuario']];



		    

			   $query1 = ("UPDATE  cursoGestorTarea SET punteo=:calificacionTarea, fechaRegistroCalificacion=:fechaCalificacion where idUsuario=:idAlumno and idTarea=:idTarea");
		    
			$insertarNota = $dbConn->prepare($query1);
		    $insertarNota->bindParam(':calificacionTarea',$_POST['nota'], PDO::PARAM_INT);
		    $insertarNota->bindParam(':fechaCalificacion',$fechaCacionInsertar, PDO::PARAM_STR);
		    $insertarNota->bindParam(':idAlumno',$_POST['idUsuario'], PDO::PARAM_INT);
		    $insertarNota->bindParam(':idTarea',$idTareaInsertar, PDO::PARAM_INT);
			$insertarNota->execute();


    		break;
        case 7:
    		#insertarComentario de tareas y otros datos

        	$idTareaInsertar=$_POST['idTarea'.$_POST['idUsuario']];
    		$fechaCacionInsertar=$_POST['fechaCalificar'.$_POST['idUsuario']];


    		

			   $query1 = ("UPDATE  cursoGestorTarea SET comentarioDocente=:retroalimentacion, fechaRegistroCalificacion=:fechaCalificacion where idUsuario=:idAlumno and idTarea=:idTarea");
		    
			$insertarNota = $dbConn->prepare($query1);
			$insertarNota->bindParam(':idTarea',$idTareaInsertar, PDO::PARAM_INT);
		    $insertarNota->bindParam(':idAlumno',$_POST['idUsuario'], PDO::PARAM_INT);
		    $insertarNota->bindParam(':retroalimentacion',$_POST['comentario'], PDO::PARAM_STR);
		    $insertarNota->bindParam(':fechaCalificacion',$fechaCacionInsertar, PDO::PARAM_STR);
			$insertarNota->execute();

		
         break;

	
	default:
		
		break;
}

?>