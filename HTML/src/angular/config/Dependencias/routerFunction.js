(function () {
  "use strict";

  angular.module('appToten').config(routeFn);

  routeFn.$inject = ['$stateProvider', '$urlRouterProvider', 'localStorageServiceProvider', 'cfpLoadingBarProvider'];

  function routeFn($stateProvider, $urlRouterProvider, localStorageServiceProvider, cfpLoadingBarProvider) {

    cfpLoadingBarProvider.includeSpinner = false;

    localStorageServiceProvider
      .setPrefix('appToten')
      .setStorageType('sessionStorage');

    $urlRouterProvider.otherwise('/');

    $stateProvider
      .state("erro", {
        url: "/404",
        templateUrl: "./views/404.html"
      })

      .state("home", {
        url: "/home",
        templateUrl: "./views/home.html"
      })

      .state("login", {
        url: "/",
        templateUrl: "./views/login.html",
        controller: "loginController"
      })

      .state("categorias", {
        url: "/categorias",
        templateUrl: "./views/categorias.html",
        controller: "categoriaController"
      })

      .state("carrinho", {
        url: "/meuCarrinho",
        templateUrl: "./views/carrinho.html",
        controller: "carrinhoController"
      })

      .state("cadastro", {
        url: "/cadastro",
        templateUrl: "./views/cadastro.html",
        controller: "cadastroController"
      })

      .state("produtos", {
        url: "/produtos/:categoria",
        templateUrl: "./views/produtos.html",
        controller: "produtosController"
      })

      .state("produto", {
        url: "/produto/:id",
        templateUrl: "./views/produto.html",
        controller: "produtoController"
      })

      .state("pagamento", {
        url: "/pagamento",
        templateUrl: "./views/pagamento.html",
        controller: "pagamentoController"
      })

      .state("finalizacao", {
        url: "/finalizacao",
        templateUrl: "./views/finalizacao.html",
        controller: "pagamentoController"
      })
  }
})(angular);
