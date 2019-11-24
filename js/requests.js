'use strict';


function acceptOffer(requestId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/changeRentState.php?' + encodeForAjax({'rentId': requestId, 'state':1}) , true);
    request.addEventListener('load', replaceRent);
    request.send();

    

}
function declineOffer(requestId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/changeRentState.php?' + encodeForAjax({'rentId': requestId, 'state':-1}) , true);
    request.addEventListener('load', replaceRent);
    request.send();
}

function replaceRent(){
    let data = JSON.parse(this.responseText);
    let string = "request" + data[0];
    let request = document.getElementById(string);
    request.getElementsByTagName('div')[0].remove();
    let lastElem = request.lastElementChild;
    if(data[1] == 1){
        lastElem.innerHTML = "Accepted";
    }else if(data[1] == -1){
        lastElem.innerText = "Declined";
    }else if(data[1] == -2){
        lastElem.innerHTML = "Exceded time";
    }
    console.log(request);
}


function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
