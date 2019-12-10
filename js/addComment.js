"use strict";

document.getElementById('commentForm').addEventListener('submit',function (event) {
    let placeId = document.getElementById("placeIdForm").value;
    let writerId = document.getElementById("writerIdForm").value;
    let title = document.getElementById("titleForm").value;
    let comment = document.getElementById("commentTextForm").value;
    let classification = document.getElementById("classificationForm").value;
    let request = new XMLHttpRequest();
    request.open('post', '../actions/addComment.php' , true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener('load', reloadAddComment);
    request.send(encodeForAjax({'placeId' : placeId , 'writerId' : writerId , 'title' : title , "comment" : comment , "classification" : classification}));
    
    event.preventDefault();
});

function reloadAddComment(){
    let data = JSON.parse(this.responseText);
    
    let commentSection = document.getElementById('Comments');
    let comment = document.createElement('div');
    comment.setAttribute("class",'comment');

    let commentInfo = document.createElement('div');
    commentInfo.setAttribute("class",'commentInfo');

    commentInfo.innerHTML = "<div id=\'commentUserPicture\'> <a href='user.php?id="+data["writerId"]+
                            "'> <img src='../images/profile/"  + data['pic'] + ".jpg'> </a> </div>" + 
                            "<a href='user.php?id="+data["writerId"]+
                            "'> <h5>"+ data["username"] + "</h5> </a>" + "<h3>" + data['classification'] + "</h3>";

    
    let commentText = document.createElement('div');
    commentText.setAttribute("class",'commentText');

    commentText.innerHTML = "<div class='commentHeader'> <h3 class='commentTitle'>"+ data['title'] +"</h3>"+ 
                            "<h3 class='commentDate'>"+ formatDate(Date())  +"</h3> </div> <h4>"+ data['comment'] +"</h4>";


    comment.append(commentInfo);
    comment.append(commentText);

    commentSection.append(comment);

    document.getElementById("titleForm").value=null;
    document.getElementById("commentTextForm").value=null;
    document.getElementById("classificationForm").value=null;

}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}