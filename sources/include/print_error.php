<?php 

	function invalid_class($type_msg){
		if(isset($_GET[$type_msg]) && !empty($_GET[$type_msg])){
				echo 'is-invalid';
		}
	}

	function bad_feedback($type_msg){
		if(isset($_GET[$type_msg]) && !empty($_GET[$type_msg])){
		
			echo '<div class="invalid-feedback">
	        			'. htmlspecialchars($_GET[$type_msg]) .'
	      			</div>';		
		}
	}

	function validate_msg($msg){
		if(isset($msg) && !empty($msg)){
		
				echo '<div class="validate">
						<div>
		        	'. htmlspecialchars($msg) .' ✌</div>
		        		</div>';		
				}

	}


?>