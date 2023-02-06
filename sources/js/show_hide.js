var open = -1;
var b = -1;

window.onload = function cool(){
console.log("test");
	let wowow = setInterval(blo,1000);
}


document.addEventListener('click',function(event){

	if(open !== -1){

		if(open === "oui " + b){
			 open = parseInt(open.split(" ")[1]);
		}else if(open === b){
			const div = document.getElementById('op-' + open);
			if(event.target !== div  && event.target.parentNode !== div){
			div.style.display = 'none';
			refreshing2 = setInterval(show_friends,1000);
			}	
		}
	}

});

function show(a){

	clearInterval(refreshing2);
	const div = document.getElementById("op-" + a);

	div.style.display = "block";

	open = "oui " + a;
	b = parseInt(a);
}


	
