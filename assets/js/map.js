const map = L.map('map', { gestureHandling: true }).setView([48.866667, 2.333333], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 12,
    attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>',
}).addTo(map);
L.control.scale().addTo(map);

const markers = L.markerClusterGroup();

document.addEventListener('DOMContentLoaded', () => {
    const ambassadorsCoordinates = document.querySelector('.js-coordinates');
    const coordinates = JSON.parse(ambassadorsCoordinates.dataset.coordinates);
    console.log(coordinates);

    for (coordinate in coordinates) {
        markers.addLayer(L.marker([coordinates[coordinate][1], coordinates[coordinate][0]]));
    }
});

m = L.marker([38.866667, 11.333333]);
m.bindPopup('<p>' + 'Super event!' + '</p>');
markers.addLayer(m);
map.addLayer(markers);
