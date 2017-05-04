(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('produtosController', produtosController);

  produtosController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function produtosController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    vm.produtos = [].concat.apply([], new Array(20)).map(function (obj, i) {
      return {
        "index": i
      };
    });

  }

})
(angular);