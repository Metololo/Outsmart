demandes();
show_friends();
window.onload = function refresh(){
	refreshing = setInterval(demandes,1000);
	refreshing2 = setInterval(show_friends,500);
}



function accept(r,s){


	const request = new XMLHttpRequest();
	request.open("POST","ajax/accept_friend.php");



	request.onreadystatechange = function(){
		if(request.readyState === 4) {
		}
	}

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	request.send("send=" + s + "&receive=" + r);


}

function unaccept(r,s){


	const request = new XMLHttpRequest();
	request.open("POST","ajax/unaccept_friend.php");



	request.onreadystatechange = function(){
		if(request.readyState === 4) {
		}
	}

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	request.send("send=" + s + "&receive=" + r);


}

function demandes(){
	const request = new XMLHttpRequest();
	request.open("GET","ajax/demandes.php");


	// la fonction ci-dessous va se déclencher à chaque changement 
	// d'état de la requette HTTP

	request.onreadystatechange = function(){
		if(request.readyState === 4) {
			document.getElementById("demande-container").innerHTML = request.responseText;
		}
	}

  	request.send();

}

function show_friends(){

	const request = new XMLHttpRequest();
	request.open("GET","ajax/show_friend.php");


	// la fonction ci-dessous va se déclencher à chaque changement 
	// d'état de la requette HTTP

	request.onreadystatechange = function(){
		if(request.readyState === 4) {
			document.getElementById("my-friends").innerHTML = request.responseText;
		}
	}

  	request.send();

}
