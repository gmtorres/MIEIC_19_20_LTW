'use strict';

function removeImage(imageId) {
    let request = new XMLHttpRequest();
    request.open('get', '../actions/deletePlacePicture.php?' + encodeForAjax({'imageId': imageId}) , true);
    request.addEventListener('load', refreshImage);
    request.send();
}

function refreshImage(){

    let image = JSON.parse(this.responseText);
    let imageElem = document.getElementById("image"+image['imageId']);
    if(imageElem == null)
        return;
    imageElem.remove();
    initSlides();
    showSlides(slideIndex);
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}