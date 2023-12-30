<?php include "header.php"; ?>

<!-- start banner Area -->
<section class="banner-area relative">
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row fullscreen align-items-center justify-content-between">
      <div class="col-lg-6 col-md-6 banner-left">
        <h4 class="text-white">CAFE & WORKSPACE</h4>
        <h1 class="text-white">DENPASAR</h1>
        <p class="text-white1">
          Sistem informasi ini merupakan aplikasi pemetaan geografis cafe dan workspace yang ada di Denpasar. Aplikasi
          ini
          memuat informasi dan lokasi dari tempat wisata di Banyumas.
        </p>
        <a href="#peta_wisata" class="primary-btn text-uppercase">Lihat Detail</a>
      </div>

    </div>
  </div>
  </div>
</section>
<!-- End banner Area -->


<main id="main">




  <!-- Start about-info Area -->
  <section class="price-area section-gap">

    <section id="peta_wisata" class="about-info-area section-gap">
      <div class="container">

        <div class="title text-center">
          <h1 class="mb-10">Peta Lokasi Wisata</h1>
          <br>
        </div>

        <div class="row align-items-center">
          <div id="map" style="width:100%;height:480px;"></div>
        </div>

        <div class="text-center mt-5">
          <button class="primary-btn text-uppercase" id="getLocation">GO TO MY LOCATION</button>
        </div>


      </div>
    </section>
    <!-- End about-info Area -->


    <!-- Start price Area -->

    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-70 col-lg-8">
          <div class="title text-center">
            <h1 class="mb-10">Jangkauan Peta</h1>
            <p>Aplikasi pemetaan geografis Cafe dan Workspace di Denpasar ini memuat informasi dan lokasi Cafe dan
              Workspace di Denpasar. Pemetaan diambil dari data lokasi Google Maps dan data dari masing-masing Cafe dan
              Workspace. Aplikasi ini memuat sejumlah informasi mengenai :
            </p>
          </div>
        </div>
      </div>

      <!-- End other-issue Area -->

    </div>
    </div> <!-- ======= Counts Section ======= -->
    <section id="counts">
      <div class="container">
        <div class="title text-center">
          <h1 class="mb-10">Jumlah Tempat Wisata</h1>
          <br>
        </div>
        <div class="row d-flex justify-content-center">


          <?php
          include_once "countsma.php";
          $obj = json_decode($data);
          $sman = "";
          foreach ($obj->results as $item) {
            $sman .= $item->sma;
          }
          ?>

          <div class="text-center">
            <h1><span data-toggle="counter-up">
                <?php echo $sman; ?>
              </span></h1>
            <br>
          </div>
          <?php
          include_once "countsmk.php";
          $obj2 = json_decode($data);
          $smkn = "";
          foreach ($obj2->results as $item2) {
            $smkn .= $item2->smk;
          }
          ?>


        </div>

      </div>
    </section><!-- End Counts Section -->
    </div>
  </section>
  <!-- End testimonial Area -->

  <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key=AIzaSyAAgY3Vew0LpTLCBR_Sg98TKXrW_8Yk_4o&libraries=geometry"></script>
  <script type='text/javascript'>

    var map; // Definisikan variabel global untuk menyimpan objek peta

    function initialize() {
      var mapOptions = {
        zoom: 12,
        center: new google.maps.LatLng(-8.6726833, 115.2242733),
        disableDefaultUI: false
      };

      var mapElement = document.getElementById('map');

      map = new google.maps.Map(mapElement, mapOptions);

      setMarkers(map, officeLocations)
    }

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
          showPosition(position, map);
        });
      } else {
        console.log("Geolocation is not supported by this browser.");
      }
    }

    function showPosition(position, map) {
      var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

      // Tambahkan marker untuk posisi pengguna
      var userMarker = new google.maps.Marker({
        position: userLatLng,
        map: map,
        title: 'Posisi Anda',
        icon: 'img/markermap.png' // Ganti dengan path gambar marker pengguna
      });

      // Tambahkan info window untuk marker pengguna
      var userInfoWindow = new google.maps.InfoWindow({
        content: 'Posisi Anda'
      });

      google.maps.event.addListener(userMarker, 'click', function () {
        userInfoWindow.open(map, userMarker);
      });

      // Tambahkan lingkaran radius di sekitar marker pengguna
      var circle = new google.maps.Circle({
        map: map,
        radius: 3000, // Radius dalam meter
        strokeColor: "#1E90FF",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#1E90FF",
        fillOpacity: 0.35,
        center: userLatLng
      });

      // Pusatkan peta ke posisi pengguna
      map.setCenter(userLatLng);
    }

    var officeLocations = [
      <?php
      $data = file_get_contents('http://localhost/SIG-WISATA/ambildata.php');
      $no = 1;
      if (json_decode($data, true)) {
        $obj = json_decode($data);
        foreach ($obj->results as $item) {
          ?>[<?php echo $item->id_wisata ?>, '<?php echo $item->nama_wisata ?>', '<?php echo $item->alamat ?>', <?php echo $item->longitude ?>, <?php echo $item->latitude ?>],
          <?php
        }
      }
      ?>
    ];

    function setMarkers(map, locations) {
      var globalPin = 'img/marker.png';

      for (var i = 0; i < locations.length; i++) {

        var office = locations[i];
        var myLatLng = new google.maps.LatLng(office[4], office[3]);
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var contentString =
          '<div id="content">' +
          '<div id="siteNotice">' +
          '</div>' +
          '<h5 id="firstHeading" class="firstHeading">' + office[1] + '</h5>' +
          '<div id="bodyContent">' +
          '<a href=detail.php?id_wisata=' + office[0] + '>Info Detail</a>' +
          '</div>' +
          '</div>';

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: office[1],
          icon: 'img/markermap.png'
        });

        google.maps.event.addListener(marker, 'click', getInfoCallback(map, contentString));
      }
    }

    function getInfoCallback(map, content) {
      var infowindow = new google.maps.InfoWindow({
        content: content
      });
      return function () {
        infowindow.setContent(content);
        infowindow.open(map, this);
      };
    }

    document.getElementById('getLocation').addEventListener('click', function () {
      getLocation()
    })

    initialize();
  </script>


  <?php include "footer.php"; ?>