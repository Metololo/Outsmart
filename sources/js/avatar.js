function select_avatar(){

	request = new XMLHttpRequest();
	request.open("POST","ajax/use_avatar.php");

		request.onreadystatechange = function(){
			if(request.readyState === 4) {
				const div = document.getElementsByClassName('avatar-show');

				div[0].innerHTML = request.responseText;
			}
		}

		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  	request.send();
}