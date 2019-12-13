'use strict';

var calendar = null;

function addAvailable(placeId,start,end,price , calendario){
    calendar = calendario;
    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeAvailability.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadAddAvailable);
    request.send(encodeForAjax({'function' : 'addAvailableDates','placeId' : placeId , 'startDate' : start , 'endDate' : end , 'price' : price}));
}


function reloadAddAvailable(){
    let data = JSON.parse(this.responseText);

    let reservations = document.getElementById('availables');

    let available = document.createElement('div');
    available.setAttribute('id','availableDate' + data['id']);
    available.setAttribute('class','availableDate');
    available.innerHTML = '<h3>From: ' + data['start'] + '</h3><h3>To: ' +data['end']+ '</h3><h3>Price: '+data['price']+ '€/night</h3>'+
    '<button type=\'button\' onclick=\'removeAvailable(' + data['id' ] + ',calendarioRef)\'> Remove </button>';

    let br = document.createElement('br');
    reservations.prepend(br);
    reservations.prepend(available);

    calendar.addBlocked([data['start'],data['end']]);
    calendar.resetDates();
}

function removeAvailable(availableId , calendario){
    calendar = calendario;

    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeAvailability.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadRemoveAvailable);
    request.send(encodeForAjax({'function' : 'removeAvailableDates' , 'availableId' : availableId}));
}

function reloadRemoveAvailable(){
    let data = JSON.parse(this.responseText);

    let available =  document.getElementById('availableDate'+data['id']);
    available.remove();
    calendar.removeBlocked([data['start'],data['end']]);
    calendar.resetDates();
}




function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}