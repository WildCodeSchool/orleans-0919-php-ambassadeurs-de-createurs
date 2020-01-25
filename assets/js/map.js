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
        const long = (amb[i].longitude !== null) ? amb[i].longitude : centerFrance[0];
        const lat = (amb[i].latitude !== null) ? amb[i].latitude : centerFrance[1];
        const picture = (amb[i].picture !== null) ? `/uploads/user/${amb[i].picture}` : '/build/placeholder_profil_grey.png';
        // eslint-disable-next-line no-undef
        const m = L.marker([long, lat]);
        let customPopup = `<div class="d-flex flex-row popup"><div class="w-50">
            <img class="img-fluid" src=${picture} alt="${entities.encode(amb[i].firstname)}">
            </div> <div class="w-50 d-flex flex-column">
            <h4 class="text-center popupTitle">${entities.encode(amb[i].firstname)}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${entities.encode(amb[i].city)}</p>
            <p class="m-0 ml-3 popupText">Rôles : ${entities.encode(amb[i].duty)}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${entities.encode(amb[i].category)}</p>
            <div class="d-flex justify-content-around">
            <a class="fb-ic-card" href="/user/${amb[i].id}">
            <i class="far fa-user"></i></a>`;
        if (amb[i].urlFacebook) {
            customPopup += `<a class="fb-ic-card" href="${entities.encode(amb[i].urlFacebook)}">
            <i class="fab fa-facebook-square "></i></a>`;
        }
        customPopup += '</div> </div> </div>';
        m.bindPopup(customPopup, { minWidth: 320 });
        mar.addLayer(m);
    }
    map.addLayer(markers);
}

// eslint-disable-next-line no-shadow
function mapEvents(ev, mar) {
    // eslint-disable-next-line guard-for-in,no-restricted-syntax
    for (const i in ev) {
        const long = (ev[i].longitude !== null) ? ev[i].longitude : centerFrance[0];
        const lat = (ev[i].latitude !== null) ? ev[i].latitude : centerFrance[1];
        // eslint-disable-next-line no-undef
        const m = L.marker([long, lat]);
        let customPopup = `<div class="d-flex flex-row popup">
        <div class="d-flex flex-column">
        <h4 class="text-center popupTitle">${entities.encode(ev[i].description)}</h4>
        <p class="m-0 ml-3 popupText">Lieu : ${entities.encode(ev[i].city)}</p>
        <p class="m-0 ml-3 popupText">Date : ${entities.encode(ev[i].date)}</p>
        <p class="m-0 ml-3 popupText">Heure : ${entities.encode(ev[i].time)}</p>
        <p class="m-0 ml-3 popupText">Hôte : ${entities.encode(ev[i].host)}</p>
        <p class="m-0 ml-3 popupText">Créateur : ${entities.encode(ev[i].creator)}</p>
        <p class="m-0 ml-3 popupText"> Univers : ${entities.encode(ev[i].category)}</p>
        <div class="d-flex justify-content-around">
        <a class="fb-ic-card" href="/user/${entities.encode(ev[i].id)}">
        <i class="far fa-user"></i></a>`;
        if (ev[i].urlFacebook) {
            customPopup += `<a class="fb-ic-card" href="${entities.encode(ev[i].urlFacebook)}">
                <i class="fab fa-facebook-square "></i></a>`;
        }
        if (ev[i].urlInstagram) {
            customPopup += `<a class="fb-ic-card" href="${entities.encode(ev[i].urlInstagram)}">
                <i class="fab fa-instagram"></i></a>`;
        }
        customPopup += '</div> </div> </div>';

        m.bindPopup(customPopup);
        mar.addLayer(m);
    }
    map.addLayer(markers);
}
