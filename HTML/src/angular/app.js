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

  runApp.$inject = ['$rootScope', '$sce', 'cfpLoadingBar', 'apiService', '$state', '$timeout', 'mercadoPago', '$transitions'];

  function runApp($rootScope, $sce, cfpLoadingBar, apiService, $state, $timeout, mercadoPago, $transitions) {
    var root = $rootScope;
    root.inicio = true;
    root.foto = false;

    //region Tema
    var colorDefault = "#FF5B10";
    root.temaStorage = apiService.getStorage('tema');
    if (root.temaStorage) {
      colorDefault = root.temaStorage.cor;
    }
    var tema = "header .logo:before, .btn, .categorias article .collumn .destaque .price, .categorias article h2:after, .produtos .filterRight li a:hover, .produtos .filterRight li a.active, header .meuCarrinho .img .notification, #loading-bar .bar, header ul li.active button, .carrinho .total div.cifra, .foto .closeModal{background: DEFAULTCOLOR}.home article h2, .produtos .listagem li .outer .total,.produto .infos .total,.carrinho .tableHolder table tbody tr td .preco,.choiceButton span:after,.cadastro .form-group label.required:after,.pagamento .obrigado h3,.pagamento .blocos ul li,.pagamento .blocos ul li .parcelas b,.pagamento .finalizacao h3,.pagamento .resumoCompra .tableHolder table tbody tr td span strong, .pagamento .resumoCompra .tableHolder table tbody tr td .preco, .pagamento .resumoCompra .tableHolder table tbody tr td:nth-child(1),.pagamento .resumoCompra .total div.number,.pagamento .resumoCompra h2,.pagamento .loginVendedor h3,.pagamento .loginVendedor .formField .input-group-addon {color: DEFAULTCOLOR}.carrinho .total div.field .btn.white, .carrinho .total div.field .number, .carrinho .total div.field ul li b{color:DEFAULTCOLOR}";
    root.tema = tema.replace(/(DEFAULTCOLOR)/g, colorDefault);

    root.$on('temaLoaded', function () {
      root.temaStorage = apiService.getStorage('tema');
      root.tema = tema.replace(/(DEFAULTCOLOR)/g, root.temaStorage.cor);
    });
    //endregion

    root.openFoto = function () {
      $timeout(function () {
        root.foto = true;
      });
    };

//    apiService.delStorage('carrinho');

    root.itensCarrinho = apiService.getStorage('carrinho') ? apiService.getStorage('carrinho').length : 0;

    //region Load Config
    var getInfoMercadoPago = function (email) {
      return apiService.post('config/mercadoPago', {
        "email": email
      }).then(function (res) {
        if (parseInt(res.result.mercado_pago) === 1) {
          mercadoPago.loadMP().then(function () {
            mercadoPago.setAccessKey();
          });

          return res.result.mercado_pago;
        }
      })
    };
    root.loadConfig = function (email, redirect) {
      if (!apiService.getStorage('auth')) {
        $state.go('login');
        return;
      }

      var dados = {
        "email": email
      };
      apiService
        .post('config', dados)
        .then(function (res) {
          getInfoMercadoPago(email).then(function (response) {
            res.result.mercado_pago = !!response ? response : 0;
            apiService.setStorage('tema', res.result);
            configGeral(redirect);
          });
        }, function () {
          configGeral(redirect);
        });
    };
    var configGeral = function (redirect) {
      var send = {
        id: 1
      };

      apiService
        .post('config', send)
        .then(function (res) {
          var tema = apiService.getStorage('tema');
          if (!tema) {
            tema = {};
          }

          var temaSalvar = res.result;
          temaSalvar.banner = tema ? tema.banner : null;
          temaSalvar.produto_id = tema ? tema.produto_id : null;
          temaSalvar.listaPreco = tema ? tema.listaPreco : null;
          temaSalvar.cor = tema ? tema.cor : null;
          temaSalvar.empresa = tema ? tema.empresa : null;
          temaSalvar.mercado_pago = tema ? tema.mercado_pago : 0;

          apiService.setStorage('tema', temaSalvar);

          root.$broadcast('temaLoaded');

          if (redirect) {
            $state.go('home');
          }

        }, function (err) {
        });

    };
    //endregion

    //region LoadConfig() se tiver autorização
    var auth = apiService.getStorage('auth');
    if (auth) {
      root.loadConfig(auth.email);
    }
    //endregion

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

    //region Transitions
    $transitions.onStart({}, function ($transition) {
      var name = $transition.$to().name;
      var auth = apiService.getStorage('auth');
      var formasPgMP = apiService.getStorage('formasPgMP');
      var cliente = apiService.getStorage('cliente');
      var carrinho = apiService.getStorage('carrinho');

      cfpLoadingBar.start();

      if (!formasPgMP && mercadoPago.mp()) {
        mercadoPago.getPaymentsMethods().then(function (res) {
          apiService.setStorage('formasPgMP', res.response);
        });
      }

      if (name === 'login' && auth) {
        return $transition.router.stateService.target('home');
      } else {
        if (name !== 'login' && !auth) {
          return $transition.router.stateService.target('login');
        }
      }

      console.log(['finalizacao', 'pagamento', 'pagamentoMP'].indexOf(name) > -1);
      console.log(cliente);

      if (['finalizacao', 'pagamento', 'pagamentoMP'].indexOf(name) > -1 && !cliente) {
        return $transition.router.stateService.target('home');
      } else if (['cadastro'].indexOf(name) > -1 && !carrinho) {
        return $transition.router.stateService.target('home');
      }

    });

    $transitions.onSuccess({}, function ($transition) {
      var name = $transition.$to().name;

      $timeout(function () {
        root.itensCarrinho = (apiService.getStorage('carrinho') || []).length;
      });

      root.inicio = ["login", "home"].indexOf(name) > -1;

      cfpLoadingBar.complete();
    });
    //endregion
  }

})();

