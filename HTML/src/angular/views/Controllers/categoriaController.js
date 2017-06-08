(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('categoriaController', categoriaController);

  categoriaController.$inject = ['$scope', '$rootScope', 'apiService'];

  function categoriaController($scope, $rootScope, apiService) {
    var vm = $scope;
    var root = $rootScope;

    vm.categorias = [];

    apiService.get('categorias').then(function (res) {
      apiService.setStorage('categorias', res.result);
      vm.categorias = res.result;
    });

  }

})
(angular);