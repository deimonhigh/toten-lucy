(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('carrinhoController', carrinhoController);

  carrinhoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function carrinhoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    vm.totalProdutosFrete = 0;
    vm.totalProdutos = 0;
    vm.cep = "";

    vm.result = {
      "show": false
    };

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    //region Carrinho
    var calcTotal = function () {
      vm.totalProdutos = vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0);

      if (vm.result.show) {
        vm.totalProdutosFrete = angular.copy(vm.totalProdutos);
        vm.result.show = false;
      } else {
        vm.totalProdutosFrete = angular.copy(vm.totalProdutos);
      }

    };

    vm.removerItem = function (item) {
      vm.listaCompras = vm.listaCompras.filter(function (filtro) {
        return filtro.codigobarras != item.codigobarras;
      });

      apiService.setStorage('carrinho', vm.listaCompras);

      calcTotal();
    };

    vm.calcTotalItem = function (item) {
      if (item.qnt.length === 0 || item.qnt === 0) {
        item.qnt = 0;

        vm.removerItem(item)
      }

      calcTotal();
    };

    vm.minus = function (item) {
      if (item.qnt - 1 < 0) {
        item.qnt = 0;
      } else {
        item.qnt -= 1;
      }

      if (item.qnt == 0) {
        $timeout(function () { vm.removerItem(item); });
      }

      helperCarrinho(item, item.qnt);

      calcTotal();
    };

    vm.more = function (item) {
      item.qnt += 1;
      helperCarrinho(item, item.qnt);
      calcTotal();
    };

    var helperCarrinho = function (item, qnt) {
      var exist = vm.listaCompras.filter(function (obj) {
        return obj.codigobarras == item.codigobarras;
      });

      if (exist.length > 0) {
        vm.carrinho = vm.listaCompras.map(function (obj) {
          if (obj.codigobarras) {
            obj.qnt = qnt;
          }
          return obj;
        });
        apiService.setStorage('carrinho', vm.listaCompras);
      } else {
        item.qnt = qnt;
        vm.listaCompras.push(item);
        apiService.setStorage('carrinho', vm.listaCompras);
      }
    };

    vm.limparCarrinho = function () {
      apiService.delStorage('carrinho');
      root.itensCarrinho = 0;
      vm.listaCompras = [];
      calcTotal();
    };
    //endregion

    vm.calcularFrete = function () {
      apiService.cep(vm.cep).then(function (res) {
        vm.result.local = res.uf + ' - ' + res.localidade;

        var dados = {
          "cep": parseInt(vm.cep),
          "peso": vm.listaCompras.reduce(function (carry, next) {
            return carry + parseFloat(next.peso);
          }, 0)
        };

        getFrete(dados);
      }, function () {
        alert('CEP não encontrado em nossa base.');
      });
    };

    var getFrete = function (dados) {
      apiService
        .post('frete', dados)
        .then(function (res) {
          vm.result.valor = res.result.valor;
          vm.result.prazo = res.result.prazo;
          vm.result.show = true;

          vm.totalProdutosFrete = angular.copy(vm.totalProdutos) + res.result.valor;
        }, function () {
          alert('CEP não encontrado em nossa base.');
        });
    };

    calcTotal();
  }

})
(angular);