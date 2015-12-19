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
          <span class="sub-header">POSITION LIST</span>
          <div data-bind="foreach: positions">
            <a class="mdl-navigation__link" data-bind="text: positionName, click: $parent.centeringMarker"></a>
          </div>
        </nav>
      </div>
    <!-- header end -->
      <main class="main--container mdl-layout__content">
        <div id="map"></div>
        <div id="map-info-container" class="mdl-shadow--2dp">
          <div class="flex-container">
            <div class="map-textfield-small mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
              <input value=" " class="mdl-textfield__input" type="text" data-bind="value: mapName" />
              <label class="mdl-textfield__label">Map Name...</label>
            </div>
            <div class="map-textfield-large mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
              <textarea class="mdl-textfield__input" type="text" rows= "3" data-bind="value: mapInfo"> </textarea>
              <label class="mdl-textfield__label">Map Info...</label>
            </div>
          </div>
          <ul data-bind="template: {foreach: positions, beforeRemove: hideMapInfo, afterAdd: showMapInfo }" class="map-info">
            <li data-bind="click: $parent.centeringMarker" class="map-info mdl-shadow--2dp">
              <div>
                緯度: <span data-bind="text: lat"></span>
                経度: <span data-bind="text: lng"></span>
              </div>
              <div class="flex-container">
                <div class="map-textfield-small mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
                  <input value=" " class="mdl-textfield__input" type="text" data-bind="value: positionName" />
                  <label class="mdl-textfield__label">Position Name...</label>
                </div>
                <div class="map-textfield-large mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
                  <textarea class="mdl-textfield__input" type="text" rows= "3" data-bind="value: positionInfo"> </textarea>
                  <label class="mdl-textfield__label">Position Info...</label>
                </div>
              </div>
              <a class="mdl-button mdl-js-button mdl-button--icon" data-bind="click: $parent.removePosition">
                <i class="material-icons">delete</i>
              </a>
            </li>
          </ul>
          <div>
            <div class="is-dirty mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input value=" " class="mdl-textfield__input" type="text" data-bind="value: posterName" />
              <label class="mdl-textfield__label">Poster ...</label>
            </div>
          </div>
          <button data-bind="click: save" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
            Save
          </button>
        </div>
      </main>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/vendor/jquery-ui.min.js"></script>
    <!-- GoogleMapsAPIの読み込み -->
    <script src="https://maps.googleapis.com/maps/api/js&language=ja&callback=initMap&libraries=drawing,places"
      async defer></script>
    <script type='text/javascript' src='js/knockout-3.3.0.js'></script>
    <script src="js/edit.js"></script>
  </body>
</html>
