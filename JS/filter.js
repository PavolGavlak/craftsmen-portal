const input = document.querySelector(".filter-input");
const select = document.querySelector(".filter-select");
const allOneCraftsmen = document.querySelectorAll(".one-craftsman");

function normalizeText(text) {
    return text
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .trim();
}

if (input && select && allOneCraftsmen.length) {
    const applyFilters = () => {
        const inputText = normalizeText(input.value);
        const selectedCraft = normalizeText(select.value);

        allOneCraftsmen.forEach((oneCraftsman) => {
            const craftsmenName = normalizeText(
                oneCraftsman.querySelector("h2")?.textContent ?? ""
            );
            const craftsmanCraft = normalizeText(
                oneCraftsman.dataset.craftName ?? ""
            );

            const matchesName = craftsmenName.includes(inputText);
            const matchesCraft = selectedCraft === "" || craftsmanCraft.includes(selectedCraft);
            const shouldShow = matchesName && matchesCraft;

            oneCraftsman.style.display = shouldShow ? "" : "none";
        });
    };

    input.addEventListener("input", applyFilters);
    select.addEventListener("change", applyFilters);
}
