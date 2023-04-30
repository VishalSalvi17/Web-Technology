function validate(){

var FirstName = document.getElementById("FirstName").value; 
var LastName = document.getElementById("LastName").value; 
var Username = document.getElementById("Username").value; 
var Password = document.getElementById("Password").value;
var Confirm Password = document.getElementById("Confirm Password").value;
var Email = document.getElementById("Email").value;
var Confirm Email = document.getElementById("Confirm Email").value;
var error_message = document.getElementById("error_message");
error_message.style.padding = "10px";



var text;

if(FirstName.length < 3){

text = "Please Enter valid FirstName";

error_message.innerHTML = text;

return false;

}

if(LastName.length < 4){

text = "Please Enter valid LastName";

error_message.innerHTML = text;

return false;

}

if(Username.length < 4){

text = "Please Enter valid Username";

error_message.innerHTML = text;

return false;

}

if(Password.length < 4){

text = "Please Enter correct Password";

error_message.innerHTML = text;

return false;

}

if(Confirm Password.length < 4){

text = "Please Enter correct Confirm Password";

error_message.innerHTML = text;

return false;

}

if(Email.indexOf("@") == -1 || email.length < 6){ text = "Please Enter valid Email"; 
error_message.innerHTML = text;

return false;

}

if(Confirm Email.indexOf("@") == -1 || email.length < 6){ text = "Please Enter valid Email"; 
error_message.innerHTML = text;

return false;

}
 

alert("Form Submitted Successfully!");

return true;

}
