<?php include "header.php"; ?>
<?php
$id = $_GET['id_wisata'];
include_once "ambildata_id.php";
$obj = json_decode($data);
$id_wisata = "";
$nama_wisata = "";
$alamat = "";
$deskripsi = "";
$harga_tiket = "";
$lat = "";
$long = "";
foreach ($obj->results as $item) {
  $id_wisata .= $item->id_wisata;
  $nama_wisata .= $item->nama_wisata;
  $alamat .= $item->alamat;
  $deskripsi .= $item->deskripsi;
  $harga_tiket .= $item->harga_tiket;
  $lat .= $item->latitude;
  $long .= $item->longitude;
}

$title = "Detail dan Lokasi : " . $nama_wisata;
//include_once "header.php"; 
?>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript"
  src="https://maps.google.com/maps/api/js?key=AIzaSyAAgY3Vew0LpTLCBR_Sg98TKXrW_8Yk_4o&libraries=geometry"></script>

<script type="text/javascript">

  var map; // Membuat variabel map menjadi variabel global

  function initialize() {
    var myLatlng = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
    var mapOptions = {
      zoom: 13,
      center: myLatlng
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var contentString = '<div id="content">' +
      '<div id="siteNotice">' +
      '</div>' +
      '<h1 id="firstHeading" class="firstHeading"><?php echo $nama_wisata ?></h1>' +
      '<div id="bodyContent">' +
      '<p><?php echo $alamat ?></p>' +
      '</div>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });

    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Maps Info',
      icon: 'img/markermap.png'
    });
    google.maps.event.addListener(marker, 'click', function () {
      infowindow.open(map, marker);
    });
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        calculateAndDisplayRoute(position);
      });
    } else {
      console.log("Geolocation is not supported by this browser.");
    }
  }

  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;

  function calculateAndDisplayRoute(position) {
    // Menambahkan arah ke dalam peta
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directions-panel'));

    var asal = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var tujuan = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);

    directionsService.route({
      origin: asal,
      destination: tujuan,
      travelMode: 'DRIVING'
    }, function (response, status) {
      if (status === 'OK') {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });

    // Menampilkan modal
    $('#myModal3').modal('show');
  }

  $('#directionModal').on('click', function () {
    $('#myModal3').modal({ show: true });
  });


  jQuery(document).on('click', '#akhir', function (event) {
    calculateAndDisplayRoute({ coords: { latitude: posisi.lat(), longitude: posisi.lng() } });
    // infoWindow.close(); // Tidak terdapat infoWindow dalam kode yang diberikan
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Add event listener after the DOM is loaded
    document.getElementById('getLocation').addEventListener('click', function () {
      getLocation();
    });

    google.maps.event.addDomListener(window, 'load', initialize);
  });

</script>

<!-- start banner Area -->
<section class="about-banner relative">
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          Detail Informasi Geografis Wisata
        </h1>

      </div>
    </div>
  </div>
</section>
<!-- End banner Area -->
<!-- Start about-info Area -->
<section class="about-info-area section-gap">
  <div class="container" style="padding-top: 120px;">
    <div class="row">

      <div class="col-md-7" data-aos="fade-up" data-aos-delay="200">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <h2 class="panel-title"><strong>Informasi Wisata </strong></h4>
          </div>
          <div class="panel-body">
            <table class="table">
              <tr>
                <!-- <th>Item</th> -->
                <th>Detail</th>
              </tr>
              <tr>
                <td>Nama Wisata</td>
                <td>
                  <h5>
                    <?php echo $nama_wisata ?>
                  </h5>
                </td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>
                  <h5>
                    <?php echo $alamat ?>
                  </h5>
                </td>
              </tr>
              <tr>
                <td>Deskripsi</td>
                <td>
                  <button class="btn btn-primary text-uppercase" id="seePict" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Lihat Foto</button>
                  <!-- <h5>
                    <?php echo $deskripsi ?>
                  </h5> -->
                </td>
              </tr>
              <tr>
                <td>Harga Tiket</td>
                <td>
                  <button class="btn btn-primary text-uppercase" id="seeMenu" data-bs-toggle="modal"
                    data-bs-target="#exampleModal2">Lihat Menu</button>
                  <!-- <h5>Rp.
                    <?php echo $harga_tiket ?>
                  </h5> -->
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-5" data-aos="zoom-in">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <h2 class="panel-title"><strong>Lokasi</strong></h4>
          </div>
          <div class="panel-body">
            <div id="map-canvas" style="width:100%;height:380px;"></div>
          </div>
          <div class="text-center mt-5">
            <button class="primary-btn text-uppercase" id="getLocation" data-bs-toggle="modal"
              data-bs-target="#myModal13">SHOW DIRECTION</button>
          </div>
        </div>
      </div>
</section>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Rute</h4>
      </div>
      <div class="modal-body" id="directions-panel">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<section>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto Suasana</h5>
        </div>
        <div class="modal-body">
          <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="assets/img/cta-bg.jpg" class="d-block w-100" alt="Foto 1">
              </div>
              <div class="carousel-item">
                <img src="assets/img/cta-bg2.jpg" class="d-block w-100" alt="Foto 2">
              </div>
              <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="Foto 3">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Foto Menu</h5>
      </div>
      <div class="modal-body">
        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
          data-bs-interval="false">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="..." class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- End about-info Area -->
<?php include "footer.php"; ?>