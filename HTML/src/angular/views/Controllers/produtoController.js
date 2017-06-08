(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('produtoController', produtoController);

  produtoController.$inject = ['$scope', '$rootScope', 'apiService', '$state', '$stateParams'];

  function produtoController($scope, $rootScope, apiService, $state, $stateParams) {
    var vm = $scope;
    var root = $rootScope;

    vm.qnt = 1;
    vm.produtosRelacionados = [];

    vm.carrinho = apiService.getStorage('carrinho') || [];
    vm.produto = {};
    vm.temasItem = apiService.getStorage('tema');

    console.log($stateParams.id);

    apiService.get('produtos/' + $stateParams.id).then(function (res) {
      vm.produto = res.result;
      vm.imagemGrande = vm.produto.imagens[0];

      apiService.post('produtos/relacionados', {
        "produtocodigo": vm.produto.codigoproduto
      }).then(function (res) {
        console.log(res);
        vm.produtosRelacionados = res.result;
      }, function (err) {
        alert(err.error);
      });

    }, function (err) {
      alert(err.error);
    })

    vm.minus = function () {
      if (vm.qnt - 1 < 0) {
        vm.qnt = 0;
      } else {
        vm.qnt -= 1;
      }

      if (vm.qnt == 0) {
        vm.removerItem(item);
      }
    };

    vm.more = function () {
      vm.qnt += 1;
    };

    vm.selectColor = function (item) {
      vm.cores.map(function (obj) {
        obj.selected = false;
      });

      item.selected = true;
    };

    vm.changeImg = function (item) {
      vm.imagemGrande = item;
    }

    vm.addCarrinho = function (item) {
      var exist = vm.carrinho.filter(function (obj) {
        return obj.codigobarras == item.codigobarras;
      });

      if (exist.length > 0) {
        vm.carrinho = vm.carrinho.map(function (obj) {
          if (obj.codigobarras) {
            obj.qnt = vm.qnt;
          }
          return obj;
        });
        apiService.setStorage('carrinho', vm.carrinho);
      } else {
        item.qnt = vm.qnt;
        vm.carrinho.push(item);
        apiService.setStorage('carrinho', vm.carrinho);
      }
      $state.go('carrinho');
    };
  };

})
(angular);