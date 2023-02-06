
var nb_questions;
var total_q = 0;
var nb_selected = 0;

document.body.onload = function infos_question(){
	const request = new XMLHttpRequest();
	request.open("GET","ajax/questions_total.php");


	request.onreadystatechange = function a(){
		if(request.readyState === 4) {
			const reponse = request.responseText;
			nb_questions = JSON.parse(reponse);
		}
	}

  	request.send();

  	const request2 = new XMLHttpRequest();
	request2.open("GET","ajax/total_q.php");


	request2.onreadystatechange = function b(){
		if(request2.readyState === 4) {	

			json = JSON.parse(request2.responseText);
			total_q = parseInt(json['tt_q']);
		}
	}

  	request2.send();
}

function select_theme(id){

	let i = 0;
	for(i = 0; i < nb_questions.length;i++){
		if(nb_questions[i]['theme'] == id){
			const nb_q_theme = parseInt(nb_questions[i]['total']);
			const nb_total = document.getElementById('nb_q_select');
			const actual = parseInt(nb_total.innerHTML);
			const div = document.getElementById(id);

			if(div.classList.contains('select-one-active')){
				div.classList.remove('select-one-active');
				nb_total.innerHTML = actual - nb_q_theme;
				nb_selected = actual - nb_q_theme;
			}else{


				div.classList.add('select-one-active');
				nb_total.innerHTML = actual + nb_q_theme;
				nb_selected = actual + nb_q_theme;

			}

		}
	}
	
	verif_btn();

}

function select_all(){

	const div = document.getElementById('select-all');
	const nb_select = document.getElementById('nb_q_select');
	const themes = document.getElementsByClassName('theme-container');

	if(div.classList.contains('select-all-active')){
		nb_select.innerHTML = '0';
		nb_selected = 0;
		div.classList.remove('select-all-active');
		for(i = 0;i<themes.length;i++){
			themes[i].classList.remove('select-one-active');
		}
	}else{
		div.setAttribute('class','select-all-active');
		for(i = 0;i<themes.length;i++){
			themes[i].classList.add('select-one-active');
		}
		nb_selected = total_q;
		nb_select.innerHTML = total_q;
	}

	verif_btn();

}

function send_themes(){
	let super_value = '';
	const themes = document.getElementsByClassName('select-one-active');
	const btn = document.getElementById('suivant-theme');
	for(i = 0;i<themes.length;i++){
		if(i===themes.length - 1){
			super_value += themes[i].id;
		}else{
			super_value += themes[i].id + '-';
		}
	}

	btn.value=super_value;

}

function verif_btn(){
	const select = document.getElementById('select-q');
	const option = select.options[select.selectedIndex].innerHTML;
	const nb = parseInt(option);

	if(nb_selected >= nb){
		const btn = document.getElementById('suivant-theme');
		btn.classList.add('suivant-active');
		return true;
	}else{
		const btn = document.getElementById('suivant-theme');
		btn.classList.remove('suivant-active');
		return false;
	}


}
