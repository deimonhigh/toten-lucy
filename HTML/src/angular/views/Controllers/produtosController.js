(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('produtosController', produtosController);

  produtosController.$inject = ['$scope', '$rootScope', 'apiService', '$stateParams', '$state', '$filter'];

  function produtosController($scope, $rootScope, apiService, $stateParams, $state, $filter) {
    var vm = $scope;
    var root = $rootScope;

    if (!$stateParams.categoria) {
      $state.go('categorias');
      return
    }

    vm.maxParcelas = root.temaStorage['parcela' + root.temaStorage.max_parcelas];

    vm.menuActive = $stateParams.categoria;

    vm.loading = false;

    vm.categorias = apiService.getStorage('categorias');

    vm.produtoActive = $filter('filter')(vm.categorias, {'id': parseInt(vm.menuActive)}, true)[0].descricao;

    vm.produtos = [];

    var categoriasItem = vm.categorias.filter(function (obj) {
      return obj.id == $stateParams.categoria
    })[0];

    if (categoriasItem.categorias) {
      var itensDoFiltro = categoriasItem.categorias.map(function (obj) {
        return obj.codigocategoria;
      });

      var filtro = {
        "itens": itensDoFiltro
      }

      apiService.post('produtos/filtro', filtro).then(function (res) {
        vm.loading = true;
        vm.produtos = res.result.filter(function (obj) {
          return obj['preco' + root.temaStorage.listaPreco] > 0;
        }).map(function (obj) {
          obj.preco = obj['preco' + root.temaStorage.listaPreco];
          obj.precopromocao = obj['precopromocao' + root.temaStorage.listaPreco];

          if (parseFloat(obj.precopromocao) == 0) {
            obj.comJuros = ((parseFloat(obj.preco) + (parseFloat(obj.preco) * parseFloat(vm.maxParcelas)) / 100).toFixed(2)) / parseInt(root.temaStorage.max_parcelas);
          } else {
            obj.comJuros = ((parseFloat(obj.precopromocao) + (parseFloat(obj.precopromocao) * parseFloat(vm.maxParcelas)) / 100).toFixed(2)) / parseInt(root.temaStorage.max_parcelas);
          }

          return obj;
        });
      });

    }
  }

})
(angular);