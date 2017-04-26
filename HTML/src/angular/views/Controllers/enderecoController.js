(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('enderecoController', enderecoController);

  enderecoController.$inject = ['$scope', '$stateParams', 'latinizeService', '$mdDialog', '$location', 'apiService', '$state', '$rootScope'];

  function enderecoController($scope, $stateParams, latinizeService, $mdDialog, $location, apiService, $state, $rootScope) {
    var vm = $scope;
    var uri = $location.absUrl().replace(/(index\.html.*)/, '');
    vm.endereco = {};

    //region Estados
    if ($stateParams.endereco == 1) {
      vm.estados = cidadesEstados.estados.map(function (obj) {
        return {
          "sigla": obj.sigla,
          "nome": obj.nome
        }
      });

      vm.procuraCidades = function () {
        vm.cidades = cidadesEstados.estados.filter(function (obj) {
          return obj.sigla == vm.endereco.estado.sigla;
        })[0].cidades.map(function (obj) {
          return {
            "nome": obj,
            "cidade": latinizeService.latinize(obj.toUpperCase())
          }
        });
      };
    }
    //endregion

    vm.showAdvanced = function () {

      apiService.geocoder(vm.endereco.cep).then(function (res) {
        console.log(res);

        var salvarStorage = {}
        salvarStorage.endereco = res.results[0];

        salvarStorage.location = {
          "lat": res.results[0].geometry.location.lat,
          "long": res.results[0].geometry.location.lng,
        };

        apiService.setStorage('locationAddress', salvarStorage);

        $mdDialog.show({
                         controller: 'enderecoModalController',
                         templateUrl: uri + 'views/endereco/enderecoModal.html',
                         clickOutsideToClose: true
                       })
                 .then(function (answer) {
                   $state.go('farmacias');
                 }, function () {
                   console.log('Close confirma');
                 });

      })

    };

    vm.getMyLocation = function () {
      apiService.delStorage('enderecoLocalizacao');

      apiService.userLocation().then(function (res) {
        var obj = {
          location: {
            "lat": res.lat,
            "long": res.long,
          },
          endereco: {}
        };

        apiService
          .reverseGeocoder(res.lat, res.long)
          .then(function (res) {
            if (res.status == "OK") {
              obj.endereco = res.results[0];
              apiService.setStorage('locationAddress', obj);

              $state.go('farmacias');
            }
          })

      }, function (err) {
        if (err.code == 1) {
          $mdDialog.confirm()
                   .title('Ops!')
                   .textContent('Parece que você não liberou acesso a sua localização, então teremos problemas em achar você.')
                   .ariaLabel('Confirmar erro GPS')
                   .ok('Ok');
        }

        if (err.code == 2 || err.code == 3) {
          $mdDialog.confirm()
                   .title('Ops!')
                   .textContent('Não conseguimos encontrar a sua localização, seu GPS está ligado?.')
                   .ariaLabel('Erro sinal de GPS não encontrado')
                   .ok('Ok');
        }
      })
    }

    vm.checkCep = function (endereco) {
      $rootScope.angularNotLoaded = true;
      var rua = endereco.endereco + " - " + endereco.cidade + "/" + endereco.estado;

      apiService.geocoder(rua).then(function (res) {
        if (res.status == "OK") {

          console.log(res);
          
          var salvarStorage = {}
          salvarStorage.endereco = res.results[0];
          salvarStorage.location = {
            "lat": res.results[0].geometry.location.lat,
            "long": res.results[0].geometry.location.lng,
          };
          apiService.setStorage('locationAddress', salvarStorage);

          $rootScope.angularNotLoaded = false;

          $state.go('farmacias');

        } else {
          $mdDialog.confirm()
                   .title('Ops!')
                   .textContent('Parece que não foi encontrado esse endereço, você o digitou corretamente?.')
                   .ariaLabel('Endereço não encontrado')
                   .ok('Ok');
        }
      })
    }

  }

})(angular);