function verif_form(name,text){
	if(name_verif(name) === false) return false;
	if(text_verif(text) === false) return false;

	return true;
}


function name_verif(input){

	const element = document.getElementById(input);
	const feedback = document.getElementById(input + '_feedback');
	const str = element.value.length;
	
	if(input_test(element,1) === true){
		element.classList.remove("is-invalid");
		element.classList.add("is-valid");
		feedback.setAttribute("class", "valid-feedback");
		feedback.innerHTML = str + "/32";

		return true;
	}else{
		element.classList.remove("is-valid");
		element.classList.add("is-invalid");
		feedback.setAttribute("class", "invalid-feedback");


		if(input_test(element,1) === 0){
			feedback.innerHTML = "Veuillez remplir ce champ";
		}
		if(input_test(element,1) === 1){
			feedback.innerHTML = "Le nom du sujet ne doit pas commencer par un chiffre";
		}
		if(input_test(element,1) === 2){
			feedback.innerHTML = "Minimum 4 caractères";
		}
		if(input_test(element,1) === 3){
			feedback.innerHTML = str + "/32";
		}

		return false;

	}


}

function text_verif(input){

	const element = document.getElementById(input);
	const feedback = document.getElementById(input + '_feedback');
	const str = element.value.length;
	
	if(input_test(element,2) === true){
		element.classList.remove("is-invalid");
		element.classList.add("is-valid");
		feedback.setAttribute("class", "valid-feedback");
		feedback.innerHTML = str + "/3000";

		return true;
	}else{
		element.classList.remove("is-valid");
		element.classList.add("is-invalid");
		feedback.setAttribute("class", "invalid-feedback");

		if(input_test(element,2) === 0){
			feedback.innerHTML = "Minimum 4 caractères";
		}
		if(input_test(element,2) === 1){
			feedback.innerHTML = str + "/3000";
		}

		return false;
	}

}

function input_test(test,nb){

	const first_car = test.value.charCodeAt(0);

		if (nb === 1){
			if(test.value.length == 0){
			return 0;
		}

		if(first_car >= 48 && first_car <= 57){
			return 1;
		}



		if(test.value.length <= 3){
			return 2;
		}

		if (test.value.length > 32){
			return 3;
		}
	}

	if(nb === 2){
		if(test.value.length < 4) return 0;
		if(test.value.length > 3000) return 1;
	}

	return true;
}
