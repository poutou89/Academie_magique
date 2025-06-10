document.addEventListener("DOMContentLoaded", () => {
    const burger = document.getElementById("burger");
    const navLinks = document.getElementById("navLinks");
  
    burger.addEventListener("click", (e) => {
      e.preventDefault();
      navLinks.classList.toggle("active");
    });
  });