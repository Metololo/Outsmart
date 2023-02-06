function search(){
	 const input = document.getElementById('search-forum').value;
	 console.log(input);
    const div  = document.getElementById('result');
    const request= new XMLHttpRequest();
    request.open("GET","ajax/search.php?search="+input);
    request.onreadystatechange= function(){
        if(request.readyState === XMLHttpRequest.DONE){
            const result = request.responseText;
            div.innerHTML = result;
        }
    }
    request.send();
}