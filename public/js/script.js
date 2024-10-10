// Modal Image Gallery
function onClick(element) {
    document.getElementById("img01").src = element.src;
    document.getElementById("modal01").style.display = "block";
    var captionText = document.getElementById("caption");
    captionText.innerHTML = element.alt;
  }
  

  var mySidebar = document.getElementById("mySidebar");
  
  function w3_open() {
    if (mySidebar.style.display === 'block') {
      mySidebar.style.display = 'none';
    } else {
      mySidebar.style.display = 'block';
    }
  }
  
  function w3_close() {
      mySidebar.style.display = "none";
  }
  

// document.addEventListener("DOMContentLoaded", () => {
//   const navToggle = document.getElementById("nav-toggle");
//   const navMenu = document.getElementById("nav-menu");
//   const navBurger = document.querySelector(".nav__burger");
//   const navClose = document.querySelector(".nav__close");

//   navToggle.addEventListener("click", () => {
//     // Toggle menu visibility
//     navMenu.classList.toggle("show-menu"); // Toggle class to show/hide menu

//     // Toggle icons
//     navBurger.classList.toggle("hide-icon"); // Hide burger icon
//     navClose.classList.toggle("show-icon");  // Show close icon
//   });
// });
