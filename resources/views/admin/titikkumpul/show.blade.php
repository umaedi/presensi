@extends('layouts.main')
@section('content')
<style>
    #map { height: 350px; }
</style>
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="updateOpd">
        @csrf
        @method('PUT')
        <div class="row mb-4">
            <!-- Basic Alerts -->
            <div class="col-md mb-4 mb-md-0">
                <div class="card mb-3">
                <span id="notif"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lokasi" class="form-label">Nama Titik Kumpul</label>
                            <input
                              name="nama_lokasi"
                              type="text"
                              id="nama_lokasi"
                              class="form-control"
                              value="{{ $titiklokasi->nama_lokasi }}"
                            />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="lat" class="form-label">Lat</label>
                            <input
                              name="lat"
                              type="text"
                              id="lat"
                              class="form-control latitude"
                              value="{{ $titiklokasi->lat }}"
                            />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="long" class="form-label">Long</label>
                            <input
                              name="long"
                              type="text"
                              id="long"
                              class="form-control longitude"
                              value="{{ $titiklokasi->long }}"
                            />
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts._button')
            <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
        </form>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="text" class="form-label">Cari Lokasi</label>
                        <input
                          type="text"
                          id="start-search"
                          class="form-control"
                        />
                    </div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
         <!-- Modal -->
    <div class="modal fade" id="opratorModal" tabindex="-1" aria-hidden="true">
        <form id="storeOprator">
          @csrf
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="opratorModalTitle">Tambah OPD</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
            <span id="notif"></span>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Nama</label>
                <input
                  name="nama"
                  type="text"
                  id="name"
                  class="form-control"
                  placeholder="Masukan nama lengkap"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">NIP</label>
                <input
                  name="nip"
                  type="text"
                  id="nip"
                  class="form-control"
                  placeholder="Masukan NIP"
                />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Jabatan</label>
                <input
                  name="jabatan"
                  type="text"
                  id="jabatan"
                  class="form-control"
                  placeholder="Masukan Jabatan"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Organisasi</label>
                <input
                  name="organisasi"
                  type="text"
                  id="organisasi"
                  class="form-control"
                  placeholder="Masukan organisasi"
                />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Unit Organisasi</label>
                <input
                  name="unit_organisasi"
                  type="text"
                  id="unit_organisasi"
                  class="form-control"
                  placeholder="Masukan unit organisasi"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">No Tlp/WhatsApp</label>
                <input
                  name="no_hp"
                  type="text"
                  id="no_hp"
                  class="form-control"
                  placeholder="Masukan no tlp"
                />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  name="email"
                  type="email"
                  id="email"
                  class="form-control"
                  placeholder="Masukan email"
                />
              </div>
              <div class="col mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                  name="password"
                  type="text"
                  id="password"
                  class="form-control"
                  placeholder="Masukan password"
                />
              </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Tutup
                </button>
                @include('layouts._button')
                <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    <div class="content-backdrop fade"></div>
  </div>
@endsection
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdrcR4AiS_NF-9lL3I0_wBqZ8VroWpA50&libraries=places"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        initialize();
    });
    function initialize() {

    let mapOptions, map, marker, searchBox, city,
        infoWindow = '',
        addressEl = document.querySelector('#start-search'),
        latEl = document.querySelector('.latitude'),
        longEl = document.querySelector('.longitude'),
        element = document.getElementById('map');

    mapOptions = {
        // How far the maps zooms in.
        zoom: 8,
        // Current Lat and Long position of the pin/
        center: new google.maps.LatLng(-4.4966928, 105.1585917),
        // center : {
        // 	lat: -34.397,
        // 	lng: 150.644
        // },
        disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
        scrollWheel: true, // If set to false disables the scrolling on the map.
        draggable: true, // If set to false , you cannot move the map around.
        // mapTypeId: google.maps.MapTypeId.HYBRID, // If set to HYBRID its between sat and ROADMAP, Can be set to SATELLITE as well.
        // maxZoom: 11, // Wont allow you to zoom more than this
        // minZoom: 9  // Wont allow you to go more up.

    };

    /**
     * Creates the map using google function google.maps.Map() by passing the id of canvas and
     * mapOptions object that we just created above as its parameters.
     *
     */
    // Create an object map with the constructor function Map()
    map = new google.maps.Map(element, mapOptions); // Till this like of code it loads up the map.

    /**
     * Creates the marker on the map
     *
     */
    marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        // icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
        draggable: true
    });

    /**
     * Creates a search box
     */
    searchBox = new google.maps.places.SearchBox(addressEl);

    /**
     * When the place is changed on search box, it takes the marker to the searched location.
     */
    google.maps.event.addListener(searchBox, 'places_changed', function () {
        let places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i, place, lat, long, resultArray,
            addresss = places[0].formatted_address;

        for (i = 0; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);  // Set marker position new.
        }

        map.fitBounds(bounds);  // Fit to the bound
        map.setZoom(15); // This function sets the zoom to 15, meaning zooms to level 15.
        // console.log( map.getZoom() );

        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        latEl.value = lat;
        longEl.value = long;

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ latLng: marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                if (results[0]) {
                    var address = results[0].formatted_address;
                    var pin =
                        results[0].address_components[
                            results[0].address_components.length - 1
                        ].long_name;
                }
                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }

            // Closes the previous info window if it already exists
            if (infoWindow) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open(map, marker);
        });
    });


    /**
     * Finds the new position of the marker when the marker is dragged.
     */
    google.maps.event.addListener(marker, "dragend", function (event) {
        let lat, long, address, resultArray, citi;

        console.log('i am dragged');
        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ latLng: marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                if (results[0]) {
                    var address = results[0].formatted_address;
                    var pin =
                        results[0].address_components[
                            results[0].address_components.length - 1
                        ].long_name;
                }
                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }

            // Closes the previous info window if it already exists
            if (infoWindow) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open(map, marker);
        });
    });
    }

    $('#updateOpd').on('submit', async function store(e) {
        e.preventDefault();

        var form 	= $(this)[0]; 
        var data 	= new FormData(form);
        var param = {
        url: '/admin/titik_kumpul/update/{{ $titiklokasi->id }}',
        method: 'POST',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        }

        action(true);
        await transAjax(param).then((result) => {
        action(false);
        $('#notif').html(`<div class="alert alert-success">${result.message}</div>`);
        loadTable();
        }).catch((err) => {
        action(false);
        console.log(err);
        $('#notif').html(`<div class="alert alert-warning">${err.responseJSON.message}</div>`);
        });
    });

    function action(state)
    {
        if(state) {
            $('#btn_loading').removeClass('d-none');
            $('#btn_submit').addClass('d-none');
        } else {
            $('#btn_loading').addClass('d-none');
            $('#btn_submit').removeClass('d-none');
        }
    }
</script>
@endpush

