(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('carrinhoController', carrinhoController);

  carrinhoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function carrinhoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    console.log();

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    var calcTotal = function () {
      vm.totalProdutos = vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0);
    };

    vm.removerItem = function (item) {
      vm.listaCompras = vm.listaCompras.filter(function (filtro) {
        console.log(filtro);
        return filtro.$$hashKey != item.$$hashKey;
      });

      apiService.setStorage('carrinho', vm.listaCompras);

      calcTotal();
    };

    vm.calcTotalItem = function (item) {
      if (item.qnt.length == 0 || item.qnt == 0) {
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
        vm.removerItem(item);
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

    calcTotal();
  }

})
(angular);