 //AGREGANDO VENTANA 

        function initialize() {
            var myLatlng = new google.maps.LatLng(52.520816, 13.410186);
            //var myLatlng = new google.maps.LatLng(13.680794, -89.23574);
            var mapOptions = {
                zoom: 12,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);


            var contentString = '<div id="pop_nombre">Nombre subestacion</div><img src="images/testimage.jpg" />';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 200
            });


            var neighborhoods = [
              new google.maps.LatLng(52.511467, 13.447179),
              new google.maps.LatLng(52.549061, 13.422975),
              new google.maps.LatLng(52.497622, 13.396110),
              new google.maps.LatLng(52.517683, 13.394393)
            ];


            //drop();

            for (var i = 0; i < neighborhoods.length; i++) {
                var marker = new google.maps.Marker({
                    position: neighborhoods[i],
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP
                });
                google.maps.event.addListener(marker, 'click', function () {
                    //infowindow.open(map, marker);
                    alert("alerta");
                });
            }

        }

        /*
        //MAPA BASICO
        var map;
        function initialize() {
            var mapOptions = {
                zoom: 17,
                center: new google.maps.LatLng(13.680794, -89.23574),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
        }*/

        google.maps.event.addDomListener(window, 'load', initialize);

