function jsShow(id){
    document.getElementById(id).style.display='block';
}
function jsHide(id){
    document.getElementById(id).style.display='none';
}

function validateName(){
    var name=document.getElementById('user').value;
    if(name.length >= 1 && name.length <= 25){
        producePrompt('Valid username','usernamePrompt','green');
        return true;
    }
	if(name.length >25){
		producePrompt('Username must be at most 25 characters long','usernamePrompt','red');
	}
	else{
		producePrompt('Invalid username','usernamePrompt','red');
		return false;
	}
}

function validateEmail(){
    var email=document.getElementById('email').value;
    var reg=/[A-Za-z0-9_-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/;
    if(email.length == 0){
        producePrompt('Email is required', 'emailPrompt','red');
        return false;
    }
    if(!email.match(reg)){
        producePrompt('Invalid Email example: test@abc.com','emailPrompt','rgba(233,106,200,0.9)');
        return false;
    }
	producePromt('Valid Email','emailPrompt','green');
    return true;
}
function validatePassword(){
    var password=document.getElementById('pwd1').value;
    //var reg=/[A-Z][A-Za-z0-9-_]{8,}/;
	var reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
    if(password.length == 0){
        producePrompt('Password is required','passwordPrompt','red');
        return false;
    }
    if(!password.match(reg)){
        producePrompt('Password must be at least 8 characters long and must contain at least 1 upper case, 1 lower case and 1 digit','passwordPrompt','red');
        return false;
    }
    producePrompt('Valid password','passwordPrompt','green');
    return true;
}
//doesn't validate
function validatePassword2(){
    password1=document.getElementById('pwd1').value;
    password2=document.getElementById('pwd2').value;
    if(password2.length == 0){
        producePrompt('Please confirm password','password2Prompt','rgba(100,234,255,1)');
    }
    if(password2 != password1){
        producePrompt('Passwords do not match','password2Prompt','red');
    }
    if(password2 == password1 && password1.length>0 && password2.length>0) {
        producePrompt('Passwords match', 'password2Prompt', 'green');
        return true;
    }
    return true;

}

function producePrompt(message, promptlocation,color){
    document.getElementById(promptlocation).innerHTML = message;
    document.getElementById(promptlocation).style.color = color;
}


function validateForm(){
    if(!validateName()||!validatePassword() || !validatePassword2() || !validateName()){
        jsShow('submitPrompt');
        producePrompt('Something went wrong,check your inputs again','submitPrompt','red');
        setTimeout(function(){jsHide('submitPrompt')},2000);
		return false;
    }
    else{
		return true;
    }
}