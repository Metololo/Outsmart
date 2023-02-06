

function focus_change(value){

	const div = document.getElementById('commentaire-send');

	if(value === 1){
	div.style.borderColor = 'black';
	}else{
	div.style.borderColor = '#E9E9E9';
	}
}

function comment_verif(){
	const textarea = document.getElementById("commentaire-topic");
	const value = textarea.value;

	const button = document.getElementById("commentaire-go");

	if(value.length === 0 ){
		button.style.color = "#DDDDDD";
		button.style.backgroundColor = "#797979";
		return false;
	}else{
		button.style.color = "#FFF";
		button.style.backgroundColor = "#9B59B6";
		return true;
	}
}