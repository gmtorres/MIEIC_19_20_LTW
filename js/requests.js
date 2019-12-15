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
        lastElem.innerHTML = "<h3>Accepted</h3>";
    }else if(data[1] == -1){
        lastElem.innerText = "<h3>Declined</h3>";
    }else if(data[1] == -2){
        lastElem.innerHTML = "<h3>Exceeded time</h3>";
    }else if(data[1] == -3){
        lastElem.innerHTML = "<h3>Cancelled</h3>";
    }
    console.log(request);
}

function getAllRents(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getAllRentsByOwner' ,'userId': userId}) , true);
    request.addEventListener('load', displayRents);
    request.send();
    selectTab(id);
}

function getRentsForAproval(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerForApproval' ,'userId': userId}) , true);
    request.addEventListener('load', displayRents);
    request.send();
    selectTab(id);
}

function getRentsInNextTimes(userId,time,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerIntTheNextTimes' ,'userId': userId,'time':time}) , true);
    request.addEventListener('load', displayRents);
    request.send();
    selectTab(id);
}
function getRentsInFuture(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByOwnerIntTheNextTimes' ,'userId': userId,'time':30000000}) , true);
    request.addEventListener('load', displayRents);
    request.send();
    selectTab(id);
}

function selectTab(id){
    let tabs = document.getElementsByClassName("request_button");
    for(let a  = 0; a < tabs.length;a++){
        tabs[a].setAttribute('id','tabNotSelected');
    }
    tabs[id].setAttribute('id','tabSelected');
}



function getRentsByUserInPast(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByUserInPast' ,'userId': userId}) , true);
    request.addEventListener('load', displayReservations);
    request.send();
    selectTab(id);
}
function getRentsByUserAproved(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByUserAproved' ,'userId': userId}) , true);
    request.addEventListener('load', displayReservations);
    request.send();
    selectTab(id);
}
function getRentsByUserWaiting(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByUserWaiting' ,'userId': userId}) , true);
    request.addEventListener('load', displayReservations);
    request.send();
    selectTab(id);
}
function getRentsByUser(userId,id){
    let request = new XMLHttpRequest();
    request.open('get', '../actions/getRents.php?' + encodeForAjax({function : 'getRentsByUser' ,'userId': userId}) , true);
    request.addEventListener('load', displayReservations);
    request.send();
    selectTab(id);
}










function displayRents(){
    //console.log(this.responseText);
    let rents = JSON.parse(this.responseText);
    let rentDiv = document.getElementById('rents');
    rentDiv.innerHTML=" ";

    if(rents.length == 0){
        rentDiv.innerHTML="<h4>No requests match these parameters</h4>";
    }

    rents.forEach(function(data){
        //let rent_container = document.createElement('a');
        //rent_container.setAttribute("href","../pages/rent.php?id="+data['rentID']);
        let rent = document.createElement('div');
        rent.setAttribute('class','request');
        rent.setAttribute('id','request' + data['rentID']);
        rent.innerHTML = 
        "<div id='userInfo'>  <img class='requestProfilePicture' src=\"../images/profile/"+ data['profilePicture'] +".jpg\""+
        "<a href=\"../pages/user.php?id=" + data['tourist'] + 
        "\"> <h3>" + data['userName'] + "</h3> </a> </div>"+
        "<a href=\"../pages/house.php?id=" + data['place'] + 
        "\"> <h3>" + data['title'] + "</h3> </a>"+
        "<div id='dates'><h3 id='from'>From: " + data['startDate'] + "</h3>"+
        "<h3 id='to'>To: " + data['endDate'] + "</h3> </div>";
        let startDate = new Date(data['startDate']).getTime();
        let currentDate = new Date().getTime();
        if(startDate < currentDate ){
            data['accepted'] = -2;
        }
        if(data['accepted'] == 0){
            rent.innerHTML += "<a href=\"../pages/rent.php?id=" + data['rentID'] + 
            "\"> <h3>Status: Waiting for response </h3> </a> <div id='response'> " +
             "<button id='buttonChangeOffer' onclick=\"acceptOffer(" + data['rentID'] + ")\">Accept</button> "+
             "<button id='buttonChangeOffer' onclick=\"declineOffer(" + data['rentID'] + ")\">Decline</button> "+
             "</div>"
        }else if(data['accepted'] == 1){
            rent.innerHTML += "<a href=\"../pages/rent.php?id=" + data['rentID'] + 
            "\"> <h3>Status: Accepted </h3> </a>"
            let maxLimit = new Date();  maxLimit.setDate(maxLimit.getDate()+10); //maximo sao 10 dias
            let startDate = new Date(data['startDate']);
            console.log(startDate.getUTCDate());
            console.log(maxLimit.getUTCDate());
            if(startDate.getTime() > maxLimit.getTime() ){
                rent.innerHTML +=" <div id='cancelation'> <button onclick=\"cancellOffer(" + data['rentID'] + ")\">Cancell</button> </div>";
            }
        }else if(data['accepted'] == -1){
            rent.innerHTML += "<a href=\"../pages/rent.php?id=" + data['rentID'] + 
            "\"> <h3>Status: Declined </h3> </a>"
        }else if(data['accepted'] == -2){
            rent.innerHTML += "<a href=\"../pages/rent.php?id=" + data['rentID'] + 
            "\"> <h3>Status: Exceded time </h3> </a>"
        }else if(data['accepted'] == -3){
            rent.innerHTML += "<a href=\"../pages/rent.php?id=" + data['rentID'] + 
            "\"> <h3>Status: Canceled </h3> </a>"
        }

        //rent_container.append(rent);
        rentDiv.append(rent);
    });

}

function displayReservations(){
    //console.log(this.responseText);
    let rents = JSON.parse(this.responseText);
    let rentDiv = document.getElementById('rents');
    rentDiv.innerHTML=" ";

    if(rents.length == 0){
        rentDiv.innerHTML="<h4>No reservations match these parameters</h4>";
    }

    rents.forEach(function(data){
        let rent_container = document.createElement('a');
        rent_container.setAttribute("href","../pages/rent.php?id="+data['rentID']);
        let rent = document.createElement('div');
        rent.setAttribute('class','request');
        rent.setAttribute('id','request' + data['rentID']);
        rent.innerHTML = 
        "<div id='userInfo'> <img class='requestProfilePicture' src=\"../images/profile/"+ data['profilePicture'] +".jpg\" "+
        "<a href=\"../pages/user.php?id=" + data['tourist'] + 
        "\"> <h3>" + data['userName'] + "</h3> </a> </div>"+
        "<a href=\"../pages/house.php?id=" + data['place'] + 
        "\"> <h3>" + data['title'] + "</h3> </a>"+
        "<div id='dates'><h3 id='from'>From: " + data['startDate'] + "</h3>"+
        "<h3 id='to'>To: " + data['endDate'] + "</h3> </div>";
        let startDate = new Date(data['startDate']).getTime();
        let currentDate = new Date().getTime();
        if(startDate < currentDate ){
            data['accepted'] = -2;
        }
        if(data['accepted'] == 0){
            rent.innerHTML += "<h3>Status: Waiting for response </h3>";
        }else if(data['accepted'] == 1){
            rent.innerHTML += "<h3>Status: Accepted </h3>"
            let maxLimit = new Date();  maxLimit.setDate(maxLimit.getDate()+10); //maximo sao 10 dias
            let startDate = new Date(data['startDate']);
            console.log(startDate.getUTCDate());
            console.log(maxLimit.getUTCDate());
            if(startDate.getTime() > maxLimit.getTime() ){
                rent.innerHTML +=" <div id='cancelation'> <button onclick=\"cancellOffer(" + data['rentID'] + ")\">Cancell</button> </div>";
            }
        }else if(data['accepted'] == -1){
            rent.innerHTML += "<h3>Status: Declined </h3>"
        }else if(data['accepted'] == -2){
            rent.innerHTML += "<h3>Status: Exceded time </h3>"
        }else if(data['accepted'] == -3){
            rent.innerHTML += "<h3>Status: Canceled </h3>"
        }

        rent_container.append(rent);
        rentDiv.append(rent_container);
    });

}




function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}
