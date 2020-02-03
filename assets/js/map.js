const Entities = require('html-entities').XmlEntities;

const entities = new Entities();
// Saint Palais in Cher, center of France
const centerFrance = [47.242419, 2.408616];
// eslint-disable-next-line no-undef
const map = L.map('map', { gestureHandling: true }).setView(centerFrance, 6);
// eslint-disable-next-line no-undef
L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png', {
    maxZoom: 12,
    attribution: '<a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>',
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

// eslint-disable-next-line no-undef,func-names
$('#events').on('click', function () {
    // eslint-disable-next-line no-undef
    $('#ambassadors').removeClass('active');
    // eslint-disable-next-line no-undef
    $(this).addClass('active');
    markers.clearLayers();
    // eslint-disable-next-line no-use-before-define
    mapEvents(events, markers);
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
        const long = amb[i].longitude;
        const lat = amb[i].latitude;
        if (!long || !lat) {
            // eslint-disable-next-line no-continue
            continue;
        }
        const picture = (amb[i].picture !== null) ? `/uploads/user/${amb[i].picture}` : '/build/placeholder_profil_grey.png';
        // eslint-disable-next-line no-undef
        const m = L.marker([long, lat]);
        const customPopup = `<div class="text-break popup">
            <a class="mapPopupLink d-flex flex-column" href="/user/${amb[i].id}">
            <img class="img-fluid rounded-circle align-self-center m-4" src=${picture} alt="${entities.encode(amb[i].firstname)}">
            <h4 class="text-center popupTitle">${entities.encode(amb[i].firstname)}</h4>
            <p class="m-0 popupText"><i class="fas fa-map-marker-alt primary-color mr-3"></i> ${entities.encode(amb[i].city)}</p>
            <p class="m-0 popupText"><i class="fas fa-donate primary-color mr-3"></i> ${entities.encode(amb[i].duty)}</p>
            <p class="m-0 popupText"><i class="fas fa-heart primary-color mr-3"></i> ${entities.encode(amb[i].category)}</p>
            </a> </div>`;
        m.bindPopup(customPopup, { minWidth: 300 });
        mar.addLayer(m);
    }
    map.addLayer(markers);
}

// eslint-disable-next-line no-shadow
function mapEvents(ev, mar) {
    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in ev) {
        const long = ev[i].longitude;
        const lat = ev[i].latitude;
        if (!long || !lat) {
            // eslint-disable-next-line no-continue
            continue;
        }
        // eslint-disable-next-line no-undef
        const m = L.marker([long, lat]);
        const customPopup = `<div class="d-flex flex-column text-break popup">
        <a class="mapPopupLink" href="/user/${ev[i].id}">
        <h4 class="text-center popupTitle">${entities.encode(ev[i].host)}</h4>
        <p class="m-0 popupText"><i class="fas fa-map-marker-alt primary-color mr-3"></i> ${entities.encode(ev[i].city)}</p>
        <p class="m-0 popupText"><i class="fas fa-calendar-week primary-color mr-3"></i> ${entities.encode(ev[i].date)}</p>
        <p class="m-0 popupText"><i class="far fa-clock primary-color mr-3"></i> ${entities.encode(ev[i].time)}</p>
        <p class="m-0 popupText"><i class="fas fa-heart primary-color mr-3"></i> ${entities.encode(ev[i].category)}</p>
        <p class="m-0 my-3 popupText">${entities.encode(ev[i].description)}</p>
        </a> </div>`;

        m.bindPopup(customPopup, { minWidth: 300 });
        mar.addLayer(m);
    }
    map.addLayer(markers);
}
