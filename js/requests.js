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
function cancellOffer(requestId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/changeRentState.php?' + encodeForAjax({'rentId': requestId, 'state':-3}) , true);
    request.addEventListener('load', replaceRent);
    request.send();
}

function replaceRent(){
    let data = JSON.parse(this.responseText);
    let id = "request" + data[0];
    let request = document.getElementById(id);
    let response = request.getElementsByTagName('div')[0];
    if(response){
        response.remove();
    }
    let lastElem = request.lastElementChild;
    if(data[1] == 1){
        lastElem.innerHTML = "Accepted";
    }else if(data[1] == -1){
        lastElem.innerText = "Declined";
    }else if(data[1] == -2){
        lastElem.innerHTML = "Exceeded time";
    }else if(data[1] == -3){
        lastElem.innerHTML = "Cancelled";
    }
    console.log(request);
}

function getAllRents(userId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getAllRentsByOwner' ,'userId': userId}) , true);
    request.addEventListener('load', displayRents);
    request.send();
}

function getRentsForAproval(userId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerForApproval' ,'userId': userId}) , true);
    request.addEventListener('load', displayRents);
    request.send();
}

function getRentsInNextTimes(userId,time){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerIntTheNextTimes' ,'userId': userId,'time':time}) , true);
    request.addEventListener('load', displayRents);
    request.send();
}
function getRentsInFuture(userId){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerIntTheNextTimes' ,'userId': userId,'time':30000000}) , true);
    request.addEventListener('load', displayRents);
    request.send();
}

function displayRents(){
    console.log(this.responseText);
    let rents = JSON.parse(this.responseText);
    let rentDiv = document.getElementById('rents');
    rentDiv.innerHTML=" ";

    

    rents.forEach(function(data){
        let rent = document.createElement('div');
        rent.setAttribute('class','request');
        rent.setAttribute('id','request' + data['rentID']);
        rent.innerHTML = "<a href=\"../pages/house.php?id=" + data['place'] + 
        "\"> <h3>" + data['title'] + "</h3> </a>" +
        "<a href=\"../pages/user.php?id=" + data['tourist'] + 
        "\"> <h3>" + data['userName'] + "</h3> </a>"+
        "<h3>" + data['startDate'] + "</h3>"+
        "<h3>" + data['endDate'] + "</h3>";
        if(data['accepted'] == 0){
            rent.innerHTML += "<h3> Waiting for response </h3> <div id='response'> " +
             "<button onclick=\"acceptOffer(" + data['rentID'] + ")\">Accept</button> "+
             "<button onclick=\"declineOffer(" + data['rentID'] + ")\">Decline</button> "+
             "</div>"
        }else if(data['accepted'] == 1){
            rent.innerHTML += "<h3> Accepted </h3>"
            let maxLimit = new Date();  maxLimit.setDate(maxLimit.getDate()+10); //maximo sao 10 dias
            let startDate = new Date(data['startDate']);
            console.log(startDate.getUTCDate());
            console.log(maxLimit.getUTCDate());
            if(startDate.getTime() > maxLimit.getTime() ){
                rent.innerHTML +=" <div id='cancelation'> <button onclick=\"cancellOffer(" + data['rentID'] + ")\">Cancell</button> </div>";
            }
        }else if(data['accepted'] == -1){
            rent.innerHTML += "<h3> Declined </h3>"
        }else if(data['accepted'] == -2){
            rent.innerHTML += "<h3> Exceded time </h3>"
        }else if(data['accepted'] == -3){
            rent.innerHTML += "<h3> Canceled </h3>"
        }


        rentDiv.append(rent);
    });

}




function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}
