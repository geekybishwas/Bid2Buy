
document.addEventListener('DOMContentLoaded', function () {
  let slides = document.getElementsByClassName("slide");
  let dots = document.getElementsByClassName("dot");
  let slideIndex = 1;

function showSlides(n) {
  if (n > slides.length) {
    slideIndex = 1;
  } else if (n < 1) {
    slideIndex = slides.length;
  }

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
    dots[i].addEventListener('click',()=>{
    currentSlide(i+1);
    });
  }

  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}



function plusSlides(n) {
  showSlides(slideIndex += n);
}



function currentSlide(n) {
  showSlides(slideIndex = n);
}


let prev=document.getElementsByClassName('prev')[0];
let next=document.getElementsByClassName('next')[0];
prev.addEventListener('click',()=>{
    plusSlides(-1);
});
next.addEventListener('click',()=>{
    plusSlides(1);
});
showSlides(slideIndex);
setInterval(()=>{
  plusSlides(1);
},7000);
/*end of slideshow process*/
/*on clicking banner image--*/
// let bannerImages=document.querySelectorAll('.slide img');
// for (let i = 0; i < bannerImages.length; i++) {
//   bannerImages[i].addEventListener('click',()=>{
//       alert("add function later on...");
//   });
// }
});