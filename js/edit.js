function PositionModel(latitude, longitude, marker, name, info) {
  this.lat = latitude;
  this.lng = longitude;
  this.marker = marker;
  this.positionName = ko.observable(name);
  this.positionInfo = info;
}

var Positions;
function ViewModel() {
  var self = this;

  //MapModel
  self.mapName = ko.observable("oremap");
  self.mapInfo = ko.observable("ここにマップの概要を書きましょう");
  self.positions = ko.observableArray([]);
  self.posterName = ko.observable("anonymous");
  //PostionData
  self.positionName = ko.observable();
  self.positionInfo = ko.observable();
  self.lat = ko.observable();
  self.lng = ko.observable();
  self.marker = ko.observable();
  Positions = self.positions;

  //operation
  self.centeringMarker = function(position) {
    var latLng = new google.maps.LatLng(position.lat, position.lng);
    map.setCenter(latLng);
  }

  self.removePosition = function(position) {
    console.log(position);
    position.marker.setMap(null);
    self.positions.remove(position);
  };

  self.save = function() {
    self.positions().forEach(function(position){delete position['marker'] });
    $.post("./post.php", ko.toJS({
      mapName: self.mapName ,
      mapInfo: self.mapInfo ,
      posterName: self.posterName ,
      positions: self.positions
    }), function(data) {
      console.log(data);
      alert("データを送信しました。");
      document.location = "index.php";
    }).fail(function() {
      alert("データを送信しました。");
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

  ko.bindingProvider.instance.preprocessNode = function(node) {
    //to upgrade mdl-textfield with dynamic DOM
    if (node.nodeType == Node.ELEMENT_NODE) {
      if (node.className.indexOf("mdl") > -1) {
        console.debug("The node", node, "is upgraded with MDL.")
        return componentHandler.upgradeElement(node);
      }
    }
  }
}

var map;
var markers= [];
function initMap() {

  //mapの設定
  var myLatlng = new google.maps.LatLng(35.474135, 139.590182);
  var mapOptions = {
    zoom: 17,
    center: myLatlng,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    rotateControl: false
  }
  map = new google.maps.Map(document.getElementById("map"), mapOptions);

  //マップ編集の設定
  var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.MARKER,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.RIGHT_TOP,
      drawingModes: [
        google.maps.drawing.OverlayType.MARKER//,
        //google.maps.drawing.OverlayType.POLYGON
      ]
    },
  });
  drawingManager.setMap(map);
  google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
    Positions.push(new PositionModel(marker.getPosition().lat(), marker.getPosition().lng(), marker, "name", "info"));
  });
  /* 矩形を入れる
  google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
  });
  */

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
//現在地を取得する
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
      alert("現在地情報の取得に失敗しました。");
    });
  } else {
    // Browser doesn't support Geolocation
      alert("現在地情報を取得できません。\n位置情報機能がオフになっている可能性があります。");
  }
}

ko.applyBindings(new ViewModel());
