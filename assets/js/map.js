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
        const long = (amb[i].longitude !== null) ? amb[i].longitude : centerFrance[0];
        const lat = (amb[i].latitude !== null) ? amb[i].latitude : centerFrance[1];
        const picture = (amb[i].picture !== null) ? `/uploads/user/${amb[i].picture}` : '/build/placeholder_profil_grey.png';
        // eslint-disable-next-line no-undef
        const m = L.marker([long, lat]);

        let customPopup = `<div class="d-flex flex-row popup"><div class="w-50">
            <img class="img-fluid" src=${picture} alt="${amb[i].firstname}">
            </div> <div class="w-50 d-flex flex-column">
            <h4 class="text-center popupTitle">${entities.encode(amb[i].firstname)}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${entities.encode(amb[i].city)}</p>
            <p class="m-0 ml-3 popupText">Rôles : ${entities.encode(duties.join(', '))}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${entities.encode(categories.join(', '))}</p>
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
            const long = (event.longitude !== null) ? event.longitude : centerFrance[0];
            const lat = (event.latitude !== null) ? event.latitude : centerFrance[1];
            // eslint-disable-next-line no-undef
            const m = L.marker([long, lat]);

            const dateEvent = new Date(event.dateTime.timestamp * 1e3);
            const optionsDate = {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            };
            const optionsTime = { hour: '2-digit', minute: '2-digit' };
            let customPopup = `<div class="d-flex flex-row popup">
            <div class="d-flex flex-column">
            <h4 class="text-center popupTitle">${entities.encode(event.description)}</h4>
            <p class="m-0 ml-3 popupText">Lieu : ${entities.encode(event.place)}</p>
            <p class="m-0 ml-3 popupText">Date : ${dateEvent.toLocaleDateString('fr-FR', optionsDate)}</p>
            <p class="m-0 ml-3 popupText">Heure : ${dateEvent.toLocaleTimeString('fr-FR', optionsTime)}</p>
            <p class="m-0 ml-3 popupText">Hôte : ${entities.encode(amb[i].firstname)} ${entities.encode(amb[i].lastname)}</p>
            <p class="m-0 ml-3 popupText">Créateur : ${entities.encode(event.brand.name)}</p>
            <p class="m-0 ml-3 popupText"> Univers : ${entities.encode(categories.join(', '))}</p>
            <div class="d-flex justify-content-around">
            <a class="fb-ic-card" href="/user/${amb[i].id}">
            <i class="far fa-user"></i></a>`;
            if (amb[i].urlFacebook) {
                customPopup += `<a class="fb-ic-card" href="${entities.encode(amb[i].urlFacebook)}">
                    <i class="fab fa-facebook-square "></i></a>`;
            }
            if (event.brand.instagram) {
                customPopup += `<a class="fb-ic-card" href="${entities.encode(event.brand.instagram)}">
                    <i class="fab fa-instagram"></i></a>`;
            }
            customPopup += '</div> </div> </div>';

            m.bindPopup(customPopup);
            mar.addLayer(m);
        }
    }
    map.addLayer(markers);
}
