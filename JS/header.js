const headerElement = document.querySelector("header");
const menuIcon = document.querySelector(".menu-icon");
const navigation = document.querySelector("nav");
const hamburgerIcon = document.querySelector(".fa-solid");

function syncHeaderState() {
    if (!headerElement) {
        return;
    }

    headerElement.classList.toggle("is-at-top", window.scrollY <= 0);
}

if (menuIcon && navigation && hamburgerIcon) {
    menuIcon.addEventListener("click", () => {
        if (hamburgerIcon.classList.contains("fa-bars")) {
            hamburgerIcon.classList.remove("fa-bars");
            hamburgerIcon.classList.add("fa-xmark");
            navigation.style.display = "block";
        } else {
            hamburgerIcon.classList.remove("fa-xmark");
            hamburgerIcon.classList.add("fa-bars");
            navigation.style.display = "none";
        }
    });
}

syncHeaderState();
window.addEventListener("scroll", syncHeaderState, { passive: true });
