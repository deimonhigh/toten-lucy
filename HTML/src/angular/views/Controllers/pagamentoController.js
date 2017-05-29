(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoController', pagamentoController);

  pagamentoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function pagamentoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    vm.cliente = apiService.getStorage('cliente');

    console.log(vm.cliente);
  }

})
(angular);