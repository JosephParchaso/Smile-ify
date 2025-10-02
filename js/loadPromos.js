document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.getElementById("promoWrapper");
    if (!wrapper) return;

    fetch(`${BASE_URL}/processes/get_promos.php`)
    .then(res => res.json())
    .then(promos => {
        wrapper.innerHTML = "";

        if (promos.length === 0) {
            wrapper.innerHTML = `<p class="no-promo">No active promos right now.</p>`;
            return;
        }

        promos.forEach(promo => {
            const slide = document.createElement("div");
            slide.className = "swiper-slide";
            slide.innerHTML = `
                <div class="promo-card">
                    <img src="${BASE_URL}${promo.image_path}" alt="Promo" class="promo-img">
                    <div class="promo-overlay">
                        <h4>${promo.name}</h4>
                        <p>
                            ${promo.start_date ? new Date(promo.start_date).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : "No date set"}
                            ${promo.end_date ? " – " + new Date(promo.end_date).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" }) : ""}
                        </p>
                    </div>
                </div>
            `;
            wrapper.appendChild(slide);
        });

        let slidesPerView = Math.min(promos.length, 3);
        let enableLoop = promos.length > 3;

        new Swiper(".promo-slider", {
            slidesPerView: slidesPerView,
            spaceBetween: 20,
            loop: enableLoop,
            autoplay: promos.length > 1 ? {
                delay: 3000,
                disableOnInteraction: false
            } : false,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                0: { slidesPerView: Math.min(promos.length, 1) },
                768: { slidesPerView: Math.min(promos.length, 2) },
                1024: { slidesPerView: Math.min(promos.length, 3) }
            }
        });
    })
    .catch(err => {
        console.error("Failed to load promos:", err);
    });
});
