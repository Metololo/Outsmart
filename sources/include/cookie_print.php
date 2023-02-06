<?php 

	function cookie_print($name){
		echo isset($_COOKIE[$name]) ? $_COOKIE[$name] : '';
	}	

?>