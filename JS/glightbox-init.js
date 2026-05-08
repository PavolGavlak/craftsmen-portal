document.addEventListener("DOMContentLoaded", () => {
    if (typeof GLightbox === "undefined") {
        return;
    }

    GLightbox({
        selector: ".glightbox",
        loop: true,
        touchNavigation: true,
        closeButton: true
    });
});
