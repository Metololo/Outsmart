<?php 

	date_default_timezone_set("Europe/Paris");
	$date = date("d/m/Y");
	$heure = date("H:i:s");

	function new_log($file,$msg){
		$fichier = fopen($file,'a+');
		fputs($fichier,$msg . "\n");

		fclose($fichier);
	}

?>