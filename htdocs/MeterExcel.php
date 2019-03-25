<?php
header('Content-Type: text/html; charset=utf-8' );
	 include("./inc/inc.Settings.php");
include("./inc/inc.LogInit.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.Authentication.php");
include("./inc/inc.ClassUI.php");

 function add3dots($string, $repl, $limit) 
{
  if(strlen($string) > $limit) 
  {
    return substr($string, 0, $limit) . $repl; 
  }
  else 
  {
    return $string;
  }
}
///////////////////////// OBTENGO PARÁMETROS DESDE EL FORMULARIO
//1 Nombre del ente obligado
$idCarpeta="1"; //valor por defecto
if (isset($_POST["idCarpeta"])) //se envía a través del método POST porque es un formulario
{
	//echo "aqui";
	$idCarpeta=$_POST["idCarpeta"];
	//echo "creador excel: ".$creadorExcel;
}	
//2) nombre del ente obligado
$fichero="";
if (isset($_POST["ficheroExcel"])) //se envía a través del método POST porque es un formulario
{
	$fichero=$_POST["ficheroExcel"];
}	 
//echo "id ingresado: ".$idCarpeta;
//echo "fichero: ".$fichero;


$carpeta=$dms->getFolder($idCarpeta);

$nombreCarpeta=$carpeta->getName();
//echo "Nombre carpeta: ".$nombreCarpeta; 
$row = 1;
if (($handle = fopen($fichero, "r")) !== FALSE) 
{
    while (($data = fgetcsv($handle, 4096, "|")) !== FALSE) 
	{
			if($row!=1)
			{
				echo "Entrada #: ".$row."<br>";
				echo "Tipo de resolución: ".utf8_encode($data[0])."<br>"; $tipoResolucion=utf8_encode($data[0]);
				echo "Año de resolución: ".utf8_encode($data[1])."<br>"; $year=utf8_encode($data[1]);
				echo "Referencia: ".utf8_encode($data[2])."<br>"; $nombre=utf8_encode($data[2]);
				echo "Fecha de resolución: ".utf8_encode($data[3])."<br>"; $fechaResolucion=utf8_encode($data[3]);
				echo "Tipología: ".utf8_encode($data[4])."<br>"; $tipologia=utf8_encode($data[4]);
				echo "Problema jurídico: ".utf8_encode($data[5])."<br>"; $problema=utf8_encode($data[5]);
				echo "Ratio decidiendi ".utf8_encode($data[6])."<br>"; $ratioDecidiendi=utf8_encode($data[6]);
				echo "Decision ".utf8_encode($data[7])."<br>"; $decision=utf8_encode($data[7]);
				echo "Deber ético ".utf8_encode($data[8])."<br>"; $deber=utf8_encode($data[8]);
				echo "Prohibición ética ".utf8_encode($data[9])."<br>"; $prohibiciones=utf8_encode($data[9]);
				echo "--------------------------------<br>";
														
				////////hago la metida como tal
				
				$comment=add3dots($ratioDecidiendi, "...", 45);
				$owner=$dms->getUser(1); //el dueño será el administrador que tiene id1
				$keywords="";
				//categories: mi "tipologia de resolucion" se llama categoria en seeddms
				$arrayTipologias=array();
				$catego=$dms->getDocumentCategoryByName($tipologia);
				if(!$catego)
				{
					echo "No se puede encontrar el catego ".$tipologia;
					exit;
				}

				$idCatego=$catego->getID();
				$arrayTipologias[]=$catego;
				$rutaFichero="./prueba.pdf";
				 $orgFileName=$nombre; //original file name
				 $fileType =".pdf";
				 $mimeType="application/pdf";
				 $sequence=1; //secuencia de meter al final
				 $reviewers = array();
$approvers = array();
$reviewers["i"] = array();
$reviewers["g"] = array();
$approvers["i"] = array();
$approvers["g"] = array();
$workflow = null;

if($settings->_workflowMode == 'traditional' || $settings->_workflowMode == 'traditional_only_approval') {
	if($settings->_workflowMode == 'traditional') {
		// Retrieve the list of individual reviewers from the form.
		if (isset($_POST["indReviewers"])) {
			foreach ($_POST["indReviewers"] as $ind) {
				$reviewers["i"][] = $ind;
			}
		}
		// Retrieve the list of reviewer groups from the form.
		if (isset($_POST["grpReviewers"])) {
			foreach ($_POST["grpReviewers"] as $grp) {
				$reviewers["g"][] = $grp;
			}
		}
	}

	// Retrieve the list of individual approvers from the form.
	if (isset($_POST["indApprovers"])) {
		foreach ($_POST["indApprovers"] as $ind) {
			$approvers["i"][] = $ind;
		}
	}
	// Retrieve the list of approver groups from the form.
	if (isset($_POST["grpApprovers"])) {
		foreach ($_POST["grpApprovers"] as $grp) {
			$approvers["g"][] = $grp;
		}
	}
	// add mandatory reviewers/approvers
	$docAccess = $folder->getReadAccessList($settings->_enableAdminRevApp, $settings->_enableOwnerRevApp);
	if($settings->_workflowMode == 'traditional') {
		$res=$user->getMandatoryReviewers();
		foreach ($res as $r){

			if ($r['reviewerUserID']!=0){
				foreach ($docAccess["users"] as $usr)
					if ($usr->getID()==$r['reviewerUserID']){
						$reviewers["i"][] = $r['reviewerUserID'];
						break;
					}
			}
			else if ($r['reviewerGroupID']!=0){
				foreach ($docAccess["groups"] as $grp)
					if ($grp->getID()==$r['reviewerGroupID']){
						$reviewers["g"][] = $r['reviewerGroupID'];
						break;
					}
			}
		}
	}
	$res=$user->getMandatoryApprovers();
	foreach ($res as $r){

		if ($r['approverUserID']!=0){
			foreach ($docAccess["users"] as $usr)
				if ($usr->getID()==$r['approverUserID']){
					$approvers["i"][] = $r['approverUserID'];
					break;
				}
		}
		else if ($r['approverGroupID']!=0){
			foreach ($docAccess["groups"] as $grp)
				if ($grp->getID()==$r['approverGroupID']){
					$approvers["g"][] = $r['approverGroupID'];
					break;
				}
		}
	}
} elseif($settings->_workflowMode == 'advanced') {
	if(!$workflows = $user->getMandatoryWorkflows()) {
		if(isset($_POST["workflow"]))
			$workflow = $dms->getWorkflow($_POST["workflow"]);
		else
			$workflow = null;
	} else {
		/* If there is excactly 1 mandatory workflow, then set no matter what has
		 * been posted in 'workflow', otherwise check if the posted workflow is in the
		 * list of mandatory workflows. If not, then take the first one.
		 */
		$workflow = array_shift($workflows);
		foreach($workflows as $mw)
			if($mw->getID() == $_POST['workflow']) {$workflow = $mw; break;}
	}
}

				  	$reqversion=1;
					$version_comment="";
				$atributos=array(); //array, cada posicion 
				//id de Año:  14
				//ide de Deberés éticos (array) 4
				//id de decisión: 8
				//id de fecha de resolucion: 1
				//id de problema jurídico: 6
				//id de prohibiciones éticas: 5
				//id de ratio decidiendi: 7
				//id de tipo de resolucion:  13
				$atributos[14]=$year;
				//
				
				
				//Deberes éticos art. 5
				$articulosDeberes=explode(",", $deber);
				echo "deber deberes: ";
				print_r($deber);
				if(count($articulosDeberes)==0)
				{
					switch ($deber) 
					{
						case 'a':
							$recogeDeberes[]="a) Deber de conocer las normas que le son aplicables en razón del cargo: Conocer las disposiciones legales y reglamentarias, permisivas o prohibitivas referentes a incompatibilidad, acumulación de cargos, prohibiciones por razónde parentesco y cualquier otro régimen especial que le sea aplicable.";
							break;


						
						case 'b':
							$recogeDeberes[]="b) Deber de cumplimiento: Cumplir con responsabilidad y buena fe los deberes y obligaciones, como ciudadano y como servidor público.";
							break;

							case 'c':
							$recogeDeberes[]="c) Deber de no discriminación: Desempeñar el cargo sin discriminar, en su actuación, a ninguna persona por razón de raza, color, género, religión, situación económica, ideología, afiliación política.";
							break;

							case 'd':
							$recogeDeberes[]="d) Deber de eficiencia: Utilizar adecuadamente los recursos para cumplir las funciones que le correspondan.";
							break;	
							case 'e':
							$recogeDeberes[]="e) Deber de veracidad: Emitir juicios y opiniones en forma oral o escrita apegados a la verdad.";
							break;	
								case 'f':
							$recogeDeberes[]="f) Deber de confidencialidad: Guardar la discreción debida, respecto de los hechos e informaciones en el ejercicio de sus funciones, siempre que no afecte el interés público.";
							break;	
								case 'g':
							$recogeDeberes[]="g) Deber de excusarse de participar en asuntos sobre los que tiene conflicto de interés: Abstenerse de participar en la toma  de decisiones en donde exista conflicto de interés para el o para sus familiares hasta en el cuarto grado de consanguinidad o segundo de afinidad. La abstención la deberá comunicar a su superior, quien resolverá sobre el punto y en su caso designará un sustituto.";
							break;	
								case 'h':
							$recogeDeberes[]="h) Deber de denuncia: Denunciar, a la autoridad competente, cualquier acto de corrupción, fraude, abuso de poder, despilfarro o violación de las disposiciones de esta ley.";
							break;	
								case 'i':
							$recogeDeberes[]="i) Deber de presentar la declaración jurada de patrimonio: Presentar cuando sea el caso, ante la sección de probidad de la Corte Suprema de Justicia el estado de patrimonio en el tiempo estipulado en la Ley.";
							break;	

					}
				}
				else
				{
					$recogeDeberes=array();
				foreach ($articulosDeberes as $articulo) 
				{
					switch ($articulo) 
					{
						case 'a':
							$recogeDeberes[]="a) Deber de conocer las normas que le son aplicables en razón del cargo: Conocer las disposiciones legales y reglamentarias, permisivas o prohibitivas referentes a incompatibilidad, acumulación de cargos, prohibiciones por razónde parentesco y cualquier otro régimen especial que le sea aplicable.";
							break;


						
						case 'b':
							$recogeDeberes[]="b) Deber de cumplimiento: Cumplir con responsabilidad y buena fe los deberes y obligaciones, como ciudadano y como servidor público.";
							break;

							case 'c':
							$recogeDeberes[]="c) Deber de no discriminación: Desempeñar el cargo sin discriminar, en su actuación, a ninguna persona por razón de raza, color, género, religión, situación económica, ideología, afiliación política.";
							break;

							case 'd':
							$recogeDeberes[]="d) Deber de eficiencia: Utilizar adecuadamente los recursos para cumplir las funciones que le correspondan.";
							break;	
							case 'e':
							$recogeDeberes[]="e) Deber de veracidad: Emitir juicios y opiniones en forma oral o escrita apegados a la verdad.";
							break;	
								case 'f':
							$recogeDeberes[]="f) Deber de confidencialidad: Guardar la discreción debida, respecto de los hechos e informaciones en el ejercicio de sus funciones, siempre que no afecte el interés público.";
							break;	
								case 'g':
							$recogeDeberes[]="g) Deber de excusarse de participar en asuntos sobre los que tiene conflicto de interés: Abstenerse de participar en la toma  de decisiones en donde exista conflicto de interés para el o para sus familiares hasta en el cuarto grado de consanguinidad o segundo de afinidad. La abstención la deberá comunicar a su superior, quien resolverá sobre el punto y en su caso designará un sustituto.";
							break;	
								case 'h':
							$recogeDeberes[]="h) Deber de denuncia: Denunciar, a la autoridad competente, cualquier acto de corrupción, fraude, abuso de poder, despilfarro o violación de las disposiciones de esta ley.";
							break;	
								case 'i':
							$recogeDeberes[]="i) Deber de presentar la declaración jurada de patrimonio: Presentar cuando sea el caso, ante la sección de probidad de la Corte Suprema de Justicia el estado de patrimonio en el tiempo estipulado en la Ley.";
							break;	

					}
				}
				}
				$atributos[4]=$recogeDeberes;
				//Decision
				$decisiones=explode(",", $decision);
				$atributos[8]=$decisiones;
				//Fecha resolucion
				$partidosFecha=explode("/",$fechaResolucion);
				$añito=$partidosFecha[2];
				$mesito=$partidosFecha[1];
				$dita=$partidosFecha[0];
				$fechaFormateada=$añito."-".$mesito."-".$dita;
				$atributos[1]=$fechaFormateada;			
				//problema
				$arrayProblemas=array();
				$arrayProblemas[]=$problema;
				$atributos[6]=$arrayProblemas;
				//prohiciones éticas
				$articulosProhibiciones=explode(",",$prohibiciones);
				echo "prohiciones artis: ";
				print_r($articulosProhibiciones)."<br>";

				if(count($articulosProhibiciones)==0)
				{
					echo "PATO LUCAS----------";
					switch ($prohibiciones) 
					{
						case 'a':
							$recogeProhibiciones[]="a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones";
							break;


						
						case 'b':
							$recogeProhibiciones[]="b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones";
							break;

							case 'c':
							$recogeProhibiciones[]="c) Percibir más de una remuneración proveniente del presupuesto del Estado, cuando las labores deben ejercerse dentro del mismo horario";
							break;

							case 'd':
							echo "caso d";
							$recogeProhibiciones[]="d) Desempeñar simultáneamente dos o más empleos en el sector público que fueren incompatibles entre sí por prohibición expresa de la normativa aplicable, por coincidir en las horas de trabajo o porque vaya en contra de los intereses insitucionales";
							break;	
							case 'e':
							$recogeProhibiciones[]="e) Realizar actividades privadas durante la jornada ordinaria de trabajo";
							break;	
								case 'f':
							$recogeProhibiciones[]="f) Exigir o solicitar a los subordinados que empleen el tiempo ordinario de labores para que realicen actividades que no sean las que se les requiera para el cumplimiento de los fines insitucionales";
							break;	
								case 'g':
							$recogeProhibiciones[]="g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública";
							break;	
								case 'h':
							$recogeProhibiciones[]="h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio";
							break;	
								case 'i':
							$recogeProhibiciones[]="i) Retardar sin motivo legal la prestación de los servicios, trámites o procedimientos administrativos que le corresponden según sus funciones";
							break;	
								case 'j':
							$recogeProhibiciones[]="j) Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, raza, sexo, religión, opinión política, condición social o económica, discapacidad o cualquier otra razón injustificada";
							break;
								case 'k':
							$recogeProhibiciones[]="k) Utilizar indebidamente los bienes muebles o inmuebles de la institución para hacer actos de proselitismo político partidario";
							break;
								case 'l':
							$recogeProhibiciones[]="l) Prevalerse del cargo para hacer política partidista";
							break;

					}
				}
				else
				{
						$recogeProhibiciones=array();
				foreach ($articulosProhibiciones as $articulo) 
				{
					switch ($articulo) 
					{
						case 'a':
							$recogeProhibiciones[]="a) Solicitar o aceptar cualquier bien o servicio de valor económico o beneficio adicional al que percibe por el desempeño de sus labores, por hacer, apresurar, retardar o dejar de hacer tareas o trámites relativos a sus funciones";
							break;


						
						case 'b':
							$recogeProhibiciones[]="b) Solicitar o aceptar cualquier bien o servicio de valor económico, para hacer valer su influencia en razón del cargo que ocupa ante otra persona sujeta a la aplicación de esta Ley, con la finalidad que éste haga, apresure, retarde o deje de hacer tareas o trámites relativos a sus funciones";
							break;

							case 'c':
							$recogeProhibiciones[]="c) Percibir más de una remuneración proveniente del presupuesto del Estado, cuando las labores deben ejercerse dentro del mismo horario";
							break;

							case 'd':
							$recogeProhibiciones[]="d) Desempeñar simultáneamente dos o más empleos en el sector público que fueren incompatibles entre sí por prohibición expresa de la normativa aplicable, por coincidir en las horas de trabajo o porque vaya en contra de los intereses insitucionales";
							break;	
							case 'e':
							$recogeProhibiciones[]="e) Realizar actividades privadas durante la jornada ordinaria de trabajo";
							break;	
								case 'f':
							$recogeProhibiciones[]="f) Exigir o solicitar a los subordinados que empleen el tiempo ordinario de labores para que realicen actividades que no sean las que se les requiera para el cumplimiento de los fines insitucionales";
							break;	
								case 'g':
							$recogeProhibiciones[]="g) Aceptar o mantener un empleo, relaciones contractuales o responsabilidades en el sector privado, que menoscaben la imparcialidad o provoquen un conflicto de interés en el desempeño de su función pública";
							break;	
								case 'h':
							$recogeProhibiciones[]="h) Nombrar, contratar, promover, o ascender en la entidad pública donde ejerce autoridad, a su cónyuge, conviviente, parientes, dentro del cuarto grado de consanguinidad o segundo de afinidad o socio";
							break;	
								case 'i':
							$recogeProhibiciones[]="i) Retardar sin motivo legal la prestación de los servicios, trámites o procedimientos administrativos que le corresponden según sus funciones";
							break;	
								case 'j':
							$recogeProhibiciones[]="j) Denegar a una persona la prestación de un servicio público a que tenga derecho, en razón de su nacionalidad, raza, sexo, religión, opinión política, condición social o económica, discapacidad o cualquier otra razón injustificada";
							break;
								case 'k':
							$recogeProhibiciones[]="k) Utilizar indebidamente los bienes muebles o inmuebles de la institución para hacer actos de proselitismo político partidario";
							break;
								case 'l':
							$recogeProhibiciones[]="l) Prevalerse del cargo para hacer política partidista";
							break;

					}
				}
				}
			
				$atributos[5]=$recogeProhibiciones;
				//ratio
				$atributos[7]=$ratioDecidiendi;
				//tipo de resolucion
				$atributos[13]=$tipoResolucion;
				
				
				//$articulosProhibiciones=explode(",", $prohibiciones);
				//$atributos[5]=$articulosProhibiciones;
				$atributos[7]=$ratioDecidiendi;
				$atributos[13]=$tipoResolucion;
				//////////////////////////////////////////////////////////
					$attributes_version = array();
					foreach($attributes_version as $attrdefid=>$attribute) 
					{
						$attrdef = $dms->getAttributeDefinition($attrdefid);
						if($attribute) 
						{
							if(!$attrdef->validate($attribute)) 
							{
								$errmsg = getAttributeValidationText($attrdef->getValidationError(), $attrdef->getName(), $attribute);
								UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),$errmsg);
							}
						}
					}
				////llamada a función que añade. SEGUN LA API:
				/**
				addDocument(string $name, string $comment, integer $expires, object $owner, string $keywords, array $categories, string $tmpFile, 
				string $orgFileName, string $fileType, string $mimeType, float $sequence, array $reviewers, array $approvers, string $reqversion, 
				string $version_comment, array $attributes, array $version_attributes,  $workflow) : \array/boolean
				**/ 
				
				echo "A meter: <br>";
				echo "nombre: ".$nombre;
				echo "<br> comment: ".$comment;
				echo "<br> attributes: ";
				foreach ($atributos as $atri) 
				{
					print_r($atri);
					echo "<br>";
				}
				$attributes = array();
foreach($attributes as $attrdefid=>$attribute) {
	$attrdef = $dms->getAttributeDefinition($attrdefid);
	if($attribute) {
		if(!$attrdef->validate($attribute)) {
			$errmsg = getAttributeValidationText($attrdef->getValidationError(), $attrdef->getName(), $attribute);
			UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())), $errmsg);
		}
	} elseif($attrdef->getMinValues() > 0) {
		UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),getMLText("attr_min_values", array("attrname"=>$attrdef->getName())));
	}
}
 $todasDefiniciones=$dms->getAllAttributeDefinitions(array(SeedDMS_Core_AttributeDefinition::objtype_document));

				$resu=$carpeta->addDocument($nombre,$comment,0,$owner,$keywords,$arrayTipologias,$rutaFichero,$orgFileName,$fileType,$mimeType,$sequence, $reviewers,$approvers,$reqversion,$version_comment,$atributos,$attributes_version,NULL);
				if(!$resu)
				{
					echo "Error metiendo el documento especificado en la fila_ ".$row;
					exit;
				}
				echo "-*-*-*-*-*-*-*-*-*-*-*-*-METIDO CON EXITO ARCHIVO*/*/*/*/*/*/*/*/*/*/*";
			}		
        $row++;      
    }
    fclose($handle);
}
// $handle = fopen($fichero, 'r');
// while (($entrada = fgetcsv($handle,8096)) !== FALSE) 
// {
   // echo "*************************************";
   // echo "</br>";
  
    // print_r($entrada);
   // echo "</br>";
   // echo "------------------------FIN ENTRADA -------------------";
   // echo "</br>";
// }
// fclose($handle);
echo "SCRIPT TERMINADOR;";
exit;
// ?>