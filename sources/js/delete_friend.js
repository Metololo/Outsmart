function delete_friend(id,name){
	const title = document.getElementById("delete_title");
	title.innerHTML = "Etes-vous sure de vouloir supprimer l'amis : " + name + " ?";

	const id_delete = document.getElementById("confirm_delete");

	const id_friend = id.split("delete");

	id_delete.value = id_friend[1];

}
