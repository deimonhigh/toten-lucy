(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoController', pagamentoController);

  pagamentoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function pagamentoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

  }

})
(angular);