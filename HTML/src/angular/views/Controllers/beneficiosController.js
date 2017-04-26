(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('perfilController', perfilController);

  perfilController.$inject = ['$scope', 'apiService', '$state', '$httpParamSerializer', 'latinizeService', '$filter', '$cordovaDevice'];

  function perfilController($scope, apiService, $state, $httpParamSerializer, latinizeService, $filter, $cordovaDevice) {
    var vm = $scope;

    vm.tabSelected = 0;

    var device = $cordovaDevice.getUUID();

    vm.dados = apiService.getStorage('usuario');

    if (vm.dados.hasOwnProperty('username')) {
      var dataNascimento = $filter('date')(vm.dados.DataNascimento, 'YYYY-MM-dd');

      apiService
        .get("usuario/CPFConsumidor/" + vm.dados.CPF + "/DataNascConsumidor/" + dataNascimento + "/GetUsuarioAdesoes")
        .then(function (res) {
          console.log(res);
          vm.beneficios = res;

        }, function (err) {
          apiService.errorCall(err);
        })
    }

    vm.loaderData = false;

    vm.logado = apiService.getStorage('usuario').hasOwnProperty('Usuario');

    vm.sair = function () {
      apiService.delStorage('usuario');
      $state.go('me');
    };
  }

})(angular);