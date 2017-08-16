(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('finalizacaoController', finalizacaoController);

  finalizacaoController.$inject = ['$scope', '$rootScope', 'apiService', 'config', '$timeout', '$state'];

  function finalizacaoController($scope, $rootScope, apiService, config, $timeout, $state) {
    var vm = $scope;
    var root = $rootScope;
    vm.dadosVendedor = {};
    vm.formaPagamento = '';
    vm.editarPagamentoFlag = false;
    vm.cliente = apiService.getStorage('cliente');
    vm.formaPagamentoStorage = apiService.getStorage('formaPagamento');
    vm.comprovante = apiService.getStorage('comprovante');
    vm.frete = apiService.getStorage('frete');
    var boleto = apiService.getStorage('boleto');
    vm.hideComprovante = true;
    vm.showBoleto = {
      "show": false,
      "boleto": ""
    };
    vm.totalCarrinho = 0;
    vm.totalCarrinhoFrete = 0;

    $timeout(function () {
      root.itensCarrinho = 0;
    });

    apiService.delStorage('cliente');
    apiService.delStorage('carrinho');

    if (boleto.boleto) {
      vm.showBoleto.show = true;
      vm.showBoleto.boleto = boleto.boleto;
    }

    if (boleto.mp) {
      vm.hideComprovante = false;
    }

    var getComprovante = function () {
      $timeout(function () {
        vm.comprovante = apiService.getStorage('comprovante');
      });

      if (!vm.comprovante) {
        getComprovante();
      }
    };

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    var calcTotal = function () {
      return vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0) + parseFloat(vm.cliente.freteValor.valor);
    };

    vm.totalCarrinho = calcTotal();

    var padLeft = function (nr, n, str) {
      return Array(n - String(nr).length + 1).join(str || '0') + nr;
    };

    vm.idPedido = config.prefix + padLeft(vm.cliente.idPedido, 13).replace(/^(\d{4})(\d{4})(\d+)(\d{2})/, '$1.$2.$3-$4');

    vm.limparSessao = function () {
      apiService.delStorage('comprovante');
      apiService.delStorage('cliente');
      apiService.delStorage('carrinho');
      apiService.delStorage('formaPagamento');
      apiService.delStorage('comprovanteCodigos');
      apiService.delStorage('vendedor');
      apiService.delStorage('frete');
      apiService.delStorage('boleto');
      $timeout(function () {
        root.itensCarrinho = 0;
      });

      $state.go('home');
    };
  }

})
(angular);