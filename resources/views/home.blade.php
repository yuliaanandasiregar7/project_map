@extends('index')
@section('content')

    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">PROVINSI MALUKU</h2>
                <div></div>
            </div>



                    <div class="timeline-panel">
                        <div class="timeline-body">
                            <p class="text-muted">Kepulauan Maluku adalah kepulauan di bagian timur Indonesia. 
                                Secara tektonik terletak di Lempeng Halmahera di dalam Zona Tabrakan Laut Maluku. 
                                Secara geografis terletak di sebelah timur Sulawesi, sebelah barat Papua, serta sebelah utara dan timur Timor. 
                                Terletak di dalam Wallacea (sebagian besar di sebelah timur biogeografis Garis Weber), 
                                Kepulauan Maluku dianggap sebagai persimpangan geografis dan budaya antara Asia dan Oseania.
                                Jumlah penduduk Provinsi Maluku pada tahun 2020 sebanyak 1.848.923 jiwa dan Provinsi Maluku Utara sebanyak 1.282.937 jiwa. 
                                Jadi jumlah penduduk Kepulauan Maluku secara wilayah pada tahun 2020 adalah 3.131.860 jiwa.
                            </p>
                           
                    </div>
                    </div>
                
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

                    <p class="text-muted">
                        Kepulauan Maluku membentuk satu provinsi sejak kemerdekaan Indonesia hingga tahun 1999, ketika kepulauan tersebut dipecah menjadi dua provinsi. 
                        Provinsi baru, Maluku Utara, mencakup wilayah antara Morotai dan Sula, dengan gugusan pulau dari Buru dan Seram hingga Wetar masih tersisa di Provinsi Maluku. 
                        Maluku Utara mayoritas beragama Islam, dan ibu kotanya adalah Sofifi di pulau Halmahera. Provinsi Maluku memiliki populasi Kristen yang lebih besar, dan ibukotanya adalah Ambon. 
                        Meskipun aslinya Melanesia,banyak penduduk pulau, terutama di Kepulauan Banda, dibantai pada abad ke-17 selama Perang Belanda-Portugal, yang juga dikenal sebagai Perang Rempah-rempah. 
                        Masuknya imigran kedua terutama dari Jawa dimulai pada awal abad ke-20 di bawah pemerintahan Belanda dan berlanjut hingga era Indonesia, yang juga menimbulkan banyak kontroversi karena 
                        program Transmigran dianggap sebagai faktor penyebab Kerusuhan Maluku.
                    </p>

<footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; Project2 SIG</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="https://www.instagram.com/yuliaanandasiregar/" aria-label="Twitter"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/yulia.ananda.5015" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

@endsection