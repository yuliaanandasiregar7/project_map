
<!DOCTYPE html>
<html lang="en">

<head>
    <base target="_top">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="Bb30SpaE3eHXAqjQwXFZtyca7QCPk7Pk1us0zOpa">
    <title>Jumlah Puskesmas</title>
    <link rel="icon" type="image/svg+xml" href="https://sig.ahusa.cloud/img/sulsel.svg">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href=https://sig.ahusa.cloud/css/adminlte.min.css>

    <script src="https://kit.fontawesome.com/4530e241c6.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
    <style>
        #map {
            width: 100%;
            flex: 1;
        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>

    <style>
        #info-icon {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #007BFF;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
        }

        #info-icon i {
            font-size: 24px;
        }

        #info-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: none;
            z-index: 1001;
            width: 80%;
            max-width: 500px;
        }

        .popup-content h4 {
            margin-top: 0;
        }

        #close-popup {
            background: #007BFF;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        #close-popup:hover {
            background: #0056b3;
        }

        #info-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }
    </style>
</head>

<body style="font-family: Poppins;">
@include ('nav')
    <div id='map'></div>

    <div id="info-overlay"></div>
    <div id="info-icon">
        <i class="fas fa-info-circle"></i>
    </div>
    <div id="info-popup">
        <div class="popup-content">
            <h4>Info Halaman</h4>
            <p>Ini adalah halaman kepadatan penduduk di Sulawesi Selatan. Anda dapat melihat peta interaktif dengan data
                kepadatan penduduk berdasarkan kabupaten/kota.</p>
            <button id="close-popup">Tutup</button>
        </div>
    </div>


    <script type="text/javascript">
        var map = L.map('map').setView([-3.118840, 129.420780], 7.4);
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> | <a href="https://sulsel.bps.go.id/id/statistics-table/2/ODMjMg==/jumlah-penduduk-menurut-kabupaten-kota" target="_blank">BPS Sulawesi Selatan</a>'
        }).addTo(map);

        const info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function (props) {
            const contents = props ? `<b>${props.name}</b><br />${props.puskesmas} puskesmas` : 'Hover over a regency';
            this._div.innerHTML = `<h4>Jumlah Puskesmas Kab/Kota Maluku</h4>${contents}`;
        };

        info.addTo(map);

        function getColor(d) {
    return d > 30000 ? '#800026' :  // Lebih dari 30.000
           d > 25000 ? '#BD0026' :  // 25.001 - 30.000
           d > 20000 ? '#E31A1C' :  // 20.001 - 25.000
           d > 18000 ? '#FC4E2A' :  // 18.001 - 20.000
           d > 15000 ? '#FD8D3C' :  // 15.001 - 18.000
           d > 12000 ? '#FEB24C' :  // 12.001 - 15.000
                         '#FFEDA0';  // 12.000 ke bawah
}

        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.puskesmas)
            };
        }

        function highlightFeature(e) {
            const layer = e.target;

            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            layer.bringToFront();

            info.update(layer.feature.properties);
        }

        const regencies = @json($regencies);

        const regencyData = regencies.map(regency => ({
            type: "Feature",
            properties: {
                name: regency.name,
                id: regency.id,
                puskesmas: regency.puskesmas,
            },
            geometry: {
                type: regency.type_polygon,
                coordinates: JSON.parse(regency.polygon),
            }
        }));

        const geoJson = {
            type: "FeatureCollection",
            features: regencyData,
        };

        var geojson = L.geoJson(geoJson, {
            style: style,
            onEachFeature: function (feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }
        }).addTo(map);

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }


        const legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {

            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 12000, 15000, 18000, 20000, 25000, 30000];
            const labels = [];
            let from, to;

            for (let i = 0; i < grades.length; i++) {
                from = grades[i];
                to = grades[i + 1];

                labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
            }

            div.innerHTML = labels.join('<br>');
            return div;
        };

        legend.addTo(map);
    </script>

    <script>
        document.getElementById('info-icon').addEventListener('click', function() {
            document.getElementById('info-popup').style.display = 'block';
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('info-popup').style.display = 'none';
        });

        const infoIcon = document.getElementById('info-icon');
        const infoPopup = document.getElementById('info-popup');
        const infoOverlay = document.getElementById('info-overlay');
        const closePopupButton = document.getElementById('close-popup');

        // Menampilkan pop-up dan overlay saat ikon diklik
        infoIcon.addEventListener('click', function () {
            infoPopup.style.display = 'block';
            infoOverlay.style.display = 'block';
        });

        // Menyembunyikan pop-up dan overlay saat tombol tutup diklik
        closePopupButton.addEventListener('click', function () {
            hidePopup();
        });

        // Menyembunyikan pop-up dan overlay saat area luar pop-up diklik
        infoOverlay.addEventListener('click', function () {
            hidePopup();
        });

        // Fungsi untuk menyembunyikan pop-up dan overlay
        function hidePopup() {
            infoPopup.style.display = 'none';
            infoOverlay.style.display = 'none';
        }
    </script>
</body>

</html>
