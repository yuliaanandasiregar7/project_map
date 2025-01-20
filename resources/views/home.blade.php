@extends('index')
@section('content')
<div id="map"></div>

<script>
    var map = L.map('map').setView([-3.118840, 129.420780], 7.4);
    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> | <a href="https://sulsel.bps.go.id/id/statistics-table/2/ODMjMg==/jumlah-penduduk-menurut-kabupaten-kota" target="_blank">BPS Sulawesi Selatan</a>'
    }).addTo(map);

    var home = @json($regency);

    home.forEach(function(location){
        var marker = L.marker([location.latitude, location.longitude]).addTo(map);
        marker.bindPopup(`<b>`+location.name+`</b><br>`+location.population+` orang`);
    });

</script>

@endsection