(function () {
  "use strict";

  angular.module('appGoPharma').config(routeFn);

  routeFn.$inject = ['$stateProvider', '$urlRouterProvider', '$mdThemingProvider', 'localStorageServiceProvider', '$compileProvider'];

  function routeFn($stateProvider, $urlRouterProvider, $mdThemingProvider, localStorageServiceProvider, $compileProvider) {

    $mdThemingProvider
      .theme('default')
      .primaryPalette('orange')
      .accentPalette('deep-orange');

    localStorageServiceProvider
      .setPrefix('appGoPharma')
      .setStorageType('localStorage');


    $compileProvider.aHrefSanitizationWhitelist(/^\s*(market|itms-apps|https|itms):/);

    $urlRouterProvider.otherwise('/splash');

    $stateProvider
      .state("erro", {
        url: "/404",
        templateUrl: "./views/404.html"
      })

      // SplashScreen
      .state("splash", {
        url: "/splash",
        templateUrl: "./views/splash.html",
        controller: "splashController",
        resolve: {
          closeApp: [
            'apiService', '$state', function (apiService, $state) {
              var ok = apiService.getStorage('url');
              if (ok.hasOwnProperty('url')) {
                apiService.delStorage('url');
                $state.go(ok.url);
              }
            }
          ]
        }
      })

      // HOME - Busca
      .state("farmacias", {
        url: "/busca/farmacias/:beneficio?",
        templateUrl: "./views/busca/farmacias.html",
        params: {
          nav: "farmacias",
          beneficio: null
        },
        controller: "homeController",
        resolve: {
          closeApp: [
            'apiService', '$state', function (apiService, $state) {
              var ok = apiService.getStorage('splashOk');
              if (!ok.hasOwnProperty('ok')) {
                $state.go('splash');
              }
            }
          ]
        }
      })
      .state("produtos", {
        url: "/busca/produtos",
        templateUrl: "./views/busca/produtos.html",
        params: {
          nav: "produtos"
        },
        controller: "homeController"
      })
      .state("beneficios", {
        url: "/busca/beneficios",
        templateUrl: "./views/busca/beneficios.html",
        params: {
          nav: "beneficios"
        },
        controller: "homeController"
      })

      // INTERNA - Trocar endereço
      .state("endereco", {
        url: "/trocar-endereco",
        params: {
          endereco: 0
        },
        templateUrl: "./views/endereco/endereco.html",
        controller: "enderecoController"
      })
      // INTERNA - Trocar endereço - Não sei CEP
      .state("enderecoCep", {
        url: "/trocar-endereco-cep",
        params: {
          endereco: 1
        },
        templateUrl: "./views/endereco/endereco-nao-sei.html",
        controller: "enderecoController"
      })

      // INTERNA - Farmacia
      .state("farmacia", {
        url: "/farmacias",
        templateUrl: "./views/farmacias/farmacia-detalhe.html",
        controller: "farmaciaController"
      })

      // INTERNA - Beneficio
      .state("beneficio", {
        url: "/beneficios",
        templateUrl: "./views/busca/busca-interna-beneficio.html",
        controller: "homeController"
      })

      // Promoções
      .state("promo", {
        url: "/promo",
        templateUrl: "./views/promocao/promo.html",
        controller: "promoController"
      })

      // INTERNA - Promoções
      .state("promocao", {
        url: "/promo/:promo",
        templateUrl: "./views/promocao/promo-interna.html",
        controller: "promoController"
      })

      // Pesquisas
      .state("pesquisas", {
        url: "/pesquisas",
        templateUrl: "./views/pesquisa/pesquisa.html",
        controller: "pesquisaController"
      })

      // INTERNA - Pesquisas
      .state("pesquisa", {
        url: "/pesquisa/:pesquisa",
        templateUrl: "./views/pesquisa/pesquisa-interna.html",
        controller: "pesquisaController"
      })

      .state("me", {
        url: "/me",
        templateUrl: "./views/perfil/me.html",
        controller: "loginController"
      })

      .state("meInterna", {
        url: "/me/interna/",
        templateUrl: "./views/perfil/me-interna.html",
        controller: "perfilController"
      })

      .state("meusBeneficios", {
        url: "/me/beneficios/",
        templateUrl: "./views/perfil/me-beneficios.html",
        controller: "beneficiosController"
      })

      .state("meEmail", {
        url: "/me/login/email",
        templateUrl: "./views/perfil/me-login-email.html",
        controller: "loginController"
      })

      .state("meNumero", {
        url: "/me/login/numero",
        templateUrl: "./views/perfil/me-login-numero.html",
        controller: "loginController"
      })

      .state("alterarsenha", {
        url: "/me/alterarSenha",
        templateUrl: "./views/perfil/me-alterarSenha.html",
        controller: "loginController"
      })

      .state("cadastrar", {
        url: "/me/cadastrar",
        templateUrl: "./views/perfil/me-cadastrar.html",
        controller: "cadastroController"
      })

      .state("adesao", {
        url: "/adesao/:beneficio",
        templateUrl: "./views/adesao/adesao.html",
        controller: "adesaoController"
      })

      .state("noInternet", {
        url: "/noIntenet",
        templateUrl: "./views/connect/noInternet.html",
        controller: "connectionController"
      })

  }
})(angular);
