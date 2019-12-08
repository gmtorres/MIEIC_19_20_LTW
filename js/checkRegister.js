document.getElementById('register').addEventListener('input',function (event) {
    let message = document.getElementById('register').getElementsByTagName('span')[0];
    message.innerHTML="";
});

document.getElementById('register').addEventListener('submit',function (event) {

    let passwordNew1 = document.getElementById('register').getElementsByTagName('input')[1];
    let passwordNew2 = document.getElementById('register').getElementsByTagName('input')[2];

    let message = document.getElementById('register').getElementsByTagName('span')[0];

    if(passwordNew1.value !== passwordNew2.value){
        message.innerHTML = "Passwords do not match";
        passwordNew1.focus();
        passwordNew2.focus();
        event.preventDefault();
        return;
    }else{
        if(passwordNew1.value.length<6){
            message.innerHTML = "Password must be at least 6 caracters";
            passwordNew1.focus();
            event.preventDefault();
            return;
        }
    }

    let phoneNumber = document.getElementById('register').getElementsByTagName('input')[3];

    if(isNaN(phoneNumber.value)){
        message.innerHTML = "Invalid phone format";
        phoneNumber.focus();
        event.preventDefault();
        return;
    }
    if(phoneNumber.value.length != 9){
        message.innerHTML = "Phone number must be 9 digits";
        phoneNumber.focus();
        event.preventDefault();
        return;
    }

    let age = document.getElementById('register').getElementsByTagName('input')[5];
    if(age.value < 18){
        message.innerHTML = "You must have more than 18 years";
        age.focus();
        event.preventDefault();
        return;
    }

});