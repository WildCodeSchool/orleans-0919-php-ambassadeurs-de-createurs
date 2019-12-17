const map = L.map('map', { gestureHandling: true }).setView([48.866667, 2.333333], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 12,
    attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>',

}).addTo(map);
L.control.scale().addTo(map);
L.marker([48.866667, 2.333333]).addTo(map);
