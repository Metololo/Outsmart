<?php 
	function super_error($name,$strong){
		if(!empty($_GET[$name] && isset($_GET[$name]))){
			echo '<div class="alert alert-danger" role="alert">
						<strong>' . $strong . '</strong> '. htmlspecialchars($_GET[$name]) .' 
				  </div>';
		}
	}

	function super_sucess($name,$strong){

		if(!empty($_GET[$name] && isset($_GET[$name]))){
			echo 	'<div class="alert alert-success" role="alert">
  						<strong>' . $strong . '</strong> '. htmlspecialchars($_GET[$name]) .'
					</div>';
		}

		
	}

?>