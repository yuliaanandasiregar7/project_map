@extends('index')

@section('content')
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
            const contents = props ? `<b>${props.name}</b><br />${props.sekolah} sekolah` : 'Hover over a regency';
            this._div.innerHTML = `<h4>Jumlah Sekolah Kab/Kota Maluku</h4>${contents}`;
        };

        info.addTo(map);

        function getColor(d) {
    return d > 700000 ? '#800026' :  // Lebih dari 700.000
           d > 400000 ? '#BD0026' :  // 400.001 - 700.000
           d > 300000 ? '#E31A1C' :  // 300.001 - 400.000
           d > 200000 ? '#FC4E2A' :  // 200.001 - 300.000
           d > 150000 ? '#FD8D3C' :  // 150.001 - 200.000
           d > 100000 ? '#FEB24C' :  // 100.001 - 150.000
                         '#FFEDA0';  // 100.000 ke bawah
}

        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.sekolah)
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
                sekolah: regency.sekolah,
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
            const grades = [0, 100000, 150000, 200000, 300000, 400000, 700000];
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

@endsection