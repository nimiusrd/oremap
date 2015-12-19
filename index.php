<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>oremap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-pink.min.css">
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <!-- header begin -->
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title" data-bind="text: mapName"></span>
          <div class="mdl-layout-spacer"></div>
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <a class="mdl-navigation__link" href="./index.php">TOP</a>
            <a class="mdl-navigation__link" href="./edit.php">作る</a>
          </nav>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                      mdl-textfield--floating-label mdl-textfield--align-right">
              <label class="mdl-button mdl-js-button mdl-button--icon"
                     for="fixed-header-drawer-exp">
                <i class="material-icons">search</i>
              </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" name="sample"
                     id="fixed-header-drawer-exp">
            </div>
          </div>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title" data-bind="text: mapName"></span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link sub-header" href="./index.php">TOP</a>
          <a class="mdl-navigation__link sub-header" href="./edit.php">作る</a>
          <a id="currentPosition" class="mdl-navigation__link sub-header">現在地を表示</a>
          <span class="sub-header">MAP LIST</span>
          <div data-bind="foreach: maps">
            <a data-bind="click: $parent.getMap, text: mapName" class="mdl-navigation__link"></a>
          </div>
        </nav>
      </div>
    <!-- header end -->
      <main class="main--container mdl-layout__content">
        <div id="map"></div>
        <div class="flex-container">
          <div id="map-info-container" class="mdl-shadow--2dp">
            <div class="map-info">
              MapName:<span data-bind="text: mapName"></span>
              MapInfo:<span data-bind="text: mapInfo"></span>
            </div>
            <ul data-bind="template: {foreach: positions, beforeRemove: hideMapInfo, afterAdd: showMapInfo }">
              <li data-bind="click: $parent.centeringMarker" class="map-info mdl-shadow--2dp">
                <div>
                  緯度: <span data-bind="text: lat"></span>
                  経度: <span data-bind="text: lng"></span>
                </div>
                <div>
                  名前: <span data-bind="text: positionName"></span></br>
                  info: <span data-bind="text: positionInfo"></span></br>
                </div>
              </li>
            </ul>
          </div>
          <div id="map-list" class="mdl-shadow--4dp">
            <div>
              <ul class="map-list-header"><li class="map-list--name">MAP NAME</li><li class="map-list--poster">POSTER</li><li class="map-list--date">DATE</li></ul>
            </div>
            <div data-bind="foreach: maps">
              <ul class="map-list-item" data-bind="click: $parent.getMap"><li class="map-list--name" data-bind="text: mapName"></li><li class="map-list--poster" data-bind="text: posterName"></li><li class="map-list--date" data-bind="text: date"></li></ul>
            </div>
          </div>
        </div>
      </main>
    </div>
    <!-- GoogleMapsAPIの読み込み -->
    <script src="https://maps.googleapis.com/maps/api/js&language=ja&callback=initMap&libraries=places"
      async defer></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/vendor/jquery-ui.min.js"></script>
    <script type='text/javascript' src='js/knockout-3.3.0.js'></script>
    <script src="js/map.js"></script>
  </body>
</html>
