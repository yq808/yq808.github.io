var scrollTopArrow = document.getElementById("scroll-arrow");
var scrollTopArrowCont = document.getElementById("scroll-arrow-container");

window.addEventListener("scroll", () => {
    if (window.scrollY > 350) {
        scrollTopArrowCont.classList.add("show");
    } else {
        scrollTopArrowCont.classList.remove("show");
    }
});

scrollTopArrow.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});