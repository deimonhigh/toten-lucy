(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoController', pagamentoController);

  pagamentoController.$inject = ['$scope', '$rootScope', 'apiService', '$state', '$timeout'];

  function pagamentoController($scope, $rootScope, apiService, $state, $timeout) {
    var vm = $scope;
    var root = $rootScope;
    vm.dadosVendedor = {};
    vm.editarPagamentoFlag = true;
    vm.cliente = apiService.getStorage('cliente');
    vm.comprovante = apiService.getStorage('comprovante');

    var getComprovante = function () {
      $timeout(function () {
        vm.comprovante = apiService.getStorage('comprovante');
      });

      if (!vm.comprovante) {
        getComprovante();
      }
    }

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    vm.totalCarrinho = vm.listaCompras.reduce(function (previousValue, obj) {
      return previousValue + (obj.preco * obj.qnt);
    }, 0);

    var padLeft = function (nr, n, str) {
      return Array(n - String(nr).length + 1).join(str || '0') + nr;
    };

    vm.idPedido = padLeft(vm.cliente.idPedido, 13).replace(/^(\d{4})(\d{4})(\d+)(\d{2})/, '$1.$2.$3-$4');

    vm.validarVendedor = function () {
      var enviar = {};
      apiService.delStorage('comprovante');
      enviar.identificacao = vm.dadosVendedor.identificacao;
      enviar.senha = vm.dadosVendedor.senha;
      apiService.post('vendedores/validate', enviar).then(function (res) {
        console.log(res);
        $state.go('finalizacao')
        root.openFoto();
      }, function (err) {
        alert(err.error);
      })
    };

    vm.limparSessao = function () {
      apiService.delStorage('comprovante');
      apiService.delStorage('cliente');
      apiService.delStorage('carrinho');
    };

    vm.editarPagamento = function () {
      vm.editarPagamentoFlag = !vm.editarPagamentoFlag;
    }

    vm.$on('confirmarImg', function () {
      var send = {};
      send.idcliente = vm.cliente.id;
      send.total = vm.totalCarrinho;
      send.idPedido = vm.cliente.idPedido;
      send.img = vm.comprovante;

      apiService.post('pedidos/save', send).then(function (res) {
        console.log(res);
      }, function (err) {
        console.log(err);
      })
    });
  }

})
(angular);