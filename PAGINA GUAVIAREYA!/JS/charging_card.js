document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const loadingCard = document.getElementById("loading-card");
    const contentCard = document.getElementById("content-card");

    form.addEventListener("submit", function() {
        loadingCard.style.display = "block";
        contentCard.style.display = "none";
    });
});