(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('promoController', promoController);

  promoController.$inject = ['$scope'];

  function promoController($scope) {
    var vm = $scope;
    vm.currentNavItem = "Busca";
  }

})(angular);