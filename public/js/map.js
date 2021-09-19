const DEFAULT_TITLE         = 'آدرس انتخابی';
const DEFAULT_ZOOM          = 16;
const DEFAULT_MAX_ZOOM      = 18;
const DEFAULT_LOCATION      = [36.2019552, 57.7012596];
var   UserMark              = null;
var   MAP                   = null;
var   UserSelectedLocation  = null;
var   UserCurrentLocation   = [];

MAP = L.map('map').setView(DEFAULT_LOCATION, DEFAULT_ZOOM);

function closeModal(){
    $('#myModal').modal('hide');
}


function mapOnClick(e) {
    UserSelectedLocation = e.latlng;
    UserMark = L.marker(e.latlng).addTo(MAP);
    $("#myModal").modal();
}


$('#myModal').on('hide.bs.modal', function (e) {
    MAP.removeLayer(UserMark);
    UserSelectedLocation = null;
});

$('.location').on('click', function (e) {
    findLocation(e);
});


function submitLocation() {
    let title = $('#title');
    fetch('/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            title   : title.val(),
            category: $('#type').val(),
            latlng  : UserSelectedLocation
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data['status'] == 200){
                toastr.success('پس از تایید در نقشه نمایش داده خواهد شد', 'لوکیشن با موفقیت ثبت شد', {timeOut: 6000});
                L.marker(UserSelectedLocation).addTo(MAP)
                    .bindPopup(title.val()).openPopup();
                $('#myModal').modal('hide');
            }
        })
        .catch(errors => {
            console.log(errors)
        });
}

/*function findLocation(e) {
    MAP.locate({setView: true, maxZoom: 16});

    var radius = e.accuracy / 2;

    L.marker(e.latlng).addTo(MAP)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(MAP);
}*/

// $('.location').on('click',findLocation);


function findLocation() {
    $.blockUI({
        message: `درحال دریافت لوکیشن ... <i class="fa fa-spinner fa-spin"></i>`,
        fadeIn: 700,
        fadeOut: 700,
        showOverlay: true,
        centerY: false,
        css: {
            width: '350px',
            border: 'none',
            padding: '5px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .6,
            color: '#fff'
        }
    });
    MAP.locate({setView: true, maxZoom: 16});
}

function onLocationFound(e) {

    if (UserCurrentLocation.length > 0){
        UserCurrentLocation.forEach(element => {
            MAP.removeLayer(element);
        });
        UserCurrentLocation = [];
    }

    let accuracy = e.accuracy / 2;
    let marker   = L.marker(e.latlng).addTo(MAP);
    UserCurrentLocation.push(marker);
    UserCurrentLocation.push(L.circle(e.latlng, accuracy).addTo(MAP));
    UserCurrentLocation.push(marker.bindPopup("مکان شما").openPopup());

    setTimeout(function () {
        $.unblockUI();
    }, 500);

}

function onLocationError(e) {
    $.unblockUI();
    if (e.code == 1){
        return toastr.warning("مجوز برای دریافت لوکیشن داده نشد.");
    }
    toastr.warning("دریافت لوکیشن با مشکل مواجه شد");
}




