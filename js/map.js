function ViewModel() {
  var self = this;

  //MapModel
  self.maps = ko.observableArray([]);
  self.mapName = ko.observable("oremap");//サイトの名前
  self.mapInfo = ko.observable();
  self.posterName = ko.observable();
  self.positions = ko.observableArray([]);
  self.date = ko.observable();

  //PositionModel
  self.positionName = ko.observable();
  self.positionInfo = ko.observable();
  self.lat = ko.observable();
  self.lng = ko.observable();

  //operation
  self.getMap = function(mapItem) {
    console.log(mapItem);
    self.mapName(mapItem.mapName);
    self.mapInfo(mapItem.mapInfo);
    self.positions(mapItem.positions);
    //GoogleMapに表示
    initMarkers();
    setMarkers(mapItem.positions);
  };

  self.centeringMarker = function(position) {
    var latLng = new google.maps.LatLng(position.lat, position.lng);
    map.setCenter(latLng);
  }

  //function
  var markers = [];

  function initMarkers() {
    if (markers) {
      markers.forEach(function(marker) { marker.setMap(null); } );
    }
    markers = [];
  }

  function setMarkers(positions) {
    positions.forEach(function(position) {
      var latLng = new google.maps.LatLng(position.lat, position.lng);
      var name = new google.maps.InfoWindow({
        content: position.positionName
      });
      var marker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: latLng,
        title: position.positionName
      });
      marker.addListener('click', function() {
        name.open(map, marker);
      });

      marker.setMap(map);
      markers.push(marker);
    });
  }

  self.showMapInfo = function(elem) {
    if (elem.nodeType === 1) {
      console.log(elem);
      $(elem).hide().slideDown("slow", "easeOutQuart");
    }
  }
  self.hideMapInfo = function(elem) {
    if (elem.nodeType === 1) {
      $(elem).slideUp("slow", "easeOutQuart", function() {
        $(elem).remove();
      });
    }
  }


  // load initial data
  $.getJSON("./get.php", function(data) {
    console.log(data);
    self.maps(data);
  })
  .fail(function(e) {
    console.error(e);
  });

}


//mapの設定
var map;
function initMap() {
  var myLatlng = new google.maps.LatLng(35.474135, 139.590182);
  var mapOptions = {
    zoom: 16,
    center: myLatlng,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    rotateControl: false
  }
  map = new google.maps.Map(document.getElementById("map"),
    mapOptions
    );
  //serch method
  var input = /** @type {!HTMLInputElement} */(
      document.getElementById('fixed-header-drawer-exp'));

  var autocomplete = new google.maps.places.Autocomplete(input, { types: ['geocode'] });
  autocomplete.bindTo('bounds', map);
  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
    marker.setPosition(place.geometry.location);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
  });
}

document.getElementById("currentPosition").addEventListener("click", function() {
  showCurrentPosition();
});

function showCurrentPosition() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var currentPosition = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var infoWindow = new google.maps.InfoWindow({map: map});
      infoWindow.setPosition(currentPosition);
      infoWindow.setContent('You are here.');
      map.setCenter(currentPosition);
    }, function() {
      alert("現在地情報の取得に失敗しました。")
    });
  } else {
    // Browser doesn't support Geolocation
      alert("現在地情報を取得できません。\n位置情報機能がオフになっている可能性があります。")
  }
}

ko.applyBindings(new ViewModel());
