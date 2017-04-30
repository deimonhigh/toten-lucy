﻿(function () {
  'use strict';

  angular.module('appToten', [
    "ui.router",
    "LocalStorageModule",
    "angular-loading-bar",
    "ngAnimate",
    "webcam"
  ]);

  angular.module("appToten").run(runApp);

  runApp.$inject = ['$rootScope', '$window', '$sce', 'cfpLoadingBar'];

  function runApp($rootScope, $window, $sce, cfpLoadingBar) {
    var root = $rootScope;

    root.foto = false;
    root.confirmFoto = false;

    //region Loading
    root.angularNotLoaded = true;

    root.$on('loading:progress', function () {
      root.loadingData = true;
    });

    root.$on('loading:finish', function () {
      root.loadingData = false;
    });
    //endregion

    //region Utils
    root.trustResource = function (html) {
      return $sce.trustAsHtml(html);
    };

    root.trustUrl = function (url) {
      return $sce.trustAsResourceUrl(url);
    }
    //endregion

    //region Track GA
    root.trackPageView = function (pageTrack) {
      $window.ga('send', 'pageview', pageTrack);
    };

    root.trackAction = function (categoria, action, label) {
      $window.ga('send', 'event', categoria, action, label);
    };
    //endregion

    root.$on('$stateChangeStart', function () {
      cfpLoadingBar.start();
    });

    root.$on('$stateChangeSuccess', function () {
      cfpLoadingBar.complete();
    });

  }
})();
