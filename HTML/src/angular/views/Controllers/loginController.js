(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('loginController', loginController);

  loginController.$inject = ['$scope', '$rootScope', 'apiService', '$state'];

  function loginController($scope, $rootScope, apiService, $state) {
    var vm = $scope;
    var root = $rootScope;

    vm.login = function (dados) {
      apiService
        .token(dados)
        .then(function (res) {
          apiService.setStorage('auth', res);

          apiService
            .get('tema/1')
            .then(function (res) {
              apiService.setStorage('tema', res.result);
              root.$broadcast('temaLoaded');
              $state.go('home');
            }, function (err) {
              alert(err.error);
            });
        }, function (err) {
          console.log(err);
          alert('Usuário ou senha inválidos.')
        })
    }
  }

})
(angular);