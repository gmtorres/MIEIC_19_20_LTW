"use strict";

let commentForm = document.getElementById("commentForm");
if(commentForm != undefined && commentForm != null){
    commentForm.addEventListener('input',function(event){
        let classification = document.getElementById('classificationForm');
        if(classification.value != null){
            if(classification.value > 5){
                classification.value = 5;
            }
            if(classification.value < 1){
                classification.value = 1;
            }
        }
    });
}

let availablesForm = document.getElementById("AddAvailables");
if(availablesForm != undefined && availablesForm != null){
    availablesForm.addEventListener('input',function(event){
        let price = document.getElementById('price');
        if(price.value != null){
            if(price.value < 1){
                price.value = 1;
            }
        }
    });
}


let changePlaceForm = document.getElementById("changePlaceInfo");
if(changePlaceForm != undefined && changePlaceForm != null){
    changePlaceForm.addEventListener('input',function(event){
        let guests = document.getElementById('guestsForm');
        if(guests.value != null){
            if(guests.value < 1){
                guests.value = 1;
            }
            if(guests.value > 20){
                guests.value = 20;
            }
        }
    });
}

let addPlaceForm = document.getElementById("addPlaceForm");
if(addPlaceForm != undefined && addPlaceForm != null){
    addPlaceForm.addEventListener('input',function(event){
        let guests = document.getElementById('guestsForm');
        if(guests.value != null){
            if(guests.value < 1){
                guests.value = 1;
            }
            if(guests.value > 20){
                guests.value = 20;
            }
        }
    });
}


let registerForm = document.getElementById('register');
if(registerForm != undefined && registerForm != null){
    registerForm.addEventListener('input',function (event) {
        let message = registerForm.getElementsByTagName('span')[0];
        message.innerHTML="";
    });
    
    registerForm.addEventListener('submit',function (event) {

        let username = registerForm.getElementsByTagName('input')[0];
    
        let passwordNew1 = registerForm.getElementsByTagName('input')[1];
        let passwordNew2 = registerForm.getElementsByTagName('input')[2];
    
        let message = registerForm.getElementsByTagName('span')[0];
    
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
            }/*else if(passwordNew1.value == username.value){
                message.innerHTML = "Password must be different from userName";
                passwordNew1.focus();
                event.preventDefault();
                return;
            }*/
            let re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            if(!re.test(passwordNew1.value)){
                message.innerHTML = "Password must have one number, one upper and one lower case letter";
                passwordNew1.focus();
                event.preventDefault();
                return;
            }
        }
    
        let phoneNumber = registerForm.getElementsByTagName('input')[3];
    
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
    
        let age = registerForm.getElementsByTagName('input')[5];
        if(age.value < 18){
            message.innerHTML = "You must have more than 18 years";
            age.focus();
            event.preventDefault();
            return;
        }
    
    });
}


let changePasswordForm = document.getElementById("changePassword");
if(changePasswordForm != undefined && changePasswordForm != null){
    changePasswordForm.addEventListener('input',function(event){
        
        let passwordNew1 = registerForm.getElementsByTagName('input')[1];
        let passwordNew2 = registerForm.getElementsByTagName('input')[2];
    
        let message = registerForm.getElementsByTagName('span')[0];
    
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
            let re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            if(!re.test(passwordNew1.value)){
                message.innerHTML = "Password must have one number, one upper and one lower case letter";
                passwordNew1.focus();
                event.preventDefault();
                return;
            }
        }
    

        
    });
}