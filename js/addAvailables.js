'use strict';

var calendar = null;

function addAvailable(placeId,start,end,price , calendario){
    calendar = calendario;
    let request = new XMLHttpRequest();
    request.open('post', '../actions/addAvailability.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadAvailable);
    request.send(encodeForAjax({'placeId' : placeId , 'startDate' : start , 'endDate' : end , 'price' : price}));
}


function reloadAvailable(){
    let data = JSON.parse(this.responseText);

    let reservations = document.getElementById('availables');

    let available = document.createElement('div');
    available.setAttribute('id','available');
    available.innerHTML = '<h3>' + data[0] + '</h3><h3>' +data[1]+ '</h3><h3>'+data[2]+ '</h3>';
    reservations.prepend(available);

    calendar.addBlocked([data[0],data[1]]);
    calendar.resetDates();

}






function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}