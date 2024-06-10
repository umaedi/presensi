@extends('layouts.main')
@section('content')
    <style>
        #map {
            height: 350px;
        }
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
                                        <label for="nama_sub_opd" class="form-label">Nama Sub OPD</label>
                                        <input name="nama_sub_opd" type="text" id="nama_sub_opd" class="form-control"
                                            value="{{ $subopd->nama_sub_opd }}" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="opd_id" class="form-label">Nama OPD</label>
                                        <select name="opd_id" id="opd_id" class="form-control">
                                            @foreach ($opd as $op)
                                            <option value="{{ $op->id }}" {{ $op->id == $subopd->opd->id ? 'selected' : '' }}>{{ $op->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lat" class="form-label">Lat</label>
                                        <input name="lat" type="text" id="lat" class="form-control latitude"
                                            value="{{ $subopd->lat }}" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="long" class="form-label">Long</label>
                                        <input name="long" type="text" id="long" class="form-control longitude"
                                            value="{{ $subopd->long }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('layouts._button')
                        <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
                        {{-- <a href="/admin/subopd/delete/{{ $subopd->id }}" onclick="return confirm('Hapus data ini!')" class="btn btn-danger">Hapus</a> --}}
                    </form>
                    <button class="btn btn-danger" type="button" id="btnHapus">Hapus</button>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="text" class="form-label">Cari Lokasi</label>
                        <input type="text" id="start-search" class="form-control" />
                    </div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdrcR4AiS_NF-9lL3I0_wBqZ8VroWpA50&libraries=places">
    </script>
    <script src="{{ asset('assets/pegawai') }}/js/sweetalert.min.js"></script>
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
            google.maps.event.addListener(searchBox, 'places_changed', function() {
                let places = searchBox.getPlaces(),
                    bounds = new google.maps.LatLngBounds(),
                    i, place, lat, long, resultArray,
                    addresss = places[0].formatted_address;

                for (i = 0; place = places[i]; i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location); // Set marker position new.
                }

                map.fitBounds(bounds); // Fit to the bound
                map.setZoom(15); // This function sets the zoom to 15, meaning zooms to level 15.
                // console.log( map.getZoom() );

                lat = marker.getPosition().lat();
                long = marker.getPosition().lng();
                latEl.value = lat;
                longEl.value = long;

                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    latLng: marker.getPosition()
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus
                        .OK) { // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
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
            google.maps.event.addListener(marker, "dragend", function(event) {
                let lat, long, address, resultArray, citi;

                console.log('i am dragged');
                lat = marker.getPosition().lat();
                long = marker.getPosition().lng();

                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    latLng: marker.getPosition()
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus
                        .OK) { // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
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

            var form = $(this)[0];
            var data = new FormData(form);
            var param = {
                url: '/admin/subopd/update/{{ $subopd->id }}',
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

        function action(state) {
            if (state) {
                $('#btn_loading').removeClass('d-none');
                $('#btn_submit').addClass('d-none');
            } else {
                $('#btn_loading').addClass('d-none');
                $('#btn_submit').removeClass('d-none');
            }
        }

    $('#btnHapus').click(async function() {
        var param = {
            url: "/admin/subopd/delete/{{ $subopd->id }}",
            method: "GET",
        }

        // Pertama, minta konfirmasi penghapusan
        const willDelete = await swal({
            title: "Hapus data ini?",
            text: "Apakah Anda yakin ingin mengapus data ini?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        });

        // Jika user tidak konfirmasi (willDelete adalah null atau false), hentikan eksekusi
        if (!willDelete) {
            return;
        }

        // Jika user mengkonfirmasi, lanjutkan dengan permintaan penghapusan
        await transAjax(param).then((result) => {
            swal("Data berhasil dihapus", {
                icon: "success",
                timer: 3000,
            }).then(() => {
                window.location.href = '/admin/subopd'
            });
        }).catch((err) => {
            alert('Internal Server Error!');
        });
    });

    </script>
@endpush
