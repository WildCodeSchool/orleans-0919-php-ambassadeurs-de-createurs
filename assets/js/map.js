// Saint Palais in Cher, center of France
const centerFrance = [47.242419, 2.408616];

// eslint-disable-next-line no-undef
const map = L.map('map', { gestureHandling: true }).setView(centerFrance, 6);

// eslint-disable-next-line no-undef
// const url = 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png';
// const url = 'https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.png';
// const url = 'https://{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png';
const url = 'https://{s}.tile.thunderforest.com/spinal-map/{z}/{x}/{y}.png';

L.tileLayer(url, {
    maxZoom: 12,
    attribution: '&copy; Openstreetmap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);
// eslint-disable-next-line no-undef
L.control.scale().addTo(map);

// eslint-disable-next-line no-undef
const markers = L.markerClusterGroup({
    showCoverageOnHover: false,
});

const ambassadorsSelector = document.querySelector('.js-ambassadors');
const ambassadors = JSON.parse(ambassadorsSelector.dataset.ambassadors);

document.addEventListener('DOMContentLoaded', () => {
    // eslint-disable-next-line no-use-before-define
    mapEvents(ambassadors, markers);
});

// eslint-disable-next-line no-undef,func-names
$('#events').on('click', function () {
    // eslint-disable-next-line no-undef
    $('#ambassadors').removeClass('active');
    // eslint-disable-next-line no-undef
    $(this).addClass('active');
    markers.clearLayers();
    // eslint-disable-next-line no-use-before-define
    mapEvents(ambassadors, markers);
});

// eslint-disable-next-line no-undef,func-names
$('#ambassadors').on('click', function () {
    // eslint-disable-next-line no-undef
    $('#events').removeClass('active');
    // eslint-disable-next-line no-undef
    $(this).addClass('active');
    markers.clearLayers();
    // eslint-disable-next-line no-use-before-define
    mapAmbasadors(ambassadors, markers);
});

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
        const m = L.marker([amb[i].longitude, amb[i].latitude]);

        const customPopup = `<div class="d-flex flex-row popup"><div class="w-50">
            <img class="img-fluid" src="${amb[i].picture}" alt="${amb[i].firstname} ${amb[i].lastname}">
            </div> <div class="w-50 d-flex flex-column">
            <h4 class="text-center popupTitle">${amb[i].firstname} ${amb[i].lastname}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${amb[i].city}</p>
            <p class="m-0 ml-3 popupText">Rôles : ${duties.join(', ')}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${categories.join(', ')}</p>
            <div class="d-flex justify-content-around">
            <a class="fb-ic-card" href="/user/${amb[i].id}">
            <i class="far fa-user"></i></a>
            <a class="fb-ic-card" href="${amb[i].urlFacebook}">
            <i class="fab fa-facebook-square "></i></a>
            </div> </div> </div>`;

        m.bindPopup(customPopup, { minWidth: 320 });
        mar.addLayer(m);
    }
    map.addLayer(markers);
}

// eslint-disable-next-line no-shadow
function mapEvents(amb, mar) {
    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in amb) {
        const categories = [];
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in amb[i].categories) {
            categories[j] = amb[i].categories[j].description;
        }
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in amb[i].events) {
            const event = amb[i].events[j];
            // eslint-disable-next-line no-undef
            const m = L.marker([event.longitude, event.latitude]);

            const dateEvent = new Date(event.dateTime.timestamp * 1e3);
            const optionsDate = {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            };
            const optionsTime = { hour: '2-digit', minute: '2-digit' };
            const customPopup = `<div class="d-flex flex-row popup">
            <div class="d-flex flex-column">
            <h4 class="text-center popupTitle">${event.description}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${event.place}</p>
            <p class="m-0 ml-3 popupText">Date : ${dateEvent.toLocaleDateString('fr-FR', optionsDate)}</p>
            <p class="m-0 ml-3 popupText">Heure : ${dateEvent.toLocaleTimeString('fr-FR', optionsTime)}</p>
            <p class="m-0 ml-3 popupText">Hôte : ${amb[i].firstname} ${amb[i].lastname}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${categories.join(', ')}</p>
            <div class="d-flex justify-content-around">
            <a class="fb-ic-card" href="/user/${amb[i].id}">
            <i class="far fa-user"></i></a>
            <a class="fb-ic-card" href="${amb[i].urlFacebook}">
            <i class="fab fa-facebook-square "></i></a>
            </div> </div> </div>`;

            m.bindPopup(customPopup);
            mar.addLayer(m);
        }
    }
    map.addLayer(markers);
}
