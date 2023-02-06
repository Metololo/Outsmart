var a = 0;
var cooldown;
function wow(){
	get_leaderboard();
	cooldown = setInterval(timer,1000);
	let refresh  = setInterval(get_leaderboard,500);
}

function timer(){
	if(10-a === 0){

				clearInterval(cooldown);

					const query = window.location.search;
					const params = new URLSearchParams(query);
					const code = params.get('code');

					const request2 = new XMLHttpRequest();
					request2.open("POST","ajax/last_chance.php");



					request2.onreadystatechange = function(){
						if(request2.readyState === 4) {
						}
				}

				request2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			  	request2.send("code=" + code);

	}

	a++;
}

function get_leaderboard(){

	const query = window.location.search;
	const params = new URLSearchParams(query);
	const code = params.get('code');

	request = new XMLHttpRequest();
	request.open("GET","ajax/leaderboard.php?code="+code);

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			const leaderboard = document.getElementById('leaderboard_cool');
			leaderboard.innerHTML = request.responseText;

		}
	}

  	request.send();

}