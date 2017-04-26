(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('footerController', footerController);

  footerController.$inject = ['$scope', '$rootScope', '$timeout', '$mdSidenav'];

  function footerController($scope, $rootScope, $timeout, $mdSidenav) {
    var vm = $scope;
    var root = $rootScope;

    vm.navItemFooter = "Busca";

    root.$on('$stateChangeSuccess', function (event, toState) {
      if (toState.name == 'splash') {
        root.SplashScreen = true;
      } else{
        root.SplashScreen = false;
      }
      $timeout(function () {
        vm.navItemFooter = ['beneficios', 'produtos', 'farmacias'].indexOf(toState.name) > -1 ? 'busca' : toState.name;
      });
    });

  }

})(angular);