var slideIndex = 1;
initSlides();
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function initSlides() {
  var slideShow = document.getElementById('image_slideshow');
  var slides = slideShow.getElementsByClassName("slideImage");

  let prevDots= document.getElementById('imageSliderDots');
  if(prevDots != null)
    prevDots.remove();
  
  let dots = document.createElement('div');
  dots.setAttribute('id','imageSliderDots');
  dots.setAttribute('style' , 'text-align:center');

  if(slides.length == 0){
    return;
  }

  let button1 = document.createElement('a');
  button1.setAttribute('class','prev');
  button1.setAttribute('onclick','plusSlides(-1)');
  button1.innerHTML = "&#10094";
  //slideShow.append(button1);

  let button2 = document.createElement('a');
  button2.setAttribute('class','next');
  button2.setAttribute('onclick','plusSlides(+1)');
  button2.innerHTML = "&#10095";
  //slideShow.append(button2);

  dots.append(button1);
  for(let i = 0; i < slides.length;i++){
    dots.innerHTML += 
    "<span class=\"dot\" onclick=\"showSlides("+ (i+1) +")\"> </span>";
  }
  dots.append(button2);
  slideShow.append(dots);
}

function showSlides(n) {
  var i;
  var slideShow = document.getElementById('image_slideshow');
  var slides = slideShow.getElementsByClassName("slideImage");
  var dots = document.getElementsByClassName("dot");
  if(slides.length == 0) return;
  if (n > slides.length) {slideIndex = 1}
  else if (n < 1) {slideIndex = slides.length;}
  else slideIndex = n;
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
} 