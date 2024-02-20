// document.addEventListener('DOMContentLoaded', function () {
//     // Function to scroll to the top of the page
//     function scrollToTop() {
//         window.scrollTo({ top: 0, behavior: 'smooth' });
//     }

//     // Show the arrow button when scrolling down, hide when at the top
//     window.addEventListener('scroll', () => {
//         if (window.scrollY > 100) {
//             scrollBtn.style.display = 'flex';
//         } else {
//             scrollBtn.style.display = 'none';
//         }
//     });

//     /*scroll to top*/
//     const scrollBtn = document.querySelector('.move_up_icon');
//     scrollBtn.addEventListener("click", scrollToTop);






    
// });
  
  document.addEventListener('DOMContentLoaded', function() {
    var scrollToTopBtn = document.querySelector('.move_up_icon');
    var scrollableContainer = document.querySelector('.scrollable');
  
    // Show or hide the scroll-to-top button based on scroll position
    scrollableContainer.addEventListener('scroll', function() {
      if (scrollableContainer.scrollTop > 20) {
        scrollToTopBtn.style.display = 'flex';
      } else {
        scrollToTopBtn.style.display = 'none';
      }
    });
  
    // Scroll to top when the button is clicked
    scrollToTopBtn.addEventListener('click', function() {
      scrollableContainer.scrollTop = 0;
      scrollableContainer.style.transition = '5s';
    });
  });
  