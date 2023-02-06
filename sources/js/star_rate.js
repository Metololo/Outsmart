function rate(content){
	let i;
	const star = document.getElementById(content);
	const arr = {
		"type" : star.id.split('-')[1],
		"pos" : parseInt(star.id.split('-')[2]),
		"name" : parseInt(star.id.split('-')[3])
	}

	for(i = 1; i <= arr['pos']; i++){
		let change = document.getElementById('star-' + arr['type'] + '-' + i + '-' + arr['name']);
		change.style.opacity = '1';

	}

	for(i = arr['pos'] + 1; i <= 5; i++){
		let change = document.getElementById('star-' + arr['type'] + '-' + i + '-' + arr['name']);
		change.style.opacity = '0.5';

	}

}