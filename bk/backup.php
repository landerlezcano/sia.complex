#!/usr/bin/php
<?php

echo "Leyendo datos...";
	
	//$base="/var/www";
	//$project="/sia.cuam";
	$base="/home/content/57/11569157/html"; 
	$project="/sia.cuam";
	$db_config=$base.$project."/application/config/database.php";
	//$page = "http://sia.cuam";
	$page = "http://cursos.cuam.org";

echo "\n>OK\nCargando base de datos...";
		
	$linea="";
	$file = fopen($db_config, "r");
	while(!feof($file)){
		$linea.=fgets($file)."\n";
	}
	fclose($file);
			
	$val="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');";
	$texto=str_replace($val, "<?php ", $linea);
		  
	$fp2 = fopen($base.$project."/bk/db_access.php", "w"); 
	fputs($fp2, $texto);
	fclose($fp2);
		
	include($base.$project."/bk/db_access.php");
echo "\n>OK\nCreando dump...";
	exec($base.$project."/bk/bk_daily.sh ".$db['default']['hostname']." ".$db['default']['username']." ".$db['default']['password']." ".$db['default']['database']);
echo "\n>OK\n\n!Dump creado con exito!\n";

#Actualizar Webs CUAM
echo "\n\n>!Nuevo bash: Actualizar Webs CUAM...\n";
	$query = shell_exec($base.$project."/sedes.sh ".$db['default']['hostname']." ".$db['default']['username']." ".$db['default']['password']." ".$db['default']['database']);
    
	$sedes = explode("\n", $query);
	$atributos = explode("	", $sedes[0]);
	unset($sedes[sizeof($sedes)-1]);
	unset($sedes[0]);
	$sedes = setArray ( $page, $sedes, $atributos);
    $sedes = groupArray ( $sedes );	
	
	foreach ($sedes as $sede){
		$hoy = '';
		$proximo = '';
		foreach ($sede["data"] as $datos){
			$tabla = setDataCurso ( $datos);
			($datos["tiempo"]=='hoy') ?  $hoy.= $tabla : $proximo.=$tabla;
		}
		$content = '[row]
						[col class="span12"]
							[tab id="tab1" class="tabbale" button="nav-tabs"]
								[tab_item title="Hoy"]
										[accordion id="sc-accordion"]
											'.$hoy.'
										[/accordion]
								[/tab_item]
								[tab_item title="Proximamente"]
										[accordion id="sc-accordion2"]
											'.$proximo.'
										[/accordion]
								[/tab_item]
							[/tab]
						[/col]
					[/row]';
		$js = '';
		$data =  $content . $js;
		
		$host = $sede["host"];
		$user = $sede["user"];
		$pass = $sede["pass"];
		$db = $sede["db"];
		
		executeWeb ( $host, $user, $pass, $db, $data );
	}
	
echo "\n>OK\n\n!Webs Actualizadas con exito!\n";

function setDataCurso($dato) {
	
	setlocale(LC_TIME,"es_ES.UTF-8");
	
	$nombre = utf8_decode($dato["nombre"]);
	$image = $dato["image"];
	$inicio = $dato["inicio"];
	$fin = $dato["fin"];
	$hora0 = $dato["hora0"];
	$hora1 = $dato["hora1"];
	$curso = utf8_decode($dato["curso"]);
	$descripcion = utf8_decode($dato["descripcion"]);
	$facultad = utf8_decode($dato["facultad"]);
	$oferta = utf8_decode($dato["oferta"]);
	
	$inicio = ucfirst(utf8_decode(strftime("%A, %d de %B de %Y", strtotime($inicio))));
	$fin = ucfirst(utf8_decode(strftime("%A, %d de %B de %Y", strtotime($fin))));
	$hora0 = date("g:i a",strtotime(substr($hora0, 0,8)));
	$hora1 = date("g:i a",strtotime(substr($hora1, 0,8)));		
	
	
	$tabla = '[accordion_item title="'.$nombre.'"]
					<div clas="row">
						<div class="span2">
							<img src="'.$image.'" alt="logo" title="logo" width="100%"/>
						</div>
						<div class="span7">
							<h1>'.$nombre.'</h1><em>'.$curso.'</em>
							<h2>Inicio:  '.$inicio.'<br/>Finalizaci&oacute;n: '.$fin.' </h2>
							<h2>Horario:  Desde las '.$hora0.' hasta las '.$hora1.' </h2>
							<hr/>
							<div class="span12">
								<blockquote><h4><strong>Descripci&oacute;n del Evento:</strong>  <br/><br/>'.$descripcion.'</h4></blockquote>
							</div>
							<hr class="span12"/>
							<div class="span12">
								<blockquote><h2>Tema : '.$facultad.'<br/>Tipo : '.$oferta.'</h2></blockquote>
							</div>
						</div>
						<div class="span2 pull-right">
							<a href="#" class="btn btn-primary">Comprar</a>
						</div>
					</div>
				[/accordion_item]';

	// $tabla = "<div class=\'span10\'><ul class=\'plan\'><li class=\'plan-name\'>Nombre del Curso :</li><li class=\'plan-details\'><ul><li>".$dato->nombre."</li></ul></li></ul></div></div></div>";

	return $tabla;
}

function setArray($page, $sedes, $atributos) {
	for ($i = 1 ; $i <= sizeof($sedes) ; $i++){
		$valores = explode("	", $sedes[$i]);
		$sedes[$i] =  array();
		$k = 0;
		foreach ($valores as $valor) {
			
			if($atributos[$k]=="image"){
				$img = explode(",", $valor); 
				$img = ($img[0]=="NULL") ? "/logo.jpg" : $img[0];
				$valor = $page.$img;
			}
			
			if($valor=="NULL")
				$valor = "";
			
			$sedes[$i][$atributos[$k]] = $valor;
			$k++;
		}
	}
	
	return $sedes;
}



function groupArray($sedes) {
	$sedes_array = array();
	foreach ($sedes as $sede){
		$valor = $sede["web"];
		$sedes_array[$valor] = array(
					'host' => $sede["dbhost"],
					'user' => $sede["dbuser"],
					'pass' => $sede["dbkey"],
					'db' => $sede["dbuser"],
					'data' => array()
		);
	}
	foreach ($sedes as $sede){
		$valor = $sede["web"];
		$dato = $sede;
		unset($dato["web"]);
		unset($dato["dbhost"]);
		unset($dato["dbuser"]);
		unset($dato["dbkey"]);
		array_push($sedes_array[$valor]["data"] , $dato);
	}
	return $sedes_array;
}

function executeWeb($host, $user, $pass, $db, $data) {
	$phpEXE = "sh";
	$phpFILE = $base.$project."/curso.sh";
	$params = " '" . $host . "' '" . $user . "' '" . $pass . "' '" . $db . "' '" . $data . "'";
	$comando = $phpEXE . " " . $phpFILE . $params;
	$salida = shell_exec ( $comando );

	return "<hr/>$salida<hr/>";

	// exit();
}

function executeWebPHP($host, $user, $pass, $db, $data) {
	$phpEXE = "php5";
	$phpFILE = getcwd () . "/curso.php";
	$params = " '" . $host . "' '" . $user . "' '" . $pass . "' '" . $db . "' '" . $data . "'";
	$comando = $phpEXE . " " . $phpFILE . $params;
	$salida = shell_exec ( $comando );
	
	echo "<hr/>$salida<hr/>";

	// exit();
}

