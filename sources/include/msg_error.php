<?php 

	function error_msg($location,$error,$msg){
		header('location:' . $location .'.php?' . $error . '=' . $msg);
		exit;
	}

	function verif_champ($type,$location,$error,$msg){
		if(!isset($type) || empty($type)){
			error_msg($location,$error,$msg);
		}
	}

?>