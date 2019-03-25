<?php
$EXT_CONF['nonconfo'] = array(
	'title' => 'Non Conformities Extension',
	'description' => 'This extension handles records of non conformities for each process',
	'disable' => false,
	'version' => '1.0.0',
	'releasedate' => '2017-05-17',
	'author' => array('name'=>'Herson Cruz', 'email'=>'herson@multisistemas.com.sv', 'company'=>'<a href=http://multisistemas.com.sv>Multisistemas</a>'),
	'config' => array(
		/*'input_field' => array(
			'title'=>'Default alert days',
			'type'=>'input',
			'size'=>10,
		),*/
		'checkbox' => array(
			'title'=>'Active/Deactivate extension',
			'type'=>'checkbox',
		),
	),
	'constraints' => array(
		'depends' => array('php' => '5.4.4-', 'seeddms' => '4.3.0-'),
	),
	'icon' => 'icon.png',
	'class' => array(
		'file' => 'class.nonconfo.php',
		'name' => 'SeedDMS_ExtNonConfo'
	),
	/*'language' => array(
		'es_ES' => 'languages/es_ES/es_ES.php',
		'en_GB' => 'languages/en_GB/en_GB.php',
	),*/
);
?>
