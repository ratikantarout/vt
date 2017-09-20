<style type="text/css">
    .show-dtlmap{
        color: #ff0000;
        font-size: 25px;
        cursor: pointer;
        float: left;
    }
    .show-dtlmap:hover,
    .show-dtlmap:active,
    .show-dtlmap:focus{
        text-decoration: none;
        color: #ff0000;
    }
    .spot-name{
        padding-top: 5px;
    }
    .padd-lf-rt{
        padding: 0 !important;
    }
    .address-box{
        margin-bottom:0;
        padding-left: 8px;
    }
    .indicator-anchor {
        background-color: white;
        border-bottom: 1px solid #ccc;
        border-right: 1px solid #ccc;
        bottom: -8px;
        height: 16px;
        left: 54px;
        position: absolute;
        transform: rotate(45deg);
        width: 16px;
    }
    a + .location-box {
        background:#fff;
        border: 1px solid #cfcfcf;
        border-radius: 16px;
        box-shadow: 2px 2px 2px #cfcfcf;
        float: left;
        left: -74px;
        padding: 10px;
        position: relative;
        top: -118px;
        width: 280px;
    }
    .road-icon-par {
        border: 1px solid #ccc;
        border-radius: 12px;
        height: 25px;
        margin: 0 5px 0 0;
        text-align: center;
        width: 25px;
    }

    #map {
        height: 300px;
    }
    a[href^="http://maps.google.com/maps"]{
        display:none !important
    }
    a[href^="https://maps.google.com/maps"]{
        display:none !important
    }
    .gmnoprint a, .gmnoprint span, .gm-style-cc {
        display:none;
    }
    .gmnoprint div {
        background:none !important;
    }
    .map-inner{
        bottom: 0;
        height: 58px;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
    }
    .map-outer{
        height: 80px;background-color: #fff;border-radius: 10px;
        max-width: 300px;
        width: auto;
        min-width: 168px;
        padding: 0;
    }

</style>
<div id="map" onload="initMap();" ></div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASRzaH0ATAsuLEFiRCwXN__oUKWgdMDto&callback=initMap">
</script>
<script type="text/javascript">
    $(document).ready(function () {
        initMap();
    });

    window.initMap = function(){
        var results = JSON.parse('{$nearplaces|@json_encode|replace :"'":"&#039;" }');
        var currlat = {$product->width};
        var currlng = {$product->height};
        var customIcons = {
            nearplaces: {
                icon: 'http://www.visitortrip.com/img/map/mapmaker-icon-blue.png'
            }
        };
        var myLatLng = {
            lat: currlat,
            lng: currlng
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: myLatLng,
            scrollwheel: false
        });
        var infoWindow = new google.maps.InfoWindow;
        var html = "<div class='location-box'>\n\
              <div class='col-lg-4 padd-lf-rt'>\n\
              <img src='http://www.visitortrip.com/{$image_c}-cart_default/{$product->link_rewrite}.jpg' height='60' width='60' class='img-responsive'>\n\
              </div>\n\
              <div class='col-lg-8 padd-lf-rt'>\n\
              <p class='address-box caption'>{$product->reference},{$product->ean13}<br>India</p>\n\
              </div>\n\
              <div class='col-lg-12 spot-name'><b>{$product->name|replace :"'":"&#039;"}</b></div>\n\
              <div class='indicator-anchor'>\n\
              </div>\n\
              </div>";

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '{$product->name|replace :"'":"&#039;"}'
        });
        bindInfoWindow(marker, map, infoWindow, html);
        $.each(results, function (index, value) {
            var type = 'nearplaces';
            var point = new google.maps.LatLng(value['lat'], value['lng']);
            var html = "<div class='location-box'>\n\
              <div class='col-lg-4 padd-lf-rt'>\n\
              <img src='http://www.visitortrip.com/" + value['id_image'] + "-cart_default/" + value['link_rewrite'] + ".jpg' style='width:100%;' class='img-responsive'>\n\
              </div>\n\
              <div class='col-lg-8 padd-lf-rt'>\n\
              <p class='address-box caption'>" + value['reference'] + "," + value['ean13'] + "<br>India</p>\n\
              <p class='address-box'>\n\
              <span class='spot-distance'>\n\
              <label class='road-icon-par'>\n\
              <i class='glyphicon glyphicon-road bk-raod'></i>\n\
              </label>" + value['distance'] + " KM </span></p>\n\
              </div>\n\
              <a href='http://www.visitortrip.com?controller=product&id_product=" + value['id_product'] + "'>\n\
<div class='col-lg-12 spot-name'><b>" + value['name'] + "</b></div></a>\n\
              <div class='indicator-anchor'>\n\
              </div>\n\
              </div>";
            var icon = customIcons[type] || {
            };
            var kstring=value['name'];
            var kstring=kstring.replace("'","&#039;")
            var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon.icon,
                shadow: icon.shadow,
                title: kstring
            });
            kstring='';
            bindInfoWindow(marker, map, infoWindow, html);
        });
    }
    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }
</script>