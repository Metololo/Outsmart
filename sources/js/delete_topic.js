function delete_topic(id,name){
	const title = document.getElementById("delete_title");
	title.innerHTML = "Etes-vous sure de vouloir supprimer le topic : " + name + " ?";

	const id_delete = document.getElementById("confirm_delete");

	const id_topic = id.split("delete");

	id_delete.value = id_topic[1];

}

function delete_msg(id){
	const id_delete = document.getElementById('confirm_delete_msg');
	id_delete.value = id;
}