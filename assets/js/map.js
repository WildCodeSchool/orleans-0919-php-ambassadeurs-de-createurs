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

const ambassadorsSelector = document.querySelector('.js-ambassadors');
const ambassadors = JSON.parse(ambassadorsSelector.dataset.ambassadors);
const eventsSelector = document.querySelector('.js-events');
const events = JSON.parse(eventsSelector.dataset.events);

document.addEventListener('DOMContentLoaded', () => {
    // eslint-disable-next-line no-use-before-define
    mapEvents(events, markers);
});

// eslint-disable-next-line no-undef
$('#events').on('click', function () {
    $('#ambassadors').removeClass('active');
    $(this).addClass('active');
    markers.clearLayers();
    // eslint-disable-next-line no-use-before-define
    mapEvents(events, markers);
});

// eslint-disable-next-line no-undef
$('#ambassadors').on('click', function () {
    $('#events').removeClass('active');
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
    map.addLayer(markers);
}

function mapEvents(events, mar) {

    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in events) {
        const categories = [];
        // eslint-disable-next-line guard-for-in,no-restricted-syntax
        for (const j in events[i].user.categories) {
            categories[j] = events[i].user.categories[j].description;
        }
        // eslint-disable-next-line no-undef
        const m = L.marker([events[i].coordinates[1], events[i].coordinates[0]]);

        const dateEvent = new Date(events[i].dateTime.timestamp * 1e3);
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const optionsTime = { hour: '2-digit', minute: '2-digit' };
        const customPopup = `<div class="d-flex flex-row popup">
            <div class="d-flex flex-column">
            <h4 class="text-center popupTitle">${events[i].description}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${events[i].place}</p>
            <p class="m-0 ml-3 popupText">Date : ${dateEvent.toLocaleDateString('fr-FR', optionsDate)}</p>
            <p class="m-0 ml-3 popupText">Heure : ${dateEvent.toLocaleTimeString('fr-FR', optionsTime)}</p>
            <p class="m-0 ml-3 popupText">Hôte : ${events[i].user.firstname} ${events[i].user.lastname}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${categories.join(', ')}</p>
            </div> </div>`;

        m.bindPopup(customPopup);
        mar.addLayer(m);
    }
    map.addLayer(markers);
}
