var game_infos;
var question_infos;
var decount;
var timer_end;
var timer;
var did_answer = 0;
var last_answer = -1;
var decount;

var bla = 0;


function get_session_infos(){

	request = new XMLHttpRequest();
	request.open("GET","ajax/game_infos.php?");

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			json = JSON.parse(request.response);
			game_infos = {
				"nb_questions" : parseInt(json[0]['nb_questions']),
				"tmp_reponse" : parseInt(json[0]['tmp_reponse']),
				"code" : json[0]['code'],
				"partie" : parseInt(json[0]['partie'])
			};

			const total_q = document.getElementById('nb_question');
			total_q.innerHTML = game_infos['nb_questions'];

			get_question_infos();

		}
	}

  	request.send();

}



function get_question_infos(){

	request = new XMLHttpRequest();
	request.open("GET","ajax/question_infos.php?partie="+game_infos['partie']);

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			json = JSON.parse(request.responseText);
			question_infos = {
				"id" : json['id'],
				"b_rep" : json['b_rep'],
				"question" : json['question'],
				"rep2" : json['rep2'],
				"rep3" : json['rep3'],
				"rep4" : json['rep4'],
				"partie" : parseInt(json['partie']),
				"debut" : parseInt(json['debut']),
				"ordre" : parseInt(json['ordre']),
			};
			timer_end = question_infos['debut'] - game_infos['tmp_reponse']*1000;
			document.getElementById('question_actuel').innerHTML = question_infos['ordre'];
			document.getElementById('question-quizz').innerHTML = question_infos['question'];
			print_question();
		}
	}

	request.send();
}

function print_question(){
	request = new XMLHttpRequest();
	request.open("GET","ajax/print_reponses.php?question=" + question_infos['id']);

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			const reponse_contain = document.getElementById('super-reponse');
			reponse_contain.innerHTML = request.responseText;

			reponses = [question_infos['b_rep'],question_infos['rep2'],question_infos['rep3'],question_infos['rep4']];

			// Melange avec l'algorithme de Fisher-Yates

			let i = reponses.length,j,temp;
			while(--i > 0){
				j = Math.floor(Math.random() * (i+1));
				temp = reponses[j];
				reponses[j] = reponses[i];
				reponses[i] = temp;
			}

			for(i=0;i<4;i++){
				document.getElementById('text-rep-'+(i+1)).innerHTML = reponses[i];
			}
			timer_count();
			decount = setInterval(timer_count,200);
		}


		

	}

	request.send();
}
function timer_count(){
	request = new XMLHttpRequest();
	request.open("GET","ajax/current_time.php");

	request.onreadystatechange = function(){
		if(request.readyState === 4) {	
			
			const date_joueur = parseInt(request.responseText);
			const counter = parseInt((date_joueur - question_infos['debut'])/1000);
			timer = game_infos['tmp_reponse']-counter;
			
			if(timer <= 0){

					clearInterval(decount);
					const chrono = document.getElementById('left-time-text');
					chrono.innerHTML = 0;
					if(bla === 0){
						verif_reponse();
						bla = 1;
					}
			}else{
				if(timer < 5){
					document.getElementById('left-time-text').style.color = '#CC2929';
				}else{
					document.getElementById('left-time-text').style.color = '#FFF';
				}
				const chrono = document.getElementById('left-time-text');
				chrono.innerHTML = timer;
			}
		}

	
	}

	request.send();
	
	
}


function select_reponse(reponse){
	if(timer > 0){
		for(let i = 1;i<5;i++){
			let answer = document.getElementsByClassName('select-r-' + i);
			if(i == reponse){
				last_answer = i;
				for(let j = 0;j<2;j++){
					answer[j].style.display = 'block';
					
				}
				const answer_div = document.getElementById('rep'+i);
					answer_div.classList.remove('selected-reponse');
			}else{
				for(let j = 0;j<2;j++){
					answer[j].style.display = 'none';
					
				}
				const answer_div = document.getElementById('rep'+i);
					answer_div.classList.add('selected-reponse');
					
			}
		}
	}
}

function verif_reponse(){

	let score = 0;

	if(last_answer != -1){
			for(let i = 1;i<5;i++){
				let answer = document.getElementsByClassName('select-r-' + i);

					for(let j = 0;j<2;j++){
						answer[j].style.display = 'none';
						
					}
					const answer_div = document.getElementById('rep'+i);
						answer_div.classList.remove('selected-reponse');		
			}

		
		 
			for(let i = 1;i<5;i++){
				
				
				if (i === last_answer){
					const selected_answer = document.getElementById('text-rep-'+last_answer);
					if(selected_answer.innerHTML !== question_infos['b_rep']){
						document.getElementById('rep'+i).classList.add('bad-reponse');
					}else{
						score = 2;
						document.getElementById('rep'+i).classList.add('valide-reponse');
					}
				}else{
					let answer = document.getElementById('text-rep-' + i);
					if(answer.innerHTML !== question_infos['b_rep']){
						document.getElementById('rep'+i).classList.add('question-finish');
					}else{
						document.getElementById('rep'+i).classList.add('valide-reponse');
					}
				}
		
			}
		}else{
			for(let i = 1;i<5;i++){
				let answer = document.getElementById('text-rep-' + i);
				if(answer.innerHTML !== question_infos['b_rep']){
					document.getElementById('rep'+i).classList.add('question-finish');
				}else{
					document.getElementById('rep'+i).classList.add('valide-reponse');
				}
			}
		}
		last_answer = -1;
		const johnny = setTimeout(next_question,3000,score);
}


function next_question(score){
	if(question_infos['ordre'] === game_infos['nb_questions']){

			const request = new XMLHttpRequest();
		request.open("POST","ajax/finish_game.php");

		request.onreadystatechange = function(){
			if(request.readyState === 4) {
			document.location.href="game_score.php?code="+game_infos['code'];

			}
		}

		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  	request.send("score="+score+"&partie="+question_infos['partie']);

	}else{
	const request = new XMLHttpRequest();
	request.open("POST","ajax/update_score.php");

	request.onreadystatechange = function(){
		if(request.readyState === 4) {
			document.getElementById('score-p1').innerHTML = request.responseText;
			bla = 0;
			get_question_infos();

		}
	}

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	request.send("score="+score+"&ordre="+question_infos['ordre']+"&partie="+question_infos['partie']);
	}
	
}
