show_chat();
scroll();

var bot_scroll = 1;
var print = 0;

window.onload = function refresh(){
	let refreshing = setInterval(show_chat,1000);
	document.getElementById("chat-container").scrollTop = document.getElementById("chat-container").scrollHeight;
	let refresh_scroll = setInterval(scroll,200);

	
}

function come_back(){
	document.getElementById("chat-container").scrollTop = document.getElementById("chat-container").scrollHeight;
}

function show_chat(){
	const a = document.getElementById("friend-super-id");
	const request = new XMLHttpRequest();
	request.open("GET","ajax/show_chat.php?friend=" + a.value);


	request.onreadystatechange = function(){
		if(request.readyState === 4) {
			document.getElementById("chat-container").innerHTML = request.responseText;
		}
	}

  	request.send();
  	
}

const div = document.getElementById('chat-container');

div.onscroll = function(e){
	if (div.offsetHeight + div.scrollTop >= div.scrollHeight) {
	document.getElementById('new-msg-check').style.display = "none"; 
    bot_scroll = 1;
    print = 1;
  }else{
  	if(print === 1)document.getElementById('new-msg-check').style.display = "flex";
  	bot_scroll = 0;
  }
}

function scroll(){
	if(bot_scroll === 1){
		document.getElementById("chat-container").scrollTop = document.getElementById("chat-container").scrollHeight;
	}
}

function send_msg(){
	if(comment_verif()){
		const msg = document.getElementById('commentaire-topic');
		const a = document.getElementById("friend-super-id");
		const request = new XMLHttpRequest();
		request.open("POST","ajax/send_chat.php");



		request.onreadystatechange = function(){
			if(request.readyState === 4) {
			}
		}

		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  	request.send("friend=" + a.value +"&msg=" + msg.value);


	  	msg.value = "";
	}
}
