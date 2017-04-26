(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('enderecoModalController', enderecoModalController);

  enderecoModalController.$inject = ['$scope', '$mdDialog', 'apiService', '$rootScope', "$timeout", '$location', '$state'];

  function enderecoModalController($scope, $mdDialog, apiService, $rootScope, $timeout, $location, $state) {
    var vm = $scope;
    vm.online = false;
    var endereco = apiService.getStorage('locationAddress');
    if (endereco.endereco) {
      endereco = endereco.endereco

      vm.endereco = {};
      vm.endereco.rua = endereco.address_components[1].short_name;
      vm.endereco.paisEstado = endereco.address_components[5].long_name + ' - ' + endereco.address_components[4].long_name;
    }

    vm.confirm = function (numero) {
      var location = apiService.getStorage('locationAddress');

      var endereco = location.endereco.formatted_address.split(' - ');

      endereco[0] += ', ' + numero;
      endereco = endereco.join(' - ');

      location.endereco.formatted_address = endereco;

      apiService.setStorage('locationAddress', location)

      var dummy = {
        location: true
      };

      apiService.setStorage('enderecoLocalizacao', dummy);

      $mdDialog.hide();
    };

    $rootScope.$on('$cordovaNetwork:online', function (event, networkState) {
      $timeout(function () {
        console.log('online');
        vm.online = true;
      });
    });

    $rootScope.$on('$cordovaNetwork:offline', function (event, networkState) {
      $timeout(function () {
        console.log('offline');
        vm.online = false;
      });
    });
    vm.cancel = function () {
      $mdDialog.cancel();
    };

    vm.cancelAndReload = function () {
      var url = $location.absUrl();
      if (url.indexOf('splash') > -1) {
        $state.reload();
      }
      $mdDialog.cancel();
    };
  }

})(angular);