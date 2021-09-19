<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نقشه</title>
    <link rel="stylesheet" href="{{ asset('css/site/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body dir="rtl">
    {{--MODAL--}}
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close float-left bg-red bold" onclick="closeModal()">&times;</button>
                <h4 class="modal-title center">افزودن مکان به نقشه</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">
                                نام مکان:
                            </label>
                            <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="type">
                                نوع مکان:
                            </label>
                            <select name="type" id="type" class="form-control">
                                @foreach($categories as $categoty)
                                    <option value="{{ $categoty->id }}">
                                        {{ $categoty->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="closeModal()">بستن</button>
                <button type="button" class="btn btn-success float-left" onclick="submitLocation()">ثبت مکان</button>
            </div>

        </div>
    </div>
</div>
    <div class="map-container">
        <div id="map"></div>
    </div>
    <div class="location">
        <i class="fa fa-map-marker currentLoc"></i>
    </div>

    {{--<div class="location">
        <i class="fa fa-map-marker"></i>
    </div>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" integrity="sha512-eYSzo+20ajZMRsjxB6L7eyqo5kuXuS2+wEbbOkpaur+sA2shQameiJiWEzCIDwJqaB0a4a6tCuEvCOBHUg3Skg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: DEFAULT_MAX_ZOOM,
            attribution: '&copy; Amir Anbari',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(MAP);

        @foreach($locations as $location)
        L.marker([{{ $location->lat }}, {{ $location->lng }}]).addTo(MAP)
            .bindPopup("{{ $location->title }}").openPopup();


        /*var popupLocation1 = new L.LatLng({{ $location->lat }}, {{ $location->lng }});
        popup1 = new L.Popup();
        popup1.setLatLng(popupLocation1);
        popup1.setContent("{{ $location->title }}");
        (new L.Popup()).setLatLng(popupLocation1);
        MAP.addLayer(popup1);*/



        @endforeach


        MAP.on('dblclick', mapOnClick);

        /*function onLocationFound(e) {
            console.log("here");
            var radius = e.accuracy / 2;

            L.marker(e.latlng).addTo(MAP)
                .bindPopup("You are within " + radius + " meters from this point").openPopup();

            L.circle(e.latlng, radius).addTo(MAP);
        }*/

        MAP.on('locationfound', onLocationFound);
        MAP.on('locationerror', onLocationError);

        // MAP.locate({setView: true, maxZoom: 16});

    </script>
</body>
</html>
