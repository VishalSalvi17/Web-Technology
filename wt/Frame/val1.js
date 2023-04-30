
function validate() 
{ var errorMessage = '';

if (!document.getElementById('FirstName').value.match(/^[A-Za-z]{1,50}$/)) 
{ 
if (document.getElementById('FirstName').value.length > 50) 
{

errorMessage += 'Name cannot have more than 50 characters\n';
} else {
errorMessage += 'Name cannot have digits or any other special characters\n';
}
}

if (!document.getElementById('LastName').value.match(/^[A-Za-z]{1,50}$/)) 
{ if (document.getElementById('LastName').value.length > 50)
 {

errorMessage += 'Name cannot have more than 50 characters\n';
} else {
errorMessage += 'Name cannot have digits or any other special characters\n';
}
} 

if(!document.getElementById('Username').value.match(/^[A-Za-z]{1,50}$/))
{
if (document.getElementById('Username').value.length > 50) 
{ errorMessage += 'Username cannot have more than 50 characters\n';
} else {
errorMessage += 'Username cannot have digits or any other special characters\n';
}
}

if (document.getElementById('Password').value !==document.getElementById('confirm Password').value) 
{ errorMessage += 'Passwords do not match\n';
} 

if
(!document.getElementById('Email').value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) { errorMessage += 'Invalid email address\n';
}
if (document.getElementById('email').value !==document.getElementById('Confirm Email').value) { errorMessage += 'Emails do not match\n';
}

if (errorMessage.length != 0) { window.alert(errorMessage);

return false;
}
window.alert('Success');
return true;
}
function hoverEvent()
 { if (document.getElementById('FirstName').value == "" || (document.getElementById('LastName').value == "" || document.getElementById('Username').value == "" || document.getElementById('Password').value == "" || document.getElementById('Confirm Password').value == "" ||document.getElementById('Email').value == "" || document.getElementById('Confirm Email').value == "") { document.getElementById("Submit").style.position = "relative";var elem = document.getElementById("submit");elem.innerHTML = "Catch Me!";
var pos = 0;
var id = setInterval(frame, 1);
function frame() {
if (pos % 4 == 1) {
clearInterval(id);
} else {
pos++;
elem.style.left = Math.floor(Math.random() * 800) + 'px'; elem.style.bottom =
Math.floor(Math.random() * 400) +
'px';
}
}
return false;
}
return true;
}
function keyPressEvent() { if (document.getElementById('FirstName').value.length !=0 && document.getElementById('LastName').value.length !=0 && document.getElementById('Username').value.length != 0 && document.getElementById('Password').value.length != 0 && document.getElementById('Confirm Pass
word').value.length != 0 && document.getElementById('Email').value.length != 0
&&document.getElementById('Confirm Email').value.length != 0) 
{var elem = document.getElementById("myBtn");
elem.style.position = "static";
elem.style.transform = "translateX(250px)";
elem.innerHTML = "<span>Register </span>";
}
}


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
