(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoController', pagamentoController);

  pagamentoController.$inject = ['$scope', '$rootScope', 'apiService', '$state', '$timeout'];

  function pagamentoController($scope, $rootScope, apiService, $state, $timeout) {
    var vm = $scope;
    var root = $rootScope;
    vm.dadosVendedor = {};
    vm.formaPagamento = {};
    vm.editarPagamentoFlag = false;
    vm.cliente = apiService.getStorage('cliente');
    vm.formaPagamentoStorage = apiService.getStorage('formaPagamento');
    vm.comprovante = apiService.getStorage('comprovante');

    var getComprovante = function () {
      $timeout(function () {
        vm.comprovante = apiService.getStorage('comprovante');
      });

      if (!vm.comprovante) {
        getComprovante();
      }
    };

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    vm.totalCarrinho = vm.listaCompras.reduce(function (previousValue, obj) {
      return previousValue + (obj.preco * obj.qnt);
    }, 0);

    var padLeft = function (nr, n, str) {
      return Array(n - String(nr).length + 1).join(str || '0') + nr;
    };

    vm.idPedido = 'SF.' + padLeft(vm.cliente.idPedido, 13).replace(/^(\d{4})(\d{4})(\d+)(\d{2})/, '$1.$2.$3-$4');

    vm.validarVendedor = function () {
      var enviar = {};
      apiService.delStorage('comprovante');
      enviar.identificacao = vm.dadosVendedor.identificacao;
      enviar.senha = vm.dadosVendedor.senha;
      apiService.post('vendedores/validate', enviar).then(function (res) {
        $state.go('finalizacao');
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

      apiService.setStorage('formaPagamento', vm.formaPagamento);
      
      if (vm.editarPagamentoFlag && vm.formaPagamento.total) {
        $timeout(function () {
          vm.totalCarrinho = vm.formaPagamento.total;
        });
      }
    };

    vm.$on('confirmarImg', function () {
      var formaPagamento = apiService.getStorage('formaPagamento');
      vm.comprovante = apiService.getStorage('comprovante');
      vm.cliente = apiService.getStorage('cliente');

      var send = {};
      send.idcliente = vm.cliente.id;
      send.total = vm.formaPagamentoStorage.total;
      send.idPedido = vm.cliente.idPedido;
      send.img = vm.comprovante;

      send.produtos = vm.listaCompras.map(function (obj) {
        return {
          "produto_id": obj.id,
          "codigoproduto": obj.codigoproduto,
          "qnt": obj.qnt,
          "preco": obj.preco,
        };
      });

      send.parcelas = formaPagamento.parcelas;
      send.aVista = formaPagamento.aVista;

      apiService.post('pedidos/save', send).then(function (res) {
        
      }, function (err) {
        console.log(err);
        $state.go('carrinho');
        alert('Pedido não concluída, tente novamente!');
      })
    });

    var comJurosAVista = vm.totalCarrinho + vm.totalCarrinho * (root.temaStorage['parcela0'] / 100);
    vm.listaPagamentos = [
      {
        "index": 0,
        "parcelas": 0,
        "aVista": true,
        "descricao": 'À vista | R$ ' + comJurosAVista.toFixed(2).replace('.', ','),
        "total": comJurosAVista
      }
    ];

    for (var i = 1; i < 13; i++) {
      var comJuros = vm.totalCarrinho + vm.totalCarrinho * (root.temaStorage['parcela' + i] / 100);
      var pagamento = {
        "index": i + 1,
        "parcelas": i,
        "aVista": false,
        "descricao": 'Cartão de crédito | ' + i + 'x de R$ ' + (comJuros / i).toFixed(2).replace('.', ','),
        "total": comJuros
      };

      vm.listaPagamentos.push(pagamento);
    }
  }

})
(angular);