var berlin = new google.maps.LatLng(13.681099, -89.235701);
var newMarker;

/*var neighborhoods = [
    new google.maps.LatLng(52.511467, 13.447179),
    new google.maps.LatLng(52.549061, 13.422975),
    new google.maps.LatLng(52.497622, 13.396110),
    new google.maps.LatLng(52.517683, 13.394393)
];*/

var markers = [];
var iterator = 0;
var correl = 0;
var mensajes = new Array('mensaje 1', 'mensaje 2', 'mensaje 3', 'mensaje 4');
var map;

function initialize() {
    var mapOptions = {
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: berlin
    };

    map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
    google.maps.event.addListener(map, 'click', function (event) {
        placeMarker(event.latLng);
    });
}

function initialize_modificar() {
    var mapOptions = {
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: berlin
    };

    map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
    google.maps.event.addListener(map, 'click', function (event) {
        placeMarker(event.latLng);
    });
}

function drop() {
    for (var i = 0; i < neighborhoods.length; i++) {
        setTimeout(function() {
            addMarker();
        }, (i + 1) * 600);
    }
}

function drop_modificar() {
    for (var i = 0; i < neighborhoods.length; i++) {
        setTimeout(function() {
            addMarker_modificar();
        }, (i + 1) * 600);
    }
}

function addMarker_modificar() {
    newMarker = new google.maps.Marker({
      position: neighborhoods[iterator],
      map: map,
      animation: google.maps.Animation.DROP
    });
}

function addMarker() {
    markers.push(new google.maps.Marker({
        position: neighborhoods[iterator],
        map: map,
        draggable: false,
        animation: google.maps.Animation.DROP
    }));
    google.maps.event.addListener(markers[iterator], 'click', function(correl) {
        alertaClic(correl);
        correl++;
    });
    iterator++;
}

function alertaClic(correlativo) {
    alert('probando marker ' + mensajes[correlativo]);
}

google.maps.event.addDomListener(window, 'load', initialize);

//setTimeout(drop(), 1000);

function placeMarker(location) {
  if ( newMarker ) {
    newMarker.setPosition(location);
  } else {
    newMarker = new google.maps.Marker({
      position: location,
      map: map
    });
  }
  $('#coordX').val(newMarker.position.jb);
  $('#coordY').val(newMarker.position.kb);
}