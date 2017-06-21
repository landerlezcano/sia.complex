<?php 

#$db = new mysqli('cuamcentral.db.11569157.hostedresource.com', 'cuamcentral', 'cenCUAM#2016', 'cuamcentral');

$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$database = $argv[4];
$data = $argv[5] ? $argv[5] : false;

$db = new mysqli($host, $user, $pass, $database);
if (!$db) {
    die('No pudo conectarse: ' . mysql_error());
}
echo 'Conectado satisfactoriamente <br/>';

if(!$data){
	$db->close();
}

$query = "update cm_content set introtext = '".$data."' where id =  16";

$result = $db->query($query);

if(! $result) {
      die('Could not enter data: ' . $db->error());
}

echo "Pagina Actualizada";

/*if($result){
     // Cycle through results
    while ($row = $result->fetch_object()){
        echo $row->introtext;
    }
    // Free result set
    $result->close();
    $db->more_results();
}*/

$db->close();
