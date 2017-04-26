(function () {
  'use strict';

  angular.module('appGoPharma', [
    "ui.router",
    "LocalStorageModule",
    "ngMaterial",
    "ngCordova",
    "star-rating",
    "ngInputModified"
  ]);

  angular.module("appGoPharma").run(runApp);

  runApp.$inject = ['$rootScope', '$window', '$sce', 'apiService', '$timeout', '$mdDialog'];

  function runApp($rootScope, $window, $sce, apiService, $timeout, $mdDialog) {
    var root = $rootScope;
    var offline = false;
    root.online = false;

    root.firstTime = 0;

    root.SplashScreen = false;

    root.angularNotLoaded = true;

    root.loadingData = false;

    root.$on('loading:progress', function () {
      root.loadingData = true;
    });

    root.$on('loading:finish', function () {
      root.loadingData = false;
    });

    root.trustResource = function (html) {
      return $sce.trustAsHtml(html);
    };

    root.trustUrl = function (url) {
      return $sce.trustAsResourceUrl(url);
    }

    root.$on('$stateChangeStart', function (event, toState) {
      if (toState.name == 'splash' && root.firstTime > 0) {
        root.firstTime++;
        var confirm = $mdDialog.confirm()
                               .title('Você deseja sair do App?')
                               .ariaLabel('Você deseja sair do App?')
                               .ok('Sim')
                               .cancel('Não');

        $mdDialog.show(confirm).then(function () {
          navigator.app.exitApp();
        }, function () {
          event.preventDefault();
        });
      }
    });

    root.$on('$viewContentLoaded', function () {
      root.angularNotLoaded = false
    });

    root.trackPageView = function (pageTrack) {
      $window.ga('send', 'pageview', pageTrack);
    };

    root.trackAction = function (categoria, action, label) {
      $window.ga('send', 'event', categoria, action, label);
    };

    apiService.userLocation().then(function (res) {
      apiService.setStorage('locationGeo', res);
    }, function (err) {
      apiService.customMessage("Não conseguimos localizar você. Seu GPS está ligado?");
    });

    $rootScope.$on('$cordovaNetwork:online', function (event, networkState) {
      $timeout(function () {
        root.online = true;
      })
    });

//    apiService.noInternet();

    $rootScope.$on('$cordovaNetwork:offline', function (event, networkState) {
      apiService.noInternet();
      //$state.go('noInternet');
      $timeout(function () {
        root.online = false;
      })
    });
  }
})();
