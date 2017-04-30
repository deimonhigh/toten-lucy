(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('carrinhoController', carrinhoController);

  carrinhoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function carrinhoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    vm.listaCompras = [].concat.apply([], new Array(20)).map(function (obj, i) {
      return i;
    });

    console.log(vm.listaCompras);

  }

})
(angular);