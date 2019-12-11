"use scrict";

let last_id = -1;

window.setInterval(refresh, 5000);

refresh();

document.getElementById("chatForm").addEventListener('submit',sendMessage);

function sendMessage(event) {

    let text = document.getElementById("chatTextForm").value;

    let request = new XMLHttpRequest();
    request.open('post', '../actions/sendMessage.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', messagesReceived);
    request.send(encodeForAjax({'last_id': last_id , 'text' : text}));

    event.preventDefault();
}

function refresh() {
    let request = new XMLHttpRequest();
    request.open('post', '../actions/sendMessage.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', messagesReceived);
    request.send(encodeForAjax({'last_id': last_id}));
}



function messagesReceived() {
    let lines = JSON.parse(this.responseText);
    let chat = document.getElementById('rentChat');
    console.log(this.responseText);
    lines.forEach(function(data){
        let line = document.createElement('div');
        line.setAttribute('class','message');
        
        last_id = data.rentMessageID;
    
        line.classList.add('line');
        line.innerHTML =
          '<div class=\'textHeader\'> <h3 class="textInfo_username">' + data.userName + '</h3>' +
          '<h3 class="textInfo_time">' + data.commentDate + '</h3> </div>' +
          '<h3 class="text">' + data.comment + '</h3>';
    
        chat.prepend(line);
        //chat.scrollTop = chat.scrollTopMax;
      });
}






function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}