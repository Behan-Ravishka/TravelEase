// Smooth scrolling to the top of the page
function scrollToTop() {
    window.scrollTo({ 
        top: 0, 
        behavior: 'smooth' 
    });
}
// Show/Hide Button on Scroll
window.onscroll = function () {
    const topButton = document.getElementById("topButton");
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        topButton.classList.remove("hidden");
    } else {
        topButton.classList.add("hidden");
    }
};
