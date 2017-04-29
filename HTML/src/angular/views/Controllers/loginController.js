(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('loginController', loginController);

  loginController.$inject = ['$scope', '$rootScope', 'apiService', '$state'];

  function loginController($scope, $rootScope, apiService, $state) {
    var vm = $scope;
    var root = $rootScope;

    vm.login = function (dados) {
      $state.go('home');
      return;
      apiService.get('usuario/login', dados).then(function (res) {
        if (res.status == 0) {
          $state.go('home');
        }
      })
    }
  }

})
(angular);