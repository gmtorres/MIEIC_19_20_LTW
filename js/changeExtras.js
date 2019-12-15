"use scrict";

function addExtra(placeId){
    //console.log("a");
    let description = document.getElementById('extraDescription');
    if(description.value == ""){
        description.focus();
        return;
    }
    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeExtras.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadExtras);
    request.send(encodeForAjax({'function' : 'addExtra','placeId' : placeId , 'description' : description.value}));
    description.value = "";
}

function reloadExtras(){
    let data = JSON.parse(this.responseText);

    let extras = document.getElementById('extras');
    let extra = document.createElement('div');
    extra.setAttribute('class','extra');
    extra.setAttribute('id','extra'+data['id']);
    extra.innerHTML = "<h3>"+data['description'] +
                    "</h3> <button type=\"button\" onclick=\"removeExtra("+data['id'] + ")\"> Remove Extra </button>";
    
    extras.append(extra);

}

function removeExtra(id){
    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeExtras.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadExtrasRemove);
    request.send(encodeForAjax({'function' : 'removeExtra', 'id' : id}));
}
function reloadExtrasRemove(){
    let data = JSON.parse(this.responseText);
    document.getElementById('extra'+data['id']).remove();
}




function addRestriction(placeId){
    //console.log("a");
    let description = document.getElementById('restrictionDescription');
    if(description.value == ""){
        description.focus();
        return;
    }
    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeExtras.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadRestrictions);
    request.send(encodeForAjax({'function' : 'addRestriction','placeId' : placeId , 'description' : description.value}));
    description.value = "";
}

function reloadRestrictions(){
    let data = JSON.parse(this.responseText);

    let extras = document.getElementById('restrictions');
    let extra = document.createElement('div');
    extra.setAttribute('class','restriction');
    extra.setAttribute('id','restriction'+data['id']);
    extra.innerHTML = "<h3>"+data['description'] +
                    "</h3> <button type=\"button\" onclick=\"removeRestriction("+data['id'] + ")\"> Remove Restriction </button>";
    
    extras.append(extra);

}

function removeRestriction(id){
    let request = new XMLHttpRequest();
    request.open('post', '../actions/changeExtras.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadRestrictionRemove);
    request.send(encodeForAjax({'function' : 'removeRestriction', 'id' : id}));
}
function reloadRestrictionRemove(){
    let data = JSON.parse(this.responseText);
    document.getElementById('restriction'+data['id']).remove();
}



function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}