'use strict';

document.getElementById('changeUserName').addEventListener('input',function (event) {
    let message = document.getElementById('changeUserName').getElementsByTagName('span')[0];
    message.innerHTML="";
});

document.getElementById('changeUserName').addEventListener('submit',function (event) {
    
    let username = document.getElementById('changeUserName').getElementsByTagName('input')[0].value;

    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeProfileInfo.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', usernameReload);
    request.send(encodeForAjax({'function' : 'changeUserName' ,'username' : username }));

    event.preventDefault();
});

function usernameReload() {
    let data = JSON.parse(this.responseText);
    let message = document.getElementById('changeUserName').getElementsByTagName('span')[0];
    message.innerHTML = data['message'];
    if(data["ret"] == 1)
        location.reload();
}

document.getElementById('changePassword').addEventListener('input',function (event) {
    let message = document.getElementById('changePassword').getElementsByTagName('span')[0];
    message.innerHTML="";
});

document.getElementById('changePassword').addEventListener('submit',function (event) {
    event.preventDefault();

    let passwordOld = document.getElementById('changePassword').getElementsByTagName('input')[0];
    let passwordNew1 = document.getElementById('changePassword').getElementsByTagName('input')[1];
    let passwordNew2 = document.getElementById('changePassword').getElementsByTagName('input')[2];

    let message = document.getElementById('changePassword').getElementsByTagName('span')[0];

    if(passwordNew1.value !== passwordNew2.value){
        message.innerHTML = "Passwords do not match";
        passwordNew1.focus();
        passwordNew2.focus();
        return;
    }else{
        if(passwordNew1.value.length<6){
            message.innerHTML = "Password must be at least 6 caracters";
            passwordNew1.focus();
            return;
        }
    }

    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeProfileInfo.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', passwordReload);
    request.send(encodeForAjax({'function' : 'changePassword' ,'old' : passwordOld.value,'new' : passwordNew1.value }));

});

function passwordReload() {
    let data = JSON.parse(this.responseText);
    let message = document.getElementById('changePassword').getElementsByTagName('span')[0];
    message.innerHTML = data['message'];
    if(data["ret"] == 0){
        document.getElementById('changePassword').getElementsByTagName('input')[0].focus();
    }else{
        document.getElementById('changePassword').getElementsByTagName('input')[0].value="";
        document.getElementById('changePassword').getElementsByTagName('input')[1].value="";
        document.getElementById('changePassword').getElementsByTagName('input')[2].value="";
    }
}

document.getElementById('changeEmail').addEventListener('input',function (event) {
    let message = document.getElementById('changeEmail').getElementsByTagName('span')[0];
    message.innerHTML="";
});

document.getElementById('changeEmail').addEventListener('submit',function (event) {
    event.preventDefault();

    let emailOld = document.getElementById('changeEmail').getElementsByTagName('input')[0];
    let emailNew = document.getElementById('changeEmail').getElementsByTagName('input')[1];

    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeProfileInfo.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', emailReload);
    request.send(encodeForAjax({'function' : 'changeEmail' ,'old' : emailOld.value,'new' : emailNew.value }));

});

function emailReload() {
    let data = JSON.parse(this.responseText);
    let message = document.getElementById('changeEmail').getElementsByTagName('span')[0];
    message.innerHTML = data['message'];
    if(data["ret"] == 1)
        location.reload();
}



/*document.getElementById('changeProfilePic').addEventListener('submit',function (event) {
    event.preventDefault();

    let image = document.getElementById('changeProfilePic').getElementsByTagName('input')[0].files[0];

    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeProfilePicture.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', imageReload);
    request.send(encodeForAjax({'image': image['name'] }));

});

function imageReload() {
    let data = JSON.parse(this.responseText);
    let message = document.getElementById('changeProfilePic').getElementsByTagName('span')[0];
    message.innerHTML = data['message'];
    if(data["ret"] == 1)
        location.reload();
}*/





function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}