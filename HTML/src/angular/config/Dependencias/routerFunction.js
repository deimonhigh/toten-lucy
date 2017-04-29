(function () {
  "use strict";

  angular.module('appToten').config(routeFn);

  routeFn.$inject = ['$stateProvider', '$urlRouterProvider', 'localStorageServiceProvider', 'cfpLoadingBarProvider'];

  function routeFn($stateProvider, $urlRouterProvider, localStorageServiceProvider, cfpLoadingBarProvider) {

    cfpLoadingBarProvider.includeSpinner = false;

    localStorageServiceProvider
      .setPrefix('appToten')
      .setStorageType('localStorage');

    $urlRouterProvider.otherwise('/');

    $stateProvider
      .state("erro", {
        url: "/404",
        templateUrl: "./views/404.html"
      })

      .state("home", {
        url: "/home",
        templateUrl: "./views/home.html",
        controller: "homeController"
      })

      .state("login", {
        url: "/",
        templateUrl: "./views/login.html",
        controller: "loginController"
      })

      .state("categorias", {
        url: "/categorias",
        templateUrl: "./views/categorias.html",
        controller: "loginController"
      })

  }
})(angular);
