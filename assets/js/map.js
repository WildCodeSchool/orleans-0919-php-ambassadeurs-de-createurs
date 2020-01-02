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

const a = document.querySelector('.js-ambassadors');
const ambassadors = JSON.parse(a.dataset.ambassadors);

document.addEventListener('DOMContentLoaded', () => {
    // eslint-disable-next-line no-use-before-define
    mapAmbasadors(ambassadors, markers);
});

map.addLayer(markers);

function mapAmbasadors(amb, mar) {
    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in amb) {
        const duties = [];
        const categories = [];
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in amb[i].duties) {
            duties[j] = amb[i].duties[j].name;
        }
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in amb[i].categories) {
            categories[j] = amb[i].categories[j].description;
        }
        // eslint-disable-next-line no-undef
        const m = L.marker([amb[i].coordinates[1], amb[i].coordinates[0]]);

        const customPopup = `<div class="d-flex flex-row popup"><div class="w-50">
            <img src="${amb[i].picture}" alt="${amb[i].firstname} ${amb[i].lastname}">
            </div> <div class="w-50 d-flex flex-column">
            <h4 class="text-center popupTitle">${amb[i].firstname} ${amb[i].lastname}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${amb[i].city}</p>
            <p class="m-0 ml-3 popupText">Rôles : ${duties.join(', ')}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${categories.join(', ')}</p>
            <a class="fb-ic-card" href="${amb[i].urlFacebook}">
            <i class="fab fa-facebook-square ">
            </i> </a> </div> </div>`;

        m.bindPopup(customPopup, { minWidth: 400 });
        mar.addLayer(m);
    }
}
