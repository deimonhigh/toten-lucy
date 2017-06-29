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
        vm.produtos = res.result.map(function (obj) {
          obj.preco = obj['preco' + root.temaStorage.listaPreco];
          obj.precopromocao = obj['precopromocao' + root.temaStorage.listaPreco];
          return obj;
        });
      });

    }
  }

})
(angular);