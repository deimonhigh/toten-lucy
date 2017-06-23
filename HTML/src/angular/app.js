(function () {
  'use strict';

  angular.module('appToten', [
    "ui.router",
    "ngLocale",
    "LocalStorageModule",
    "angular-loading-bar",
    "ngAnimate",
    "webcam"
  ]);

  angular.module("appToten").run(runApp);

  runApp.$inject = ['$rootScope', '$sce', 'cfpLoadingBar', 'apiService', '$state', '$timeout', 'localStorageService'];

  function runApp($rootScope, $sce, cfpLoadingBar, apiService, $state, $timeout, localStorageService) {
    var root = $rootScope;
    root.inicio = true;
    root.foto = false;

    var colorDefault = "#FF5B10";
    root.temaStorage = apiService.getStorage('tema');
    if (root.temaStorage) {
      colorDefault = root.temaStorage.cor;
    }
    var tema = "header .logo:before, .btn, .categorias article .collumn .destaque .price, .categorias article .collumn ul li a:hover, .categorias article h2:after, .produtos .filterRight li a:hover, .produtos .filterRight li a.active, header .meuCarrinho .img .notification, #loading-bar .bar, header ul li.active button, .carrinho .total div.cifra, .foto .closeModal{background: DEFAULTCOLOR}.home article h2, .produtos .listagem li .outer .total,.produto .infos .total,.carrinho .tableHolder table tbody tr td .preco,.choiceButton span:after,.cadastro .form-group label.required:after,.pagamento .obrigado h3,.pagamento .blocos ul li,.pagamento .blocos ul li .parcelas b,.pagamento .finalizacao h3,.pagamento .resumoCompra .tableHolder table tbody tr td span strong, .pagamento .resumoCompra .tableHolder table tbody tr td .preco, .pagamento .resumoCompra .tableHolder table tbody tr td:nth-child(1),.pagamento .resumoCompra .total div.number,.pagamento .resumoCompra h2,.pagamento .loginVendedor h3,.pagamento .loginVendedor .formField .input-group-addon {color: DEFAULTCOLOR}.carrinho .total div.cifra:after{border-left-color:DEFAULTCOLOR}";
    root.tema = tema.replace(/(DEFAULTCOLOR)/g, colorDefault);

    root.$on('temaLoaded', function () {
      root.temaStorage = apiService.getStorage('tema');
      root.tema = tema.replace(/(DEFAULTCOLOR)/g, root.temaStorage.cor);
    });

    root.openFoto = function () {
      root.foto = true;
    };

//    apiService.delStorage('carrinho');

    root.itensCarrinho = apiService.getStorage('carrinho') ? apiService.getStorage('carrinho').length : 0;

    root.$watch(function () {
      return localStorageService.get('carrinho');
    }, function (newVal) {
      if (newVal) {
        root.itensCarrinho = JSON.parse(atob(newVal)).length;
      }
    });

    apiService
      .get('tema/1')
      .then(function (res) {
        apiService.setStorage('tema', res.result);
        root.$broadcast('temaLoaded');
        $state.go('home');
      }, function (err) {
        console.log(err.error);
      });

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
    };
    //endregion

    root.$on('$stateChangeStart', function (event, toState) {
      var auth = apiService.getStorage('auth');

      if (toState.name == 'login') {
        if (auth) {
          $timeout(function () { $state.go('home'); });
        }
      } else {
        if (!auth) {
          $timeout(function () { $state.go('login'); });
        }
      }
      cfpLoadingBar.start();
    });

    root.$on('$stateChangeSuccess', function (event, toState) {
      if (["login", "home"].indexOf(toState.name) > -1) {
        root.inicio = true;
      } else {
        root.inicio = false;
      }

      cfpLoadingBar.complete();
    });

  }

})();

