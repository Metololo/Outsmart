function refresh_question(){
	request = new XMLHttpRequest();
	request.open("GET","refresh_quiz.php");

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			div = document.getElementById('table-quiz');
			div.innerHTML = request.responseText;

		}
	}

  	request.send();
}