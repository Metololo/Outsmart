function start_refresh(){
	refresh = setInterval(refresh,700);
}

function refresh(){
	request = new XMLHttpRequest();
	request.open("GET","ajax/lobby_infos.php?");

	request.onreadystatechange = function(){
		if(request.readyState === 4) {
			json = JSON.parse(request.responseText);
			session_infos = {
				"nb_joueur" : json[0],
				"print_players" : json[1],
				"statut" : json[2],
				"code" : json[3]
			}
			if(session_infos['statut'] === 'finis'){
				document.location.href="index.php?error=Partie ANNULE par son createur"; 
			}else if(session_infos['statut'] === '1'){
				document.location.href="game.php?code="+session_infos['code']; 
			}
			const container = document.getElementById('players-container');
			container.innerHTML = session_infos['print_players'];

			const div_j = document.getElementById('session_joueurs');
			div_j.innerHTML = session_infos['nb_joueur'];

			

			verif_start();

		}
	}

  	request.send();
}	

function verif_start(){
	const div_j = document.getElementById('session_joueurs');

	if(div_j.innerHTML > 1){
		const btn = document.getElementById('suivant-theme');
		btn.classList.add('suivant-active');
		return true;
	}else{
		const btn = document.getElementById('suivant-theme');
		btn.classList.remove('suivant-active');
		return false;
	}
}