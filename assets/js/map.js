const map = L.map('map', { gestureHandling: true }).setView([48.866667, 2.333333], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 12,
    attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>',

}).addTo(map);
L.control.scale().addTo(map);

let markers = L.markerClusterGroup();

markers.addLayer(L.marker([48.866667, 2.333333]));
markers.addLayer(L.marker([47.866667, 3.333333]));
markers.addLayer(L.marker([46.866667, 4.333333]));
markers.addLayer(L.marker([45.866667, 5.333333]));
markers.addLayer(L.marker([44.866667, 6.333333]));
markers.addLayer(L.marker([43.866667, 7.333333]));
markers.addLayer(L.marker([42.866667, 8.333333]));
markers.addLayer(L.marker([41.866667, 9.333333]));
markers.addLayer(L.marker([40.866667, 10.333333]));
markers.addLayer(L.marker([39.866667, 1.333333]));
m = L.marker([38.866667, 11.333333]);
m.bindPopup('<p>' + 'Super event!' + '</p>');
markers.addLayer(m);

map.addLayer(markers);
