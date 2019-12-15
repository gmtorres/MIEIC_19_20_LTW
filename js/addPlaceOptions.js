'use strict';

let extrasIndex = 0;

function appendExtra() {
    let div = document.getElementById('extras');
    let description = document.getElementById('extraDescription').value;
    if(description == "") return;
    document.getElementById('extraDescription').value = "";
    let elem = document.createElement('div');
    elem.setAttribute('id','extra'+String(extrasIndex));
    elem.setAttribute('class','extra');
    elem.innerHTML = "<h4>" +  description + "</h4> <button type='button' onclick='removeElem("+'extra'+String(extrasIndex)+")' > Remove </button>" ;
    div.append(elem);
    extrasIndex++;
}

function appendRestriction() {
    let div = document.getElementById('restrictions');
    let description = document.getElementById('restrictionDescription').value;
    if(description == "") return;
    document.getElementById('restrictionDescription').value = "";
    let elem = document.createElement('div');
    elem.setAttribute('id','restriction' + String(extrasIndex));
    elem.setAttribute('class','restriction');
    elem.innerHTML = "<h4>" +  description + "</h4> <button type='button' onclick='removeElem("+'restriction' + String(extrasIndex)+")' > Remove </button>" ;
    div.append(elem);
    extrasIndex++;
}

function removeElem(id) {
    id.remove();
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

var form  = document.getElementsByTagName('form')[0];

form.addEventListener("submit" , function(event){
    let extraDiv = document.getElementById('extras');
    let extras = extraDiv.getElementsByClassName('extra');
    let array_extras = [];
    for(let i = 0; i < extras.length;i++){
        let description = extras[i].getElementsByTagName('h4')[0].innerText;
        array_extras.push(description);
    }
    let input1 = document.createElement('input');
    input1.setAttribute('hidden','true');
    //input1.setAttribute('type','text');
    input1.setAttribute('name','extrasInput');
    input1.setAttribute('id','extrasInput');
    input1.setAttribute('value',JSON.stringify(array_extras));
    form.append(input1);

    let restrictionsDiv = document.getElementById('restrictions');
    let restrictions = restrictionsDiv.getElementsByClassName('restriction');
    let array_restrictions = [];
    for(let i = 0; i < restrictions.length;i++){
        let description = restrictions[i].getElementsByTagName('h4')[0].innerText;
        array_restrictions.push(description);
    }
    let input2 = document.createElement('input');
    input2.setAttribute('hidden','true');
    //input2.setAttribute('type','text');
    input2.setAttribute('name','restrictionsInput');
    input2.setAttribute('id','restrictionsInput');
    input2.setAttribute('value',JSON.stringify(array_restrictions));
    form.append(input2);

    //event.preventDefault();
});


