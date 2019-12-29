// Saint Palais in Cher, center of France
const centerFrance = [47.242419, 2.408616];

// eslint-disable-next-line no-undef
const map = L.map('map', { gestureHandling: true }).setView(centerFrance, 6);

// eslint-disable-next-line no-undef
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 12,
    attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>',
}).addTo(map);
// eslint-disable-next-line no-undef
L.control.scale().addTo(map);

// eslint-disable-next-line no-undef
const markers = L.markerClusterGroup({
    showCoverageOnHover: false,
});

document.addEventListener('DOMContentLoaded', () => {
    const a = document.querySelector('.js-ambassadors');
    const ambassadors = JSON.parse(a.dataset.ambassadors);

    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in ambassadors) {
        const duties = [];
        const categories = [];
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in ambassadors[i].duties) {
            duties[j] = ambassadors[i].duties[j].name;
        }
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in ambassadors[i].categories) {
            categories[j] = ambassadors[i].categories[j].description;
        }
        // eslint-disable-next-line no-undef
        const m = L.marker([ambassadors[i].coordinates[1], ambassadors[i].coordinates[0]]);

        const customPopup = `<div class="d-flex flex-row popup"><div class="w-50">
            <img src="${ambassadors[i].picture}" alt="${ambassadors[i].firstname} ${ambassadors[i].lastname}">
            </div> <div class="w-50 d-flex flex-column">
            <h4 class="text-center popupTitle">${ambassadors[i].firstname} ${ambassadors[i].lastname}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${ambassadors[i].city}</p>
            <p class="m-0 ml-3 popupText">Rôles : ${duties.join()}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${categories.join()}</p>
            <a class="fb-ic-card" href="${ambassadors[i].urlFacebook}">
            <i class="fab fa-facebook-square ">
            </i> </a> </div> </div>`;

        m.bindPopup(customPopup, { minWidth: 400 });
        markers.addLayer(m);
    }
});

map.addLayer(markers);
